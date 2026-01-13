<?php

namespace Sandy\Blocks\booking\Helper;

use App\Models\Appt;
use App\Models\Barber;

use App\Models\Salon as SalonModel;
use Sandy\Blocks\booking\Models\Booking;
use Sandy\Blocks\booking\Models\BookingWorkingBreak;

class Time{
    public $interval = 60;
    public $time = [];
    public $salon;
    public $workspace_id; // ✅ Adicionar propriedade

    public function __construct($user_id = null, $workspace_id = null) {
        $this->workspace_id = $workspace_id; // ✅ Salvar workspace_id
        
        // ✅ Otimização: Usar cache estático para evitar queries repetidas
        if ($user_id) {
            $this->salon = $this->getCachedUser($user_id);
        }

        $this->time = $this->array_time();
    }




    public function minutes_to_hours($time) {
      $hour_type = ao($this->salon->booking, 'hrs_type');//ao($this->salon->booking, 'hrs_type');
      $time = (int) $time;
      if($time){
        $hours = floor($time / 60);
        if($hour_type == '12' && $hours > 12) $hours = $hours - 12;
        return $hours;
      }else{
        return 0;
      }
    }

  public function am_or_pm($minutes) {
    $hour_type = ao($this->salon->booking, 'hrs_type');;
    if($hour_type == '24') return '';
    return ($minutes < 720) ? 'AM' : 'PM';
  }

  public function minutes_to_hours_and_minutes($minutes, $format = '%02d:%02d', $add_ampm = true) {
    if(!$format) $format = '%02d:%02d';
    $minutes = (int) $minutes;

    if ($minutes === '') {
        return;
    }
    $ampm = ($add_ampm) ? $this->am_or_pm($minutes) : '';
    $hours = $this->minutes_to_hours($minutes);

    $minutes = ($minutes % 60);

    return sprintf($format, $hours, $minutes).$ampm;
  }

  public function format_minutes($minutes, $format = '%02d:%02d', $add_ampm = true){
    try {
        $hr = ao($this->salon->booking, 'hrs_type') == 12 ? 'h:i A' : 'H:i';
        return date($hr, mktime(0,$minutes));
        
    } catch (\Exception $th) {
        return $minutes;
    }

    if(!$format) $format = '%02d:%02d';
    $minutes = (int) $minutes;

    if ($minutes === '') {
        return;
    }
    $ampm = ($add_ampm) ? $this->am_or_pm($minutes) : '';
    $hours = $this->minutes_to_hours($minutes);

    $minutes = ($minutes % 60);

    return sprintf($format, $hours, $minutes).$ampm;
  }

  
  public function work_time_to_min($date, $user_id){
        $day = date('l', strtotime($date));
        $day_id = $this->get_day_id($day);
        $slot = $this->get_timeslot_by_day($day_id, $user_id);

        $from = ao($slot, 'from') ?? 540; // Default 9:00 AM
        $to = ao($slot, 'to') ?? 1080;    // Default 6:00 PM
        
        // ✅ CRÍTICO: Validar valores para evitar esgotamento de memória
        $MAX_MINUTES_PER_DAY = 1440;
        $from = max(0, min((int)$from, $MAX_MINUTES_PER_DAY));
        $to = max(0, min((int)$to, $MAX_MINUTES_PER_DAY));
        
        // Se valores inválidos, usar defaults seguros
        if ($to <= $from) {
            $from = 540;
            $to = 1080;
        }
        
        // Limitar duração máxima a 12 horas
        if (($to - $from) > 720) {
            $to = $from + 720;
        }

        return [$from, $to];
  }

    public function array_time(){
        $time = [];
        $open_time = strtotime("00:00");
        $close_time = strtotime("23:59");
        for( $i = $open_time; $i<$close_time; $i += ($this->interval * 60)) {
            $time[date("H:i",$i)] = ['12hr' => date("h:i A",$i), '24hr' => date("H:i",$i), 'raw' => $i];
        }

        return $time;
    }

    public function formatted_time($time){
        $time = strtotime($time);
        if (!$salon = $this->salon) {
            return date("h:i A", $time);
        }

        if (ao($salon->settings, 'hrs_type') == '12') {
            return date("h:i A", $time);
        }


        return date("H:i", $time);
    }

    public function from_to($from = '00:00', $to = '00:00', $key = null){
        // 12 hr
        $from = $this->format_minutes($from);
        $to = $this->format_minutes($to);
        $time = ['from' => $from, 'to' => $to];

        return ao($time, $key);
    }

