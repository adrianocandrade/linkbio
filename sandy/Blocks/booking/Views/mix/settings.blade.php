@extends('mix::layouts.master')
@section('title', __('Booking Settings'))
@section('content')
@section('footerJS')


<script>
    var format = "{{ ao($user->booking, 'hrs_type') == '12' ? 'hh:mm p' : 'HH:mm p' }}";
    jQuery(document).on("focusin", ".hourpicker", function () {
        jQuery('input.hourpicker').timepicker({
            timeFormat: format,
            interval: {{ ao($user->booking, 'time_interval') ?? 30 }}, // ✅ Default 30 se não configurado
            change: function (time) {
                var element = jQuery(this);
                var timepicker = element.timepicker();

                var new_time = timepicker.options.timeFormat = 'HH:mm';
                timepicker.options.timeFormat = new_time;
                //var mtime = moment(timepicker.format(time), 'HH:mm');
                //var minutes = (mtime.hour() * 60) + mtime.minute();


                // the input field
                var old_time = timepicker.options.timeFormat;
                var new_time = timepicker.options.timeFormat = salon_time_format;


                // element.val(minutes);
                timepicker.options.timeFormat = new_time;
                element.closest('label').find('.calendar__value').text(timepicker.format(time));
            }
        });
    });

</script>
<script>

    var redirect = (url, full = false) => {
        var base_url = '{{ url('/') }}'; // ✅ Corrigido: estava faltando essa linha
        window.location.href = full ? url : `${base_url}${url}`;
    };
    var datepicker = jQuery('#date-selector').datepicker({
        language: 'en',
        dateFormat: 'yyyy-mm-dd',
        autoClose: true,
        timepicker: false,
        toggleSelected: false,
        inline: false,
        range: true,
        startDate: new Date(),
        onSelect: (formatted_date, date) => {
            if (date.length > 1) {
                let [start_date, end_date] = formatted_date.split(',');
                if (typeof end_date == 'undefined') {
                    end_date = start_date
                }
                /* Redirect */
            }
        }
    });

