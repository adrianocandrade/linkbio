<?php

namespace Sandy\Blocks\booking\Models;

use Sandy\Blocks\booking\Helper\Time;
use Illuminate\Database\Eloquent\Model;
use Sandy\Blocks\booking\Models\BookingService;

class Booking extends Model
{
	protected $appends = ['start_time', 'end_time', 'status_text', 'services', 'services_name', 'nice_start_time', 'nice_end_time'];

	protected $fillable = [
		'user',
		'workspace_id',  // ✅ Adicionar workspace_id
		'payee_user_id',
		'service_ids',
		'date',
		'time',
		'settings',
		'info',
		'pay_info'
	];

	protected $casts = [
		'service_ids' => 'array',
		'settings' => 'array'
	];

	protected $table = 'booking_appointments';
	
	public function getStatusTextAttribute(){
		switch ($this->appointment_status) {
			case 0:
				return __('Pending');
			break;
			case 1:
				return __('Completed');
			break;
			case 2:
				return __('Canceled');
			break;
		}


		return 'error';
	}
	
	public function getServicesAttribute()
	{
		$services = [];
		$item = $this;

		if(!empty($item->service_ids) && is_array($item->service_ids)){
			foreach ($item->service_ids as $key => $value) {
				/*if($service = Service::find($value)){
					$services[$key] = $service;

					if ($after_hour = AfterHourService::where('barber_id', $item->barber_id)->where('service_id', $service->id)->first()) {
						$services[$key]['price'] = $after_hour->price;
					}
				}*/
			}
		}


        return $services;
	}
	
	public function getServicesNameAttribute()
	{
		$services = [];
		$item = $this;

		if(!empty($item->service_ids) && is_array($item->service_ids)){
			// ✅ Filtrar serviços por workspace_id se disponível
			$servicesQuery = BookingService::whereIn('id', $item->service_ids)
				->where('user', $item->user);
			
			if ($item->workspace_id) {
				$servicesQuery->where('workspace_id', $item->workspace_id);
			}
			
			$items = $servicesQuery->get();

			foreach ($items as $i) {
				$services[] = $i->name;
			}
		}

		$services = implode(', ', $services);


        return $services;
	}

	public function getStartTimeAttribute()
	{
        try{
            $times = explode('-', $this->time);

            return (int) $times[0];
        }catch(\Exception $e){

        }

        return false;
	}
	
	public function getEndTimeAttribute()
	{
        try{
            $times = explode('-', $this->time);

            return (int) $times[1];
        }catch(\Exception $e){

        }

        return false;
	}

	
	public function getNiceStartTimeAttribute()
	{
        try{
            $times = explode('-', $this->time);
			$time = (int) $times[0];
			$time = (new Time($this->user))->format_minutes($time);
            return $time;
        }catch(\Exception $e){

        }

        return false;
	}
	
	public function getNiceEndTimeAttribute()
	{
        try{
            $times = explode('-', $this->time);
			$time = (int) $times[1];
			$time = (new Time($this->user))->format_minutes($time);
            return $time;
        }catch(\Exception $e){

        }

        return false;
	}
}