    public function get_time_all($date, $salon, $location = false){
        if (!$salon = SalonModel::find($salon)) {
            return false;
        }

        // Date
        $date = \Carbon\Carbon::parse($date);
        $max_time = $this->max_barber_time_all($date, $salon, $location);
        if(!$max_time){
            return [];
        }
        $value = [];
        $interval = ao($salon->settings, 'time_interval');

        $from = hour2min(\Carbon\Carbon::parse('08:00')->format('H:i'));
        $to = $max_time;

        $value['date'] = $date;
        $value['times'] = $this->get_time_slots($interval, $from, $to, $salon->id);

        return $value;
    }


    public function max_time_all($date){
        // End time
        $date = \Carbon\Carbon::parse($date);
        $end_time = [];

        $day = $this->get_day_id(date('l', strtotime($date->format('Y-m-d'))));
        if (ao($this->salon->booking, "workhours.$day.enable")) {
            $end_time[] = (int) ao($this->salon->booking, "workhours.$day.to");
        }

        $max_time = 0;
        if(!empty($end_time)){
            $max_time = max($end_time);
        }

        return $max_time;
    }
    

    public function min_time_all($date){
        // End time
        $date = \Carbon\Carbon::parse($date);
        $times = [];
        $day = $this->get_day_id(date('l', strtotime($date->format('Y-m-d'))));
            
        if (ao($this->salon->booking, "workhours.$day.enable")) {
            $times[] = (int) ao($this->salon->booking, "workhours.$day.from");
        }

        $time = 0;
        if(!empty($times)){
            $time = min($times);
        }

        return $time;
    }

    public function get_time($date){
        $day = date('l', strtotime($date));
        $day_id = $this->get_day_id($day);

        $value = [];
        $interval = ao($this->salon->booking, 'time_interval');

        $slot = $this->get_timeslot_by_day($day_id, $this->salon->id);
        $value['times'] = $this->get_time_slots($interval, ao($slot, 'from'), ao($slot, 'to'));

        $value['day_id'] = $day_id;
        $value['date'] = $date;

        return $value;
    }

    public function get_custom_time($date, $salon, $barber, $from, $to){
        if (!$salon = SalonModel::find($salon)) {
            return false;
        }

        $day = date('l', strtotime($date));
        $day_id = $this->get_day_id($day);

        $value = [];
        $interval = ao($salon->settings, 'time_interval');

        $value['times'] = $this->get_time_slots($interval, $from, $to, $salon->id);

        $value['day_id'] = $day_id;
        $value['date'] = $date;

        return $value;
    }


    public function get_day_id($day)
    {
        if ($day == 'Monday') {
            return 1;
        } else if($day == 'Tuesday') {
            return 2;
        }else if($day == 'Wednesday') {
            return 3;
        }else if($day == 'Thursday') {
            return 4;
        }else if($day == 'Friday') {
            return 5;
        }else if($day == 'Saturday') {
            return 6;
        }else if($day == 'Sunday') {
            return 7;
        }
    }


    public function get_id_day($day, $short = false)
    {
        if ($day == 1) {
            $ret = 'Monday';
        } else if($day == 2) {
            $ret = 'Tuesday';
        }else if($day == 3) {
            $ret = 'Wednesday';
        }else if($day == 4) {
            $ret = 'Thursday';
        }else if($day == 5) {
            $ret = 'Friday';
        }else if($day == 6) {
            $ret = 'Saturday';
        }else if($day == 7) {
            $ret = 'Sunday';
        }

        if ($short) {
            $ret = \Str::limit($ret, 3, '');
        }



        return $ret;
    }

    public function get_days_array(){

        return [1 => __('Mon'), 2 => __('Tue'), 3 => __('Wed'), 4 => __("Thu"), 5 => __('Fri'), 6 => __('Sat'), 7 => __('Sun')];
    }

    public function get(){

        $time = [];
        foreach($this->time as $key => $value){
            $time[$key] = ao($value, '12hr');
        }

        return $time;
    }

    // ✅ Cache estático para evitar múltiplas queries do mesmo usuário
    protected static $userCache = [];
    
    protected function getCachedUser($user_id) {
        if (!isset(static::$userCache[$user_id])) {
            // ✅ Otimização: Cache do usuário (booking é um campo JSON, não relacionamento)
            static::$userCache[$user_id] = \App\User::find($user_id);
        }
        return static::$userCache[$user_id];
    }