</script>
@stop

    <style>
        .ui-timepicker-standard {
            z-index: 99999999 !important;
        }

    </style>

    <div class="dashboard-header-banner relative mt-0 mb-5">
        <div class="card-container">

            <div class="text-lg font-bold">{{ __('Booking Settings') }}</div>
            <div class="side-cta top-10">
                {!! orion('cogwheel-1', 'h-20') !!}
            </div>
        </div>
    </div>



    <form action="{{ route('sandy-blocks-booking-mix-settings-tree', ['tree' => 'general_settings']) }}" class="white-box-wrap" method="post">
        @csrf
        <div class="white-box rounded-xl">
            <div class="white-box-header">
                <div class="white-box-sub-header justify-between">
                    <h3>{{ __('General') }}</h3>

                    <button class="sandy-expandable-btn">
                        <span class="h-6 flex items-center">{{ __('Save') }}</span>
                    </button>
                </div>
            </div>
            <div class="white-box-content">
                <div class="form-input mb-7">
                    <label class="initial">{{ __('Title') }}</label>
                    <input type="text" name="settings[title]" placeholder="{{ __('Fashion designer') }}" value="{{ ao($user->booking, 'title') }}">
                </div>
                <div class="form-input mb-7">
                    <label class="initial">{{ __('About') }}</label>
                    <textarea rows="4" name="settings[description]">{{ ao($user->booking, 'description') }}</textarea>
                    <p class="font-9 italic mt-3">{{ __('Give a descriptive info about your booking service.') }}</p>
                </div>

                <div class="form-input mb-7">
                    <label class="initial">{{ __('Time Format') }}</label>
                    <select name="settings[hrs_type]">
                        <option value="12"
                            {{ ao($user->booking, 'hrs_type') == '12' ? 'selected' : '' }}>
                            {{ __('12 Hours') }}</option>
                        <option value="24"
                            {{ ao($user->booking, 'hrs_type') == '24' ? 'selected' : '' }}>
                            {{ __('24 Hours') }}</option>
                    </select>
                </div>
                <div class="form-input mb-7">
                    <label class="initial">{{ __('Time Interval') }}</label>
                    <select name="settings[time_interval]">
                        <option value="15"
                            {{ ao($user->booking, 'time_interval') == '15' ? 'selected' : '' }}>
                            {{ __('15 Minutes') }}</option>
                        <option value="30"
                            {{ ao($user->booking, 'time_interval') == '30' ? 'selected' : '' }}>
                            {{ __('30 Minutes') }}</option>
                        <option value="45"
                            {{ ao($user->booking, 'time_interval') == '45' ? 'selected' : '' }}>
                            {{ __('45 Minutes') }}</option>
                        <option value="60"
                            {{ ao($user->booking, 'time_interval') == '60' ? 'selected' : '' }}>
                            {{ __('60 Minutes') }}</option>
                    </select>
                </div>

                <p class="font-9 italic mt-3">{{ __('Save before moving to the next section or progress wont be recorded.') }}</p>
            </div>
        </div>
    </form>


    <div class="white-box-wrap">
        
        <div class="white-box rounded-xl">
            <div class="white-box-header">
                <div class="white-box-sub-header">
                    <h3>{{ __('Services') }}</h3>
                </div>
            </div>
            <div class="white-box-content">

                <livewire:booking-block-mix-services-livewire :user_id="$user->id" :workspace_id="session('active_workspace_id')" :wire:key="'services-' . $user->id . '-' . (session('active_workspace_id') ?? 'default')" />
            </div>
        </div>
    </div>


    <div class="white-box-wrap">
        
        <div class="white-box rounded-xl">
            <div class="white-box-header">
                <div class="white-box-sub-header">
                    <h3>{{ __('Portfolio') }}</h3>
                </div>
            </div>
            <div class="white-box-content">

                <livewire:booking-block-mix-portfolio-livewire :user_id="$user->id" :wire:key="$user->id" />
            </div>
        </div>
    </div>

    <form action="{{ route('sandy-blocks-booking-mix-settings-tree', ['tree' => 'edit_working_hours']) }}" class="white-box-wrap" method="post">
        @csrf

        <div class="white-box rounded-xl">
            <div class="white-box-header">
                <div class="white-box-sub-header justify-between">
                    <h3>{{ __('Working hours') }}</h3>

                    <button class="sandy-expandable-btn">
                        <span class="h-6 flex items-center">{{ __('Save') }}</span>
                    </button>
                </div>
            </div>
            <div class="white-box-content">

                @php
                    $timeClass = (new \Sandy\Blocks\booking\Helper\Time($user->id));
                    $times = $timeClass->get_days_array();
                @endphp

                @foreach($times as $dkey => $dvalue)

                    @php
                        // ✅ Proteção contra valores null
                        $from_minutes = ao($user->booking, "workhours.$dkey.from");
                        $to_minutes = ao($user->booking, "workhours.$dkey.to");
                        
                        $start_time = $from_minutes ? $timeClass->format_minutes($from_minutes) : '';
                        $end_time = $to_minutes ? $timeClass->format_minutes($to_minutes) : '';

                        $timevalue = ($start_time && $end_time) ? implode('-', [$start_time, $end_time]) : '';
                    @endphp

                    <div class="weekday-schedule-w">
                        <div class="ws-head-w">
                            <label class="sandy-switch flex items-center col-span-2">
                                <input type="hidden" name="weekday[{{ $dkey }}][enable]" value="0">
                                <input class="sandy-switch-input" name="weekday[{{ $dkey }}][enable]" value="1"
                                    {{ ao($user->booking, "workhours.$dkey.enable") ? 'checked' : '' }}
                                    type="checkbox">
                                <span class="sandy-switch-in"><span class="sandy-switch-box"></span></span>
                            </label>
                            <div class="ws-head">
                                <div class="ws-day-name font-bold text-sm">{{ $dvalue }}</div>
                                <div class="ws-day-hours"><span>{{ $timevalue }}</span> </div>
                                <div class="wp-edit-icon top-6">
                                    {!! orion('edit-3', 'w-4 h-4') !!}
                                </div>
                            </div>
                        </div>
                        <div class="weekday-schedule-form">
                            <div class="ws-period">
                                <div class="wj-time-group wj-time-input-w as-period">
                                    <label for="weekday[{{ $dkey }}][from]">{{ __('Start') }}</label>

                                    <div class="wj-time-input-fields">
                                        <input type="text" placeholder="HH:MM" id="weekday[{{ $dkey }}][from]"
                                            name="weekday[{{ $dkey }}][from]" value="{{ $start_time }}"
                                            class="wj-form-control wj-mask-time hourpicker max-w-full w-32">
                                    </div>
                                </div>

                                <div class="wj-time-group wj-time-input-w as-period">
                                    <label for="weekday[{{ $dkey }}][to]">{{ __('Finish') }}</label>

                                    <div class="wj-time-input-fields">
                                        <input type="text" placeholder="HH:MM" id="weekday[{{ $dkey }}][to]"
                                            name="weekday[{{ $dkey }}][to]" value="{{ $end_time }}"
                                            class="wj-form-control wj-mask-time hourpicker max-w-full w-32">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
        
                <p class="font-9 italic mt-3">{{ __('Save before moving to the next section or progress wont be recorded.') }}</p>
            </div>
        </div>


    </form>

    <div class="white-box-wrap mb-52">
        <div class="white-box rounded-xl">
            <div class="white-box-header">
                <div class="white-box-sub-header">
                    <h3>{{ __('Breaks & Days Off') }}</h3>
                </div>
            </div>
            <div class="white-box-content custom-day-work-periods">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div>
        
                        <a class="add-custom-day-w w-full cursor-pointer breaks-open rounded-xl">
                            <div class="add-custom-day-i">
                                <div class="add-day-graphic-w">
                                    <div class="add-day-plus items-center justify-center flex bg-gray-400">
                                        {!! orion('add-1', 'w-5 h-5 stroke-current text-white') !!}
                                    </div>
                                </div>
                                <div class="add-day-label text-gray-400 text-base">{{ __('Add Break') }}</div>
                            </div>
                        </a>
                    </div>
                    
                    @foreach ($breaks as $item)
                    @php
                        $date = \Carbon\Carbon::parse($item->date);
                    @endphp
                    <div class="custom-day-work-period w-full h-full">
                    <a href="#" title="Edit Day Schedule" class="edit-custom-day hidden">
                        {!! orion('edit-1', 'w-3 h-3') !!}
                    </a>

                    <form action="{{ route('sandy-blocks-booking-mix-settings-tree', ['tree' => 'remove_break']) }}" method="post">
                        
                        @csrf
                        <input type="hidden" name="breaks" value="{{ json_encode([$item->id]) }}">
                        
                        <button class="remove-custom-day" data-delete="{{ __('Do you want to remove this time break?') }}">{!! orion('bin-1', 'w-3 h-3 stroke-current') !!}</button>
                    </form>


                    <div class="custom-day-work-period-i">
                        <div class="custom-day-number">{{ $date->format('j') }}</div>
                        <div class="custom-day-month">{{ $date->format('F') }}</div>
                    </div>
                    <div class="custom-day-periods">
                        <div class="custom-day-period">
                            @if($item->nice_start_time && $item->nice_end_time)
                                {{ implode(' - ', [$item->nice_start_time, $item->nice_end_time]) }}
                            @else
                                {{ __('No time set') }}
                            @endif
                        </div>
                    </div>
                    </div>
                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    
