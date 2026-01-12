<?php

namespace Sandy\Blocks\booking\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Carbon\CarbonPeriod;
use Sandy\Blocks\booking\Helper\Time;
use Sandy\Blocks\booking\Models\Booking;
use Sandy\Blocks\booking\Models\BookingService;
use Sandy\Blocks\booking\Models\BookingWorkingBreak;

class Calendar extends Component
{

    public $user_id;
    public $user;
    public $workspace_id;  // ✅ Adicionar workspace_id
    
    public $date;
    public $booking;

    public $calendar_head; // ✅ Agora contém apenas uma semana (7 dias)
    
    public $breaksForDay; // ✅ Cache dos breaks do dia atual para otimização
    
    public $weekStart; // ✅ Início da semana atual
    public $weekEnd;   // ✅ Fim da semana atual

    public $config;


    protected $rules = [

        'services.*.name' => 'required',
        'services.*.duration' => 'required|numeric',
        'services.*.price' => 'required|numeric',

    ];

    public function mount(){
        $this->date = Carbon::now();
        
        // ✅ Validar se user_id foi fornecido
        if (!$this->user_id) {
            abort(404, __('User not found.'));
        }
        
        // ✅ Otimização: Buscar usuário (booking é um campo JSON, não relacionamento)
        $this->user = \App\User::find($this->user_id);
        
        // ✅ Validar se usuário existe
        if (!$this->user) {
            abort(404, __('User not found.'));
        }

        // ✅ Usar workspace da sessão (selecionado pelo usuário)
        $sessionWorkspaceId = session('active_workspace_id');
        
        if ($sessionWorkspaceId) {
            $workspace = \App\Models\Workspace::where('id', $sessionWorkspaceId)
                ->where('user_id', $this->user->id)
                ->where('status', 1)
                ->first();
            
            $this->workspace_id = $workspace ? $workspace->id : null;
        }
        
        // ✅ Fallback: se não houver workspace na sessão, usar default
        if (!$this->workspace_id) {
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->where('status', 1)
                ->first();
            $this->workspace_id = $defaultWorkspace ? $defaultWorkspace->id : null;
        }
        
        $this->config = [
            'interval' => ao($this->user->booking, 'time_interval') ?? 30
        ];

        // ✅ Definir início e fim da semana atual
        $this->setWeekRange($this->date);
        
        $this->refresh();
    }
    
    /**
     * ✅ Define o início e fim da semana baseado na data atual
     */
    protected function setWeekRange($date) {
        if (!$date instanceof Carbon) {
            $date = Carbon::parse($date);
        }
        
        // ✅ CRÍTICO: Garantir que estamos trabalhando com uma data limpa
        $dateString = $date->format('Y-m-d');
        
        // ✅ Criar novos objetos Carbon para evitar problemas de referência
        $this->weekStart = Carbon::parse($dateString)->startOfWeek(Carbon::MONDAY);
        $this->weekEnd = $this->weekStart->copy()->endOfWeek(Carbon::SUNDAY);
        
        // ✅ Garantir que são objetos Carbon válidos
        if (!$this->weekStart || !$this->weekEnd) {
            $this->weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
            $this->weekEnd = $this->weekStart->copy()->endOfWeek(Carbon::SUNDAY);
        }
    }

    public function create_break($date, $start_time, $end_time){
        try {
            // ✅ Validar parâmetros
            if (empty($date) || empty($start_time) || empty($end_time)) {
                session()->flash('error', __('Invalid parameters for creating break.'));
                return;
            }
            
            $time = implode('-', [$start_time, $end_time]);
                
            $break = new BookingWorkingBreak;
            $break->user = $this->user->id;
            $break->workspace_id = $this->workspace_id;  // ✅ Adicionar workspace_id
            $break->date = $date;
            $break->time = $time;
            $break->save();
            
            // ✅ Atualizar a data atual se necessário
            if ($this->date->format('Y-m-d') != $date) {
                $this->date = Carbon::parse($date);
            }
            
            $this->refresh();
            
            session()->flash('success', __('Break added successfully.'));
        } catch (\Exception $e) {
            session()->flash('error', __('Error adding break: ') . $e->getMessage());
        }
    }

