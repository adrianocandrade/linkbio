<?php

namespace Sandy\Blocks\booking\Models;

use Sandy\Blocks\booking\Helper\Time;
use Illuminate\Database\Eloquent\Model;

class BookingWorkingBreak extends Model
{
	protected $appends = ['start_time', 'end_time', 'nice_start_time', 'nice_end_time'];
	protected $fillable = [
		'user',
		'workspace_id',  // ✅ Adicionar workspace_id
		'date',
		'time',
		'settings'
	];

	protected $casts = [
		'settings' => 'array'
	];

	
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