<div data-popup=".breaks" class="small--floating">

    <form action="{{ route('sandy-blocks-booking-mix-settings-tree', ['tree' => 'add_break']) }}" method="post">
        @csrf

        <div class="form-input">
            <label for="">{{ __('Date') }}</label>
    
            <input
              id="date-selector"
              type="text"
              data-range="true"
              name="date"
              value=""
              placeholder=""
              autocomplete="off"
              readonly="readonly"
              class=""
              >
        </div>
    
        <div class="ws-period mt-5 mb-0">
            <div class="wj-time-group wj-time-input-w as-period">
                <label for="break-start">{{ __('Start') }}</label>

                <div class="wj-time-input-fields">
                    <input type="text" placeholder="HH:MM" id="break-start"
                        class="wj-form-control wj-mask-time hourpicker w-44 max-w-full" name="start_time">
                </div>
            </div>

            <div class="wj-time-group wj-time-input-w as-period">
                <label for="break-end">{{ __('Finish') }}</label>

                <div class="wj-time-input-fields">
                    <input type="text" placeholder="HH:MM" id="break-end"
                        class="wj-form-control wj-mask-time hourpicker w-44 max-w-full" name="end_time">
                </div>
            </div>
        </div>
        <button class="mt-5 button rounded-lg px-10 h-10">{{ __('Save') }}</button>
    </form>
</div>

@endsection