    public function remove_break($breaks){
        try {
            // ✅ Aceitar tanto string JSON quanto array
            if (is_string($breaks)) {
                $breaks = json_decode($breaks, true);
            }
            
            if (empty($breaks) || !is_array($breaks)) {
                session()->flash('error', __('Invalid break IDs.'));
                return;
            }

            BookingWorkingBreak::where('user', $this->user->id)
                ->when($this->workspace_id, function ($query) {
                    return $query->where('workspace_id', $this->workspace_id);
                })
                ->whereIn('id', $breaks)
                ->delete();

            $this->refresh();
            
            session()->flash('success', __('Break removed successfully.'));
        } catch (\Exception $e) {
            session()->flash('error', __('Error removing break: ') . $e->getMessage());
        }
    }

    public function create(){
        // ✅ Corrigido: Validação e criação de breaks
        $this->validate([
            'break_date' => 'required',
            'break_start_time' => 'required',
            'break_end_time' => 'required',
        ]);

        $save = function($date) {
            $start_time = hour2min($this->break_start_time);
            $end_time = hour2min($this->break_end_time);
            $time = implode('-', [$start_time, $end_time]);
            
            $break = new BookingWorkingBreak;  // ✅ Corrigido: BarbersWorkingBreak -> BookingWorkingBreak
            $break->user = $this->user->id;
            $break->workspace_id = $this->workspace_id;  // ✅ Adicionar workspace_id
            $break->date = $date;
            $break->time = $time;
            $break->save();

            return $break;
        };

        $breaks = explode(',', $this->break_date);
        if(!empty($breaks[1])){
            
            $period = CarbonPeriod::create($breaks[0], $breaks[1]);

            foreach ($period as $d) {
                $save($d->format('Y-m-d'));
            }
        } else {
            $save($breaks[0]);
        }

        $this->refresh();
    }

    public function sort($list){

        foreach ($list as $key => $value) {
            
            $value['value'] = (int) $value['value'];
            $value['order'] = (int) $value['order'];
            $update = BookingService::find($value['value']);
            $update->position = $value['order'];
            $update->save();
        }
        
        $this->refresh();
    }

    public function edit($id, $index){
        foreach ($this->services as $item) {
            $item->save();
        }
    }

    public function delete($id){
        if (!$delete = BookingService::where('id', $id)
            ->where('user', $this->user_id)
            ->when($this->workspace_id, function ($query) {
                return $query->where('workspace_id', $this->workspace_id);
            })
            ->first()) {
            return false;
        }
        $delete->delete();
        $this->refresh();
    }
    
    public function change_date($date){
        $this->date = Carbon::parse($date);
        
        // ✅ Se a data selecionada não está na semana atual, ajustar a semana
        if ($this->date->lt($this->weekStart) || $this->date->gt($this->weekEnd)) {
            $this->setWeekRange($this->date);
        }
        
        $this->refresh();

        return $this->getWeekRangeString();
    }
    
    /**
     * ✅ Navegar para a semana anterior
     */
    public function previousWeek() {
        // ✅ CRÍTICO: Criar novo objeto Carbon para não modificar o original
        if (!$this->weekStart) {
            $this->setWeekRange($this->date ?? Carbon::now());
        }
        
        $newWeekStart = $this->weekStart->copy()->subWeek();
        $this->weekStart = $newWeekStart;
        $this->weekEnd = $this->weekStart->copy()->endOfWeek(Carbon::SUNDAY);
        
        // Ajustar a data atual para o primeiro dia da nova semana
        $this->date = $this->weekStart->copy();
        
        $this->refresh();
    }
    
    /**
     * ✅ Navegar para a próxima semana
     */
    public function nextWeek() {
        // ✅ CRÍTICO: Criar novo objeto Carbon para não modificar o original
        if (!$this->weekStart) {
            $this->setWeekRange($this->date ?? Carbon::now());
        }
        
        $newWeekStart = $this->weekStart->copy()->addWeek();
        $this->weekStart = $newWeekStart;
        $this->weekEnd = $this->weekStart->copy()->endOfWeek(Carbon::SUNDAY);
        
        // Ajustar a data atual para o primeiro dia da nova semana
        $this->date = $this->weekStart->copy();
        
        $this->refresh();
    }
    
    /**
     * ✅ Ir para a semana atual
     */
    public function currentWeek() {
        $this->date = Carbon::now();
        $this->setWeekRange($this->date);
        $this->refresh();
    }
    