    public function get_timeslot_by_day($day, $user_id){
        // ✅ Usar cache para evitar queries repetidas do mesmo usuário
        if(!$user = $this->getCachedUser($user_id)){
            return [];
        }

        if (!ao($user->booking, "workhours.$day.enable")) {
            return [];
        }

        try {
            $slot = $user->booking['workhours'][$day];
            
            // ✅ CRÍTICO: Validar e corrigir valores absurdos que causam esgotamento de memória
            // Um dia tem máximo 1440 minutos (24 horas)
            $MAX_MINUTES_PER_DAY = 1440;
            
            if (isset($slot['from'])) {
                $slot['from'] = max(0, min((int)$slot['from'], $MAX_MINUTES_PER_DAY));
            }
            
            if (isset($slot['to'])) {
                $slot['to'] = max(0, min((int)$slot['to'], $MAX_MINUTES_PER_DAY));
            }
            
            // Se o horário final for menor ou igual ao inicial, corrigir
            if (isset($slot['from']) && isset($slot['to']) && $slot['to'] <= $slot['from']) {
                $slot['from'] = 540; // 9:00 AM
                $slot['to'] = 1080;  // 6:00 PM
            }
            
            // ✅ Limitar duração máxima para 12 horas (720 minutos)
            if (isset($slot['from']) && isset($slot['to'])) {
                $duration = $slot['to'] - $slot['from'];
                if ($duration > 720) {
                    $slot['to'] = $slot['from'] + 720;
                }
            }
            
            return $slot;
        } catch (\Exception $th) {
            return [];
        }
    }

    public function check_workday($day, $user_id){
        //$day = \Carbon\Carbon::parse($date);

        $day = $this->get_day_id($day);
        
        // ✅ Usar cache para evitar queries repetidas do mesmo usuário
        if(!$user = $this->getCachedUser($user_id)){
            return false;
        }

        if (!ao($user->booking, "workhours.$day.enable")) {
            return false;
        }

        try {
            return $user->booking['workhours'][$day];
        } catch (\Exception $th) {
            return false;
        }
    }

    public function get_time_slots($interval='', $start_time='', $end_time=''){
        $time = [];

        // ✅ CRÍTICO: Validar valores para evitar loops infinitos
        $MAX_MINUTES_PER_DAY = 1440;
        $MAX_DURATION = 720; // 12 horas máximo
        
        $start_time = max(0, min((int)$start_time, $MAX_MINUTES_PER_DAY));
        $end_time = max(0, min((int)$end_time, $MAX_MINUTES_PER_DAY));
        
        if ($end_time <= $start_time || ($end_time - $start_time) > $MAX_DURATION) {
            // Valores inválidos, retornar vazio ou valores padrão seguros
            return [];
        }
        
        $interval = max(15, min((int)$interval, 60)); // Intervalo entre 15 e 60 minutos

        $_this = $this;

        // ✅ Proteção adicional: limitar iterações máximas
        $max_iterations = 288; // 12 horas / 15 minutos = 288 períodos máximo
        $iterations = 0;

        for($minutes = $start_time; $minutes <= $end_time && $iterations < $max_iterations; $minutes += $interval){
            $iterations++;
            $start = $minutes;
            $end = $minutes + $interval;

            $start_formatted = $_this->minutes_to_hours_and_minutes($start);
            $end_formatted = $_this->minutes_to_hours_and_minutes($start);


            $time[$minutes]['start_time'] = $start_formatted;
            $time[$minutes]['end_time'] = $end_formatted;

            
            $time[$minutes]['time_value'] = "$start-$end";
            $time[$minutes]['time_view'] = str_replace(' ', '', "$start_formatted-$end_formatted");
        }

        return $time;
        $start = new \DateTime($start_time);
        $end = new \DateTime($end_time);
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');
        $i=0;
        $time = [];
        while(strtotime($startTime) <= strtotime($endTime)){
            $start = $startTime;
            $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
            $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
            $i++;
            if(strtotime($startTime) <= strtotime($endTime)){
                $time[$i]['start_time'] = $start;
                $time[$i]['end_time'] = $end;
            }
        }
        return $time;
    }
    
