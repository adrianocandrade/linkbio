<div>
    @section('footerJS')

    <script>
        function scrollToSelectedDay() {
            var $months = jQuery('.snd-months');
            var $selected = jQuery('.snd-day.selected');
            
            if ($selected.length && $months.length) {
                var containerLeft = $months.offset().left;
                var selectedLeft = $selected.offset().left;
                var scrollPosition = selectedLeft - containerLeft + $months.scrollLeft() - 20;
                
                $months.animate({
                    scrollLeft: Math.max(0, scrollPosition)
                }, 500);
            }
        }
        
        // Executar após Livewire carregar
        document.addEventListener('livewire:load', function () {
            setTimeout(scrollToSelectedDay, 300);
        });
        
        // Executar quando Livewire atualizar
        Livewire.hook('message.processed', function () {
            setTimeout(scrollToSelectedDay, 100);
        });
        
        // Fallback para quando Livewire já está carregado
        jQuery(document).ready(function() {
            setTimeout(scrollToSelectedDay, 500);
        });
    </script>
    @stop

    <script>
        function calendar_alpine_head() {
            return {
                init(){
                    var _this = this;
                    
                    this.$nextTick(() => {
                        var week_picker = this.$refs.week_picker;
                        
                        // ✅ Seletor de semana ao invés de mês
                        var datepicker = jQuery(week_picker).datepicker({
                            language: 'en',
                            dateFormat: 'yyyy-mm-dd',
                            autoClose: true,
                            timepicker: false,
                            toggleSelected: false,
                            classes: 'card-shadow border-0 p-5 rounded-2xl',
                            range: false,
                            onSelect: (formatted_date, date) => {
                               this.$wire.change_date(formatted_date);
                            }
                        });

                    });
                }
            }
        }


        function calendar_alpine(){
            return {
                create_break(date, start_time, end_time){
                    var component = @this;
                    if(!component) {
                        console.error('Livewire component not found');
                        return;
                    }
                    $.confirm('{{ __("Do you want to add a break for this time?") }}', {
                        title: '{{ __("Add break for the selected time slot") }}',
                        cancelButton:'{{ __("Cancel") }}',
                        ConfirmbtnClass: 'text-green-400',
                        confirmButton: '{{ __("Yes, Add Break") }}',
                        callEvent:function(){
                            // ✅ Chamar método Livewire diretamente
                            component.call('create_break', date, parseInt(start_time), parseInt(end_time));
                        },
                        cancelEvent:function(){
                            return false;
                        }
                    });
                },

                remove_break(breaks){
                    var component = @this;
                    if(!component) {
                        console.error('Livewire component not found');
                        return;
                    }
                    $.confirm("{{ __('Do you want to remove this time break?') }}", {
                        title: "{{ __('Remove Break') }}",
                        cancelButton: '{{ __("Cancel") }}',
                        ConfirmbtnClass: 'text-red-400',
                        confirmButton: '{{ __("Yes, Remove") }}',
                        callEvent:function(){
                            // ✅ Chamar método Livewire diretamente
                            component.call('remove_break', breaks);
                        },
                        cancelEvent:function(){
                            return false;
                        }
                    });
                }
            }
        }

    </script>
    
    @php
        $timeClass = (new \Sandy\Blocks\booking\Helper\Time($user->id));
        // ✅ Corrigir: $this->date já é um objeto Carbon, não precisa de strtotime
        $day_id = $timeClass->get_day_id($this->date->format('l'));
        $slot = $timeClass->get_timeslot_by_day($day_id, $this->user->id);

        $calender_start_time = ao($slot, 'from') ?? 0;
        $calender_end_time = ao($slot, 'to') ?? 0;
        $interval = (int) (ao($this->config, 'interval') ?? 30); // ✅ Default 30 minutos se não configurado
        
        // ✅ CRÍTICO: Validar e corrigir valores absurdos que causam esgotamento de memória
        // Um dia tem máximo 1440 minutos (24 horas)
        $MAX_MINUTES_PER_DAY = 1440;
        
        // Garantir que os valores estão dentro de limites razoáveis
        $calender_start_time = max(0, min($calender_start_time, $MAX_MINUTES_PER_DAY));
        $calender_end_time = max(0, min($calender_end_time, $MAX_MINUTES_PER_DAY));
        
        // Se o horário final for menor ou igual ao inicial, usar valores padrão seguros
        if ($calender_end_time <= $calender_start_time) {
            $calender_start_time = 540; // 9:00 AM
            $calender_end_time = 1080;  // 6:00 PM
        }
        
        // ✅ Proteção adicional: limitar diferença máxima para evitar loops infinitos
        // Máximo de 12 horas de trabalho (720 minutos)
        $max_duration = 720;
        if (($calender_end_time - $calender_start_time) > $max_duration) {
            $calender_end_time = $calender_start_time + $max_duration;
        }
        
        $p_height = 2000;
        
        // ✅ Proteção contra divisão por zero
        $total_periods = 1; // Default
        $period_height = $p_height; // Default
        $period_css = '';
        
        // Verificar se os horários estão configurados e o intervalo é válido
        if ($interval > 0 && $calender_start_time >= 0 && $calender_end_time > $calender_start_time) {
            $time_diff = $calender_end_time - $calender_start_time;
            if ($time_diff > 0 && $time_diff <= $max_duration) { // ✅ Adicionar verificação de limite
                $total_periods = max(1, floor($time_diff / $interval) + 1); // ✅ Garantir mínimo de 1
                // ✅ Proteção: limitar total_periods para evitar renderização excessiva
                $total_periods = min($total_periods, 288); // Máximo 288 períodos (12 horas / 15 min)
                
                if ($total_periods > 0) {
                    $period_height = floor($p_height / $total_periods);
                    $period_css = (($total_periods * 20) < $p_height) ? "height: {$period_height}px;" : '';
                }
            }
        }
    @endphp

    
    <div class="dashboard-header-banner relative mt-0 mb-5" x-data="calendar_alpine_head">
        <div class="card-container">

            <div class="text-lg font-bold">{{ __('Calendar') }}</div>
            
            {{-- ✅ Navegação de semana melhorada --}}
            <div class="flex items-center gap-3" wire:ignore.self>
                <button type="button" 
                        wire:click="previousWeek" 
                        class="px-3 py-1 rounded-lg hover:bg-gray-100 transition" 
                        title="{{ __('Previous Week') }}">
                    <i class="la la-chevron-left"></i>
                </button>
                
                <label class="md:w-auto w-full md:relative" for="week-selector">
                    <p class="text-lg font-bold auth-link underline cursor-pointer">
                        {{ $this->getWeekRangeString() }}
                    </p>
                    <input type="text" class="m-selector p-0 h-0 absolute w-80 right-2" readonly="true" id="week-selector" wire:ignore x-ref="week_picker">
                </label>
                
                <button type="button" 
                        wire:click="nextWeek" 
                        class="px-3 py-1 rounded-lg hover:bg-gray-100 transition" 
                        title="{{ __('Next Week') }}">
                    <i class="la la-chevron-right"></i>
                </button>
                
                <button type="button" 
                        wire:click="currentWeek" 
                        class="px-3 py-1 text-sm rounded-lg hover:bg-gray-100 transition" 
                        title="{{ __('Current Week') }}">
                    {{ __('Today') }}
                </button>
            </div>

            <div class="side-cta top-14">
                {!! orion('clock-1', 'h-20') !!}
            </div>
        </div>
    </div>


    <div class="wj-bookings-daily card" x-data="calendar_alpine">
        <div class="daily-agent-monthly-calendar-w horizontal-calendar mb-0 md:mb-5">


            <div class="snd-months overflow-x-auto mx-0" style="overflow-x: auto !important; overflow-y: hidden !important; -webkit-overflow-scrolling: touch;">
                <div class="snd-monthly-calendar-days-w block" style="overflow: visible; width: 100%;">
                    
                    <div class="snd-monthly-calendar-days" style="min-width: max-content; display: flex; flex-wrap: nowrap;">

                        @foreach ($this->calendar_head as $key => $value)
                            @php
                                $isSelected = $this->date->format('Y-m-d') == ao($value, 'date');
                                $isToday = ao($value, 'is_today');
                                $dateValue = ao($value, 'date');
                            @endphp
                            <div class="snd-day snd-day-current week-day-{{ ao($value, 'week_day') }} is-f {{ $isSelected ? 'selected' : '' }} {{ $isToday && !$isSelected ? 'snd-today' : '' }}" 
                                 wire:click="change_date('{{ $dateValue }}')"
                                 style="cursor: pointer;">
                                <button type="button" class="snd-day-weekday no-disabled">{{ ao($value, 'day') }}</button>
                                <button type="button" class="snd-day-box w-full no-disabled outline-none outline-0">
                                    <div class="snd-day-number">{{ ao($value, 'day_digit') }}</div>
                                    @if(ao($value, 'day_status'))
                                    <div class="day-status snd-day-status">
                                        {!! ao($value, 'day_status') !!}
                                    </div>
                                    @endif
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="daily-agent-calendar-w ">
            <div class="calendar-daily-agent-w">
                @if ($timeClass->check_workday($this->date->format('l'), $this->user->id))
                <div class="calendar-hours">
                    <div class="ch-hours">
                        <div class="ch-filter">
                            <div class="ch-filter-trigger"></div>
                        </div>
                                    
                        @for ($minutes = $calender_start_time; $minutes <= $calender_end_time && ($minutes - $calender_start_time) <= 720; $minutes+= $interval)
                        @php
                        
                        $period_class = 'chh-period';
                        $period_class   .= (($minutes == $calender_end_time) || (($minutes + $interval) > $calender_end_time)) ? ' last-period' : '';
                        $period_class   .= (($minutes % 60) == 0) ? ' chh-period-hour' : ' chh-period-minutes';
                        @endphp
                        <div class="{{ $period_class }}" style="{{ $period_css }}"><span>{{ str_replace(' ', '', $timeClass->format_minutes($minutes)) }}</span></div>
                        @endfor
                    </div>

                    <div class="ch-agents">
                        <div class="da-head-agents">
                            <div class="da-head-agent">
                                <div class="da-head-agent-avatar"
                                    style="background-image: url({{ avatar() }});">
                                </div>
                                <div class="da-head-agent-name">{{ $this->user->name }}</div>
                            </div>
                        </div>
                        <div class="da-agents-bookings">
                            <div class="da-agent-bookings-and-periods">
                                <div class="ch-day-periods">
                                    
                                    @php
                                        list($work_start_time, $work_end_time) = $timeClass->work_time_to_min($this->date->format('Y-m-d'), $this->user->id);
                                        
                                        // ✅ CRÍTICO: Validar valores retornados por work_time_to_min
                                        $MAX_MINUTES_PER_DAY = 1440;
                                        $work_start_time = max(0, min((int)$work_start_time, $MAX_MINUTES_PER_DAY));
                                        $work_end_time = max(0, min((int)$work_end_time, $MAX_MINUTES_PER_DAY));
                                        
                                        // Usar os valores já validados do slot principal
                                        $work_start_time = $calender_start_time;
                                        $work_end_time = $calender_end_time;
                                    @endphp
                                    
                                    @for ($minutes = $calender_start_time; $minutes <= $calender_end_time && ($minutes - $calender_start_time) <= 720; $minutes += $interval)


                                    @php
                                        
                                        $start_time = $minutes;
                                        $end_time = $start_time + $interval;
                                        
                                        $nice_start_time = $timeClass->format_minutes($start_time);
                                        $nice_end_time = $timeClass->format_minutes($end_time);


                                        $period_class   = 'chd-period';
                                        $period_class   .= (($minutes == $calender_end_time) || (($minutes + $interval) > $calender_end_time)) ? ' last-period' : '';
                                        $period_class   .= (($minutes % 60) == 0) ? ' chd-period-hour' : ' chd-period-minutes';

                                        // ✅ OTIMIZAÇÃO CRÍTICA: Usar breaks já carregados ao invés de fazer query
                                        // Isso elimina centenas de queries que estavam sendo feitas no loop
                                        $check_breaks = null;
                                        $timeSlot = implode('-', [$start_time, $end_time]);
                                        
                                        // Verificar se algum break se sobrepõe ao período atual
                                        foreach ($this->breaksForDay as $break) {
                                            $break_time = explode('-', $break->time);
                                            $break_start = (int) $break_time[0];
                                            $break_end = (int) $break_time[1];
                                            
                                            // Verificar sobreposição de intervalos
                                            if (
                                                ($break_start <= $start_time && $break_end > $start_time) ||
                                                ($break_start < $end_time && $break_end >= $end_time) ||
                                                ($break_start <= $start_time && $break_end >= $end_time) ||
                                                ($break_start >= $start_time && $break_end <= $end_time)
                                            ) {
                                                $check_breaks = $check_breaks ?? [];
                                                $check_breaks[] = $break->id;
                                            }
                                        }

                                        if($check_breaks){
                                            $period_class .= ' chd-period-off';
                                            $period_class = str_replace('booking-popup-open', '', $period_class);
                                        }
                                    @endphp
                                    
                                    <div class="{{ $period_class }}" style="{{ $period_css }}">

                                        @if ($check_breaks)
                                            
                                            <button 
                                                x-on:click="remove_break('{{ json_encode($check_breaks) }}')"
                                                type="button"
                                                class="text-red-400 h-full w-full text-remove no-disabled-btn absolute right-0 left-0 top-0 bottom-0 cursor-pointer"
                                                title="{{ __('Remove Break') }}">
                                            </button>

                                            @else
                                            <button 
                                                x-on:click="create_break('{{ $this->date->format('Y-m-d') }}', '{{ $start_time }}', '{{ $end_time }}')"
                                                type="button"
                                                class="text-green-400 h-full w-full text-add no-disabled-btn absolute right-0 left-0 top-0 bottom-0 cursor-pointer"
                                                title="{{ __('Add Break') }}">
                                            </button>
                                        @endif
                                        
                                        <div class="chd-period-minutes-value">{{ $timeClass->format_minutes($minutes) }}</div>
                                    </div>



                                    @endfor
                                    
                                    <div class="da-agent-bookings">
                                        @foreach ($this->booking as $key => $appt_i)
                                            @include('Blocks-booking::mix.include._booking-box-on-calendar', ['appt' => $appt_i, 'link' => route('sandy-blocks-booking-mix-calendar-view', ['booking_id' => $appt_i->id])])
                                        @endforeach
                                    </div>

                                </div>
                                <div class="da-agent-bookings">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @else
                        
                <div class="flex flex-col items-center rounded-xl border-2 border-dotted border-gray-200 p-4">
                    <img class="lozad w-20" alt="" src="{{ gs('assets/image/emoji/Yellow-1/Confused.png') }}">
                    <div class="text-xl font-bold mt-5-">{{ __('Not Available') }}</div>
                    <div class="w-3/4 mt-3 text-center">
                    <div class="text-sm text-gray-400 text-center">{{ __('You have not set any working hours for this day.') }}</div>
                    <a href="{{ route('sandy-blocks-booking-mix-settings') }}" class="sandy-expandable-btn mt-5 mx-auto"><span>{{ __('Edit Working Hours') }}</span></a>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
