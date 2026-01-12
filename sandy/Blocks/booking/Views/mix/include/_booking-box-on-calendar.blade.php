@php
    $timeClass = (new \Sandy\Blocks\booking\Helper\Time($user->id));
    $day_id = $timeClass->get_day_id(date('l', strtotime($this->date)));
    $slot = $timeClass->get_timeslot_by_day($day_id, $this->user->id);

    $calender_start_time = ao($slot, 'from');
    $calender_end_time = ao($slot, 'to');
    
    $total_time = $calender_end_time - $calender_start_time;
    $total_time = $total_time <= 0 ? 60 : $total_time;
    $calendar_total_time = $total_time;

    $start_time = $appt->start_time;
    $end_time = $appt->end_time;

    $booking_duration = $end_time - $start_time;



    if($booking_duration <= 0){
        
        $services_duration = 0;

        foreach ($appt->services as $item) {
            $services_duration += ao($item->settings, 'service_duration');
        }
        $booking_duration = ($services_duration > 0) ? $services_duration : 60;
    }

    $booking_duration_percent = 0;
    $booking_start_percent = 0;
    
    try {
        $booking_duration_percent = $booking_duration * 100 / $calendar_total_time;
        $booking_start_percent = ($start_time - $calender_start_time) / ($calender_end_time - $calender_start_time) * 100;
        if($booking_start_percent < 0) $booking_start_percent = 0;
    } catch (\Exception $e) {
    }

    $appt_link = '#';

    if (isset($link)) {
        $appt_link = $link;
    }

@endphp

<a href="{{ $appt_link }}" class="ch-day-booking status-approved" style="top: {{ $booking_start_percent }}%; height: {{ $booking_duration_percent }}%;">
    <div class="ch-day-booking-i">
        <div class="booking-service-name truncate">{{ $appt->services_name }}</div>
        <div class="booking-time">{{ $timeClass->format_minutes($start_time) }} - {{ $timeClass->format_minutes($end_time) }}</div>
    </div>
</a>