    public function check_break_time($time_val, $date, $user_id, $workspace_id = null){
        $status = false;
        
        // ✅ Usar cache para evitar queries repetidas do mesmo usuário
        if(!$user = $this->getCachedUser($user_id)){
            return false;
        }

        // ✅ Otimização: Cache dos breaks por date para evitar múltiplas queries
        static $breaksCache = [];
        $cacheKey = "{$user_id}_{$date}" . ($workspace_id ? "_{$workspace_id}" : '');
        
        if (!isset($breaksCache[$cacheKey])) {
            $breaks = BookingWorkingBreak::where('user', $user_id)
                ->where('date', $date)
                ->when($workspace_id, function ($query) use ($workspace_id) {
                    return $query->where('workspace_id', $workspace_id);
                })
                ->get();
            $breaksCache[$cacheKey] = $breaks;
        } else {
            $breaks = $breaksCache[$cacheKey];
        }
        $time_val = explode('-', $time_val);

        $array = [];

        foreach ($breaks as $break) {
            $break_time = explode('-', $break->time);
            $break_start_time = $break_time[0];
            $break_end_time = $break_time[1];


            $start_time = $time_val[0];
            $end_time = $time_val[1];

            // comparing datetime objects
            if (
                ($break_start_time <= $start_time and $break_end_time > $start_time) // if intersecting through time slot start
                or
                ($break_start_time < $end_time and $break_end_time >= $end_time) // if intersecting through time slot end
                or
                ($break_start_time <= $start_time and $break_end_time >= $end_time) // if compare covers us
                or
                ($break_start_time >= $start_time and $break_end_time <= $end_time) // if we contain compare
            ) {
                $array[] = $break->id;
            }
        }

        if(!empty($array)){
            return $array;
        }

        return false;


        return $status;
    }

    public function check_time($time_val, $date){
        $status = false;

        // ✅ Filtrar bookings por workspace (isolamento)
        $appointments = Booking::where('user', $this->salon->id)
            ->where('date', $date)
            ->when($this->workspace_id, function($q) {
                return $q->where('workspace_id', $this->workspace_id);
            })
            ->get();
            
        // ✅ Filtrar breaks por workspace
        $breaks = BookingWorkingBreak::where('user', $this->salon->id)
            ->where('date', $date)
            ->when($this->workspace_id, function($q) {
                return $q->where('workspace_id', $this->workspace_id);
            })
            ->get();
        $appointments = $appointments->concat($breaks);

        $appointments->map(function($item){
            $item->start_time_strtotime = strtotime($item->start_time);
            $item->end_time_strtotime = strtotime($item->end_time);
        });

        $time_val = explode('-', $time_val);




        //$appointments = $appointments->where('start_time_strtotime', '>=', strtotime($time_val[0]))->where('end_time_strtotime', '<=', strtotime($time_val[1]));
        //return $appointments;

        foreach ($appointments as $appointment) {
            $appointment_time = explode('-', $appointment->time);
            $appointment_start_time = $appointment_time[0];
            $appointment_end_time = $appointment_time[1];


            $start_time = $time_val[0];
            $end_time = $time_val[1];

            // comparing datetime objects
            if (
                ($appointment_start_time <= $start_time and $appointment_end_time > $start_time) // if intersecting through time slot start
                or
                ($appointment_start_time < $end_time and $appointment_end_time >= $end_time) // if intersecting through time slot end
                or
                ($appointment_start_time <= $start_time and $appointment_end_time >= $end_time) // if compare covers us
                or
                ($appointment_start_time >= $start_time and $appointment_end_time <= $end_time) // if we contain compare
            ) {
                $status = true;
            }
        }


        return $status;
    }
    
    public function check_time_all($time_val, $date, $barbers = []){
        $status = true;

        $array = [];

        foreach ($barbers as $key => $id) {
            $array[$id] = $this->check_time($time_val, $date, $id);
        }

        foreach($array as $key => $value){
            if($value !== true){
                $status = false;
            }
        }

        //return (min($array) === max($array));

        return $status;
    }

    public function booked_time($appointment, $time_val){
        $status = false;
        
        $appointment_time = explode('-', $appointment->time);
        $appointment_start_time = hour2min($appointment_time[0]);
        $appointment_end_time = hour2min($appointment_time[1]);


        $start_time = hour2min($time_val[0]);
        $end_time = hour2min($time_val[1]);

        // comparing datetime objects
        if (
            ($appointment_start_time <= $start_time and $appointment_end_time > $start_time) // if intersecting through time slot start
            or
            ($appointment_start_time < $end_time and $appointment_end_time >= $end_time) // if intersecting through time slot end
            or
            ($appointment_start_time <= $start_time and $appointment_end_time >= $end_time) // if compare covers us
            or
            ($appointment_start_time >= $start_time and $appointment_end_time <= $end_time) // if we contain compare
        ) {
            $status = true;
        }


        return $status;
    }
}
