<?php

namespace Sandy\Blocks\booking\Livewire;

use App\Payments;
use Carbon\Carbon;
use Aws\Api\Service;
use Livewire\Component;
use Carbon\CarbonPeriod;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\View;
use Sandy\Blocks\booking\Helper\Time;
use Modules\Bio\Http\Traits\BioTraits;
use Sandy\Blocks\booking\Helper\SandyBooking;
use Sandy\Blocks\booking\Models\BookingService;

class Booking extends Component{

    use BioTraits;

    public $user_id;
    public $workspace_id;
    public $user;
    public $bio_slug;
    public $bio;

    public $date;
    public $date_status;

    public $services;
    public $dates;
    public $times;

    public $time;
    public $service = [];
    public $price = 0;
    
    // Guest Modal Properties
    public $showGuestModal = false;
    public $guestName;
    public $guestEmail;
    public $guestPhone;

    
    public function __construct(){
        View::composer('*', function ($view){
            View::share('sandy', $this);
        });
    }


    
    protected $rules = [

        'time' => 'required',
        'date' => 'required',
        'service' => 'required',

    ];


    private $timeClass;

    public function mount(){


        $this->date = Carbon::now();
        $this->user = \App\User::find($this->user_id);
        $this->bio = $this->user;

        // ✅ Obter workspace_id do contexto público (bio)
        $workspaceId = $this->workspace_id;
        
        // Capturar slug atual
        $this->bio_slug = request()->route('bio') ?? request()->get('bio');
        
        // Se não foi passado como parâmetro, tentar várias formas de obter o workspace
        if (!$workspaceId) {
            // 1. Via request attributes (setado pelo middleware/trait)
            if (request()->attributes->has('workspace')) {
                $workspace = request()->attributes->get('workspace');
                if ($workspace && is_object($workspace) && isset($workspace->id)) {
                    $workspaceId = $workspace->id;
                    if (!$this->bio_slug) $this->bio_slug = $workspace->slug;
                }
            }
            
            // 2. Via view compartilhada (se disponível)
            if (!$workspaceId) {
                try {
                    $workspace = \View::shared('workspace');
                    if ($workspace && is_object($workspace) && isset($workspace->id)) {
                        $workspaceId = $workspace->id;
                        if (!$this->bio_slug) $this->bio_slug = $workspace->slug;
                    }
                } catch (\Exception $e) {
                    // Ignorar erro, continuar
                }
            }
            
            // 3. Buscar pelo slug na URL (se disponível)
            if (!$workspaceId && request()->has('bio')) {
                $bioSlug = request()->get('bio');
                $workspace = \App\Models\Workspace::where('slug', $bioSlug)
                    ->where('status', 1)
                    ->first();
                if ($workspace) {
                    $workspaceId = $workspace->id;
                    $this->bio_slug = $bioSlug;
                }
            }
            
            // 4. Fallback: default workspace do usuário
            if (!$workspaceId) {
                $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                    ->where('is_default', 1)
                    ->where('status', 1)
                    ->first();
                if ($defaultWorkspace) {
                    $workspaceId = $defaultWorkspace->id;
                    if (!$this->bio_slug) $this->bio_slug = $defaultWorkspace->slug; // Assumindo que workspace padrão tem slug
                }
            }
        }
        
        // Se ainda não temos slug, tentar username do usuário (fallback final para sistemas sem workspace)
        if (!$this->bio_slug && $this->user) {
             $this->bio_slug = $this->user->username ?? $this->user->slug ?? null;
        }

        // Salvar workspace_id como propriedade
        $this->workspace_id = $workspaceId;

        $this->services = BookingService::where('user', $this->user_id)
            ->where('workspace_id', $workspaceId) // ✅ Filtro Estrito: Se null, traz apenas legados (null), nunca de outros workspaces
            ->orderBy('position', 'ASC')
            ->orderBy('id', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        // ✅ Passar workspace_id para Time class
        $this->timeClass = new Time($this->user->id, $this->workspace_id);

        $this->setDates($this->date);

        $this->refresh();
        
        // ✅ Validar se há serviços disponíveis
        if ($this->services->isEmpty()) {
            \Log::warning('Booking: No services found', [
                'user_id' => $this->user_id,
                'workspace_id' => $this->workspace_id,
            ]);
            
            session()->flash('error', __('No services available for booking at this time. Please contact the service provider.'));
        }
    }


    public function setDates($date){
        $date = Carbon::parse($date);
        $from = Carbon::now()->toDateString();
        $to = Carbon::parse($date)->endOfMonth()->toDateString();
        
        if (Carbon::now()->format('Y-m') == Carbon::parse($date)->format('Y-m')) {
            $from = Carbon::now()->toDateString();
        }

        $this->setTimes($this->date);
        $this->dates = $this->ranges($from, $to);
    }

    public function setTimes($date){
        // ✅ Passar workspace_id para garantir isolamento na verificação de horários
        $timeClass = new Time($this->user->id, $this->workspace_id);
        $date = Carbon::parse($date);

        $time = $timeClass->get_time($date->format('Y-m-d'));
        if (empty(ao($time, 'times'))) {
            \Log::info('Booking: No times available for date', [
                'date' => $date->format('Y-m-d'),
                'user_id' => $this->user_id,
            ]);
            
            $this->times = [];
            $this->date_status = false;
            $this->date = $date;
            return;
        }
        $return = [];

        foreach (ao($time, 'times') as $key => $time_slot) {
            $check =  $timeClass->check_time(ao($time_slot, 'time_value'), ao($time, 'date'));
            $return[$key] = $time_slot;
            $return[$key]['check'] = $check;
        }

        $this->set_day_status();

        $this->date = $date;
        $this->times = $return;
    }

    public function charge_booking($price){
        if(!$auth = \Auth::user()){
            return false;
        }

        $sxref = uniqid(time());
        $method = ao($this->user->payments, 'default');
        
        // ✅ Passar slug para callback se necessário
        $routeParams = ['sxref' => $sxref];
        if ($this->bio_slug) {
            $routeParams['bio'] = $this->bio_slug;
        }
        $callback = \Bio::route($this->user->id, 'sandy-blocks-booking-validate-booking', $routeParams);

        $item = [
            'name' => __('Booking Appointment'),
            'description' => __('Booked an appointment on :page', ['page' => $this->user->name]),
        ];
        $amount = 200;

        $meta = [
            'bio_id' => $this->user->id,
            'workspace_id' => $this->workspace_id,  // ✅ Adicionar workspace_id ao meta
            'item' => $item,
            'date' => $this->date,
            'time' => $this->time,
            'services' => $this->service,
            'customer' => $auth->id
        ];

        $data = [
            'method' => $method,
            'email' => $auth->email,
            'price' => $amount,
            'callback' => $callback,
            'currency' => ao($this->user->payments, 'currency')
        ];

        $keys = user("payments.$method", $this->user->id);

        $create = (new Payments)->create($sxref, $data, $keys, $meta);

        // Return the gateway
        return $create;
    }

    public function createBooking(){
        file_put_contents(storage_path('logs/debug_booking.log'), date('Y-m-d H:i:s') . " - CreateBooking ID: " . uniqid() . " STARTED\n", FILE_APPEND);
        \Log::info("CreateBooking iniciado");
        \Log::info('=== BOOKING START ===', [
            'user_id' => $this->user_id,
            'workspace_id' => $this->workspace_id,
            'service' => $this->service,
            'time' => $this->time,
            'date' => $this->date ? $this->date->format('Y-m-d') : null,
        ]);
        
        // ✅ Melhorar validação com mensagens personalizadas
        try {
            $this->validate([
                'time' => 'required',
                'date' => 'required|date|after_or_equal:today',
                'service' => 'required|array|min:1',
            ], [
                'time.required' => __('Please select a time slot.'),
                'date.required' => __('Please select a date.'),
                'date.after_or_equal' => __('Selected date cannot be in the past.'),
                'service.required' => __('Please select at least one service.'),
                'service.min' => __('Please select at least one service.'),
            ]);
            \Log::info('Validation passed');
        } catch (\Exception $e) {
            \Log::error('Validation failed', ['error' => $e->getMessage()]);
            throw $e;
        }

        if(!$auth = \Auth::user()){
            \Log::info('User not authenticated, opening guest modal');
            // Ao invés de redirecionar, abrir modal
            $this->showGuestModal = true;
            return;
        }
        
        \Log::info('User authenticated', ['user_id' => $auth->id]);

        // ✅ Validar se serviços estão disponíveis
        if (empty($this->service)) {
            $this->addError('service', __('Please select at least one service.'));
            return;
        }

        // ✅ OTIMIZAÇÃO: Buscar todos os serviços de uma vez ao invés de query por query
        $price = 0;
        $validServices = [];
        
        $servicesQuery = BookingService::whereIn('id', $this->service)
            ->where('user', $this->user_id);
        
        if ($this->workspace_id) {
            $servicesQuery->where('workspace_id', $this->workspace_id);
        }
        
        $services = $servicesQuery->get()->keyBy('id');
        
        foreach ($this->service as $key => $serviceId) {
            if ($service = $services->get($serviceId)) {
                $validServices[] = $serviceId;
                $price += $service->price;
            } else {
                // ✅ Mensagem mais específica para serviço inválido
                $this->addError('service', __('One or more selected services are not available.'));
                return;
            }
        }
        
        if (empty($validServices)) {
            $this->addError('service', __('No valid services selected.'));
            return;
        }
        
        $this->price = $price;
        $this->service = $validServices; // Usar apenas serviços válidos

        // ✅ Validar data não está no passado
        if (Carbon::parse($this->date)->isPast() && !Carbon::parse($this->date)->isToday()) {
            $this->addError('date', __('Selected date cannot be in the past.'));
            return;
        }

        // ✅ Configurar workspace_id no SandyBooking
        $sandybook = new SandyBooking($this->user->id);
        $sandybook->setWorkspaceId($this->workspace_id);

        if($price == 0){
            $result = $sandybook
            ->setServices($this->service)
            ->setTime($this->time)
            ->setDate($this->date)
            ->setCustomer($auth->id)
            ->save();
            
            // ✅ Melhorar feedback de erro do save
            if (isset($result['status']) && !$result['status']) {
                $this->addError('booking', $result['response'] ?? __('Unable to complete booking. Please try again.'));
                return;
            }
            
            // ✅ Usar slug correto para redirecionamento
            $redirectParams = [];
            if ($this->bio_slug) {
                $redirectParams['bio'] = $this->bio_slug;
            }
            $redirect = \Bio::route($this->user->id, 'sandy-blocks-booking-success', $redirectParams);
            return redirect($redirect)->with('success', __('Booking confirmed successfully!'));
        }

        
        \Log::info("CreateBooking FINALIZADO");
        file_put_contents(storage_path('logs/debug_booking.log'), date('Y-m-d H:i:s') . " - CreateBooking FINISHED (Calling charge_booking)\n", FILE_APPEND);
        return $this->charge_booking($price);
    }

    public function refresh(){
    }


    /**
     * Completar booking como cliente (sem autenticação)
     */
    public function completeBookingAsGuest()
    {
        \Log::info('=== GUEST BOOKING START ===', [
            'name' => $this->guestName,
            'email' => $this->guestEmail,
            'phone' => $this->guestPhone,
        ]);
        
        // Validar dados do cliente
        $this->validate([
            'guestName' => 'required|string|max:255',
            'guestEmail' => 'required|email|max:255',
            'guestPhone' => 'required|string|max:50',
        ], [
            'guestName.required' => __('Name is required'),
            'guestEmail.required' => __('Email is required'),
            'guestEmail.email' => __('Please enter a valid email'),
            'guestPhone.required' => __('Phone is required'),
        ]);
        
        try {
            // Criar ou atualizar contato na audience
            $audienceService = app(\Modules\Mix\Services\AudienceService::class);
            
            $contact = $audienceService->createOrUpdateContact([
                'workspace_id' => $this->workspace_id,
                'user_id' => $this->user_id,
                'name' => $this->guestName,
                'email' => $this->guestEmail,
                'phone' => $this->guestPhone,
                'source' => 'booking',
            ]);
            
            \Log::info('Guest contact created', ['contact_id' => $contact->id]);
            
            // Criar booking usando o user_id do dono como customer
            // Os dados do guest ficam no metadata
            $sandybook = new SandyBooking($this->user_id);
            $sandybook->setWorkspaceId($this->workspace_id);
            
            $result = $sandybook
                ->setServices($this->service)
                ->setTime($this->time)
                ->setDate($this->date)
                ->setCustomer($this->user_id) // Usa o dono do workspace
                ->save();
            
            if (isset($result['status']) && !$result['status']) {
                $this->addError('booking', $result['response'] ?? __('Unable to complete booking. Please try again.'));
                return;
            }
            
            // Atualizar o booking com dados do guest contact
            if (isset($result['booking_id'])) {
                \DB::table('booking_appointments')
                    ->where('id', $result['booking_id'])
                    ->update([
                        'guest_contact_id' => $contact->id,
                        'guest_name' => $this->guestName,
                        'guest_email' => $this->guestEmail,
                        'guest_phone' => $this->guestPhone,
                    ]);
            }
            
            // Registrar interação
            $audienceService->recordInteraction(
                $contact->id,
                'booking',
                'created',
                $this->price
            );
            
            \Log::info('Guest booking completed successfully');
            
            // Fechar modal e redirecionar
            $this->showGuestModal = false;
            
            // ✅ Usar slug correto para redirecionamento
            $redirectParams = [];
            if ($this->bio_slug) {
                $redirectParams['bio'] = $this->bio_slug;
            }
            $redirect = \Bio::route($this->user_id, 'sandy-blocks-booking-success', $redirectParams);
            
            session()->flash('success', __('Booking confirmed successfully! Check your email for details.'));
            return redirect($redirect);
            
        } catch (\Exception $e) {
            \Log::error('Guest booking failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->addError('booking', __('An error occurred. Please try again.'));
        }
    }

    
    public function render()
    {

        return view('Blocks-booking::bio.livewire.booking');
    }


    public function set_day_status(){
        $timeClass = new Time($this->user->id, $this->workspace_id);
        
        $day_id = $timeClass->get_day_id(date('l', strtotime($this->date)));
        $this->date_status = true;
        
        if (!ao($this->user->booking, "workhours.$day_id.enable")) {
            $this->date_status = false;
        }
    }
    
    public function ranges($from, $to){
        $timeClass = new Time($this->user->id, $this->workspace_id);
        $ranges = CarbonPeriod::create($from, $to);
        $month = [];
        foreach ($ranges as $item) {
            $date = $item->toDateString();

            $day_id = $timeClass->get_day_id(date('l', strtotime($date)));
            $date_status = false;
            if (!ao($this->user->booking, "workhours.$day_id.enable")) {
                $date_status = true;
            }

            $month[] = [
                'date'          => $item->toDateString(),
                'week'          => ucfirst(str_replace('.', '', $item->translatedFormat('D'))),
                'day'           => $item->format('j'),
                'date_status'   => $date_status
            ];
        }

        return $month;
    }
}
