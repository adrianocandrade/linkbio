<?php

namespace Sandy\Blocks\booking\Helper;

use App\User;
use Carbon\Carbon;
use App\Models\Salon as SalonModel;
use Sandy\Blocks\booking\Helper\Time;
use Sandy\Blocks\booking\Models\Booking;
use Sandy\Blocks\booking\Models\BookingOrder;
use Sandy\Blocks\booking\Models\BookingService;

class SandyBooking{

    public $user;
    public $workspace_id;  // ✅ Adicionar workspace_id

    public $charge;
    public $trx;
    public $booking;

    public $time;
    public $date;
    public $services = [];
    public $price;
    public $customer;

    public $charge_customer = false;

    public function __construct($user_id) {
        $this->user = User::where('id', $user_id)->first();
    }

    public function setTime($time){
        $time = explode('-', $time);

        if(!empty($this->services)){
            
            $end_time = 0;
            // ✅ OTIMIZAÇÃO: Buscar todos os serviços de uma vez ao invés de query por query
            $workspaceId = $this->workspace_id ?? null;
            $servicesQuery = BookingService::whereIn('id', $this->services)
                ->where('user', $this->user->id);
            
            if ($workspaceId) {
                $servicesQuery->where('workspace_id', $workspaceId);
            }
            
            $services = $servicesQuery->get()->keyBy('id');
            
            foreach($this->services as $key => $serviceId){
                if($service = $services->get($serviceId)){
                    $this->price += $service->price;
                    $end_time += $service->duration;
                }
            }

            $time[1] = $time[0] + $end_time;
        }

        $time = implode('-', $time);
        $this->time = $time;


        return $this;
    }

    public function setDate($date){
        $this->date = $date;
        return $this;
    }

    public function setServices($ids){
        $this->services = $ids;
        
        return $this;
    }

    public function setPrice($price){
        $this->price = $price;
        return $this;
    }

    public function setCustomer($id){
        if(!$this->customer = User::where('id', $id)->first()){
            return $this;
        }

        return $this;
    }

    public function setWorkspaceId($workspace_id){
        $this->workspace_id = $workspace_id;
        return $this;
    }

    public function setTrx($extra = []){
        $method = 'Manual';

        $order = new BookingOrder;
        $order->user_id = $this->user->id;
        $order->customer_id = $this->customer->id;
        $order->appointment_id = null;
        $order->extra = $extra;
        $order->method = $method;
        $order->currency = ao($this->user->payments, 'currency');
        $order->ref = \Str::random(7);
        $order->price = $this->price;
        $order->status = 0;
        $order->save();

        $this->trx = $order;

        return $this;
    }

    public function save($settings = [], $function = false){
        // ✅ Obter workspace_id - para bookings públicos, usar workspace do bio; para admin, usar sessão
        $workspaceId = $this->workspace_id ?? null;
        
        if (!$workspaceId) {
            // Tentar via sessão
            if (session()->has('active_workspace_id')) {
                $workspaceId = session('active_workspace_id');
            }
        }
        
        if (!$workspaceId) {
            // Tentar via view compartilhada
            try {
                $workspace = \View::shared('workspace');
                if ($workspace && is_object($workspace) && isset($workspace->id)) {
                    $workspaceId = $workspace->id;
                }
            } catch (\Exception $e) {
                // Continuar com fallback
            }
        }
        
        // Fallback: default workspace
        if (!$workspaceId) {
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->where('status', 1)
                ->first();
            if ($defaultWorkspace) {
                $workspaceId = $defaultWorkspace->id;
            }
        }

        $time_class = new Time($this->user->id, $workspaceId);
        $status = 0;

        if($this->charge_customer && !ao($this->charge, 'status')){
            return $this->return_array(false, ao($this->charge, 'response'));
        }

        if($this->charge_customer && ao($this->charge, 'status')){
            $status = 1;
        }

        if($time_class->check_time($this->time, $this->date)){
            return $this->return_array(false, __('This time has already been booked.'));
        }

        \Log::info('=== SAVING BOOKING ===', [
            'user_id' => $this->user->id,
            'workspace_id' => $workspaceId,
            'customer_id' => $this->customer->id,
            'date' => $this->date,
            'time' => $this->time,
            'services' => $this->services,
            'price' => $this->price,
        ]);

        $appointment = new Booking;
        $appointment->user = $this->user->id;
        $appointment->workspace_id = $workspaceId;  // ✅ Adicionar workspace_id
        $appointment->payee_user_id = $this->customer->id;
        $appointment->service_ids = $this->services;
        $appointment->date = $this->date;
        $appointment->price = $this->price;
        $appointment->is_paid = $status;
        $appointment->settings = $settings;
        $appointment->time = $this->time;
        $appointment->save();

        $this->booking = $appointment;

        // Send Notifcations
        $this->notify();
        
        if($this->trx){
            
            $this->trx->appointment_id = $this->booking->id;
            $this->trx->update();
        }

        if ($function) {
            return $function($this->booking);
        }

        return $this->return_array(true, $this->booking);
    }

    public function notify(){


        return ;
        $notify = new Notifications($this->salon->id);

        $notify->setKey('customer.appointment_created')->setAppointment($this->booking->id, true)->setReceiver('customer')->send();

        // Send To Barber
        $notify->setKey('barber.appointment_created')->setAppointment($this->booking->id, true)->setReceiver('barber')->send();
    }



    public function return_array($status, $response) {
        return ['status' => $status, 'response' => $response];
    }
}