    /**
     * ✅ Retorna string formatada da semana (ex: "07 - 13 Jan, 2026")
     */
    public function getWeekRangeString() {
        // ✅ Proteção: garantir que weekStart e weekEnd existam
        if (!$this->weekStart || !$this->weekEnd) {
            $this->setWeekRange($this->date ?? Carbon::now());
        }
        
        $startDay = $this->weekStart->format('d');
        $endDay = $this->weekEnd->format('d');
        $month = $this->weekStart->format('M');
        $year = $this->weekStart->format('Y');
        
        if ($this->weekStart->month != $this->weekEnd->month) {
            // Semana cruza meses
            return "{$startDay} {$this->weekStart->format('M')} - {$endDay} {$this->weekEnd->format('M')}, {$year}";
        }
        
        return "{$startDay} - {$endDay} {$month}, {$year}";
    }

    public function refresh(){
        // ✅ Otimização: Buscar bookings do dia atual selecionado
        $this->booking = Booking::where('user', $this->user->id)
            ->when($this->workspace_id, function ($query) {
                return $query->where('workspace_id', $this->workspace_id);
            })
            ->orderBy('id', "DESC")
            ->whereDate('date', $this->date->toDateString())
            ->get();

        // ✅ OTIMIZAÇÃO CRÍTICA: Carregar todos os breaks do dia de uma vez
        // Isso evita N+1 queries na view
        $dateString = $this->date->toDateString();
        $this->breaksForDay = BookingWorkingBreak::where('user', $this->user->id)
            ->where('date', $dateString)
            ->when($this->workspace_id, function ($query) {
                return $query->where('workspace_id', $this->workspace_id);
            })
            ->get()
            ->keyBy(function($break) {
                // Criar chave única baseada no intervalo de tempo
                return $break->time;
            });

        // ✅ Carregar apenas a semana atual (7 dias ao invés de mês inteiro)
        $this->calendar_head = $this->generate_weekly_calendar();
    }

    

    /**
     * ✅ NOVO: Gera calendário apenas para a semana atual (7 dias)
     * Isso reduz drasticamente o número de iterações e queries
     */
    public function generate_weekly_calendar(){
        $timeClass = new Time($this->user->id, $this->workspace_id);
        
        \Log::info('=== GENERATING CALENDAR ===', [
            'user_id' => $this->user->id,
            'workspace_id' => $this->workspace_id,
            'week_start' => $this->weekStart->toDateString(),
            'week_end' => $this->weekEnd->toDateString(),
        ]);
        
        // ✅ OTIMIZAÇÃO: Buscar todos os bookings da semana em uma única query
        $weekBookings = Booking::where('user', $this->user->id)
            ->when($this->workspace_id, function ($query) {
                return $query->where('workspace_id', $this->workspace_id);
            })
            ->whereBetween('date', [$this->weekStart->toDateString(), $this->weekEnd->toDateString()])
            ->get()
            ->groupBy(function($booking) {
                return Carbon::parse($booking->date)->format('Y-m-d');
            });
        
        \Log::info('=== BOOKINGS FOUND ===', [
            'count' => $weekBookings->flatten()->count(),
            'dates' => $weekBookings->keys()->toArray(),
        ]);
        
        $data = [];
        $currentDate = $this->weekStart->copy();
        
        // ✅ Loop apenas para 7 dias (uma semana)
        for ($i = 0; $i < 7; $i++) {
            $formatDate = $currentDate->toDateString();
            $dayOfWeek = $currentDate->format('N'); // 1 (segunda) a 7 (domingo)
            
            // ✅ Verificar se há horários configurados para este dia
            $day_id = $timeClass->get_day_id($currentDate->format('l'));
            $slot = $timeClass->get_timeslot_by_day($day_id, $this->user->id);
            $hasWorkHours = !empty($slot) && ao($slot, 'enable');
            
            // ✅ Usar bookings já carregados ao invés de fazer query por dia
            $bookingsForDay = $weekBookings->get($formatDate, collect());
            $bookingsCount = $bookingsForDay->count();
            
            $day_status = '';
            if ($hasWorkHours && $bookingsCount > 0) {
                // Mostrar indicador visual se houver bookings (limitado a 100%)
                $percentage = min(100, ($bookingsCount * 10)); // Aproximação simples
                $day_status = '<div class="day-available" style="width: ' . $percentage . '%;"></div>';
            }
            
            $data[] = [
                'day' => $currentDate->format('D'),
                'day_digit' => $currentDate->format('j'),
                'active' => $hasWorkHours,
                'week_day' => $dayOfWeek,
                'date' => $formatDate,
                'day_status' => $day_status,
                'is_today' => $currentDate->isToday(),
                'month_name' => $currentDate->format('M'),
            ];
            
            // Avançar para o próximo dia
            $currentDate->addDay();
        }

        return $data;
    }

    public function render(){

        return view('Blocks-booking::mix.livewire.calendar');
    }
}
