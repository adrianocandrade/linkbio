@extends('bio::layouts.master')
@section('content')
@section('head')

<style>
    .bio-menu {
        display: none !important;
    }

    #zuck-modal #zuck-modal-content .story-viewer .slides .item>.media {
        object-fit: contain !important;
    }

    #zuck-modal #zuck-modal-content .story-viewer .head .left .time {
        display: none !important;
    }

</style>
@stop
    @section('footerJS')
    <script>
        $.fn.datepicker.language['en'] = {
            days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December'
            ],
            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            today: 'Today',
            clear: 'Clear',
            dateFormat: 'mm/dd/yyyy',
            timeFormat: 'hh:ii aa',
            firstDay: 1
        };

        var redirect = (url, full = false) => {
            var base_url = '{{ url('/') }}';
            window.location.href = full ? url : `${base_url}${url}`;
        };


        var datepicker = jQuery('#month-selector').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
            autoClose: true,
            timepicker: false,
            toggleSelected: false,
            classes: 'card-shadow border-0 p-5 rounded-2xl',
            range: false,
            onSelect: (formatted_date, date) => {

                redirect(
                    `{{ $sandy->route('sandy-blocks-booking-bookings') }}?date=${formatted_date}`,
                    true);

            }
        });

    </script>
    @stop
        <div class="px-5 md:px-0">


            <div class="inner-pages-header mb-10">
                <div class="inner-pages-header-container">
                    <a class="previous-page" app-sandy-prevent="" href="{{ $sandy->route('sandy-blocks-booking-booking') }}">
                        <p class="back-button"><i class="la la-arrow-left"></i></p>
                        <h1 class="inner-pages-title ml-3">{{ __('Back') }}</h1>
                    </a>
                </div>
            </div>


            <div class="dashboard-header-banner relative mt-0 mb-5">
                <div class="card-container">

                    <div class="text-lg font-bold">{{ __('Calendar') }}</div>
                    <label class="md:w-32 w-full md:relative" for="month-selector">
                        <p class="text-lg font-bold auth-link underline">{{ __('Select Month') }}
                        </p>
                        <input type="text" class="m-selector p-0 h-0 absolute w-80 right-2" readonly="true"
                            id="month-selector">
                    </label>

                    <div class="side-cta top-14">
                        {!! orion('clock-1', 'h-20') !!}
                    </div>
                </div>
            </div>

            <div class="wj-bookings-daily card bg-transparent">
                <div class="daily-agent-monthly-calendar-w horizontal-calendar">
                    <div class="flex flex-col gap-4 mt-10">
                        
                        @if (!$appointments->isEmpty())
                        @foreach ($appointments as $item)
                            
                        <div class="card p-5 rounded-2xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
                            <div class="card-container bg-repeat-right"
                                data-bg="{{ gs("assets/image/others/scribbbles/". seed_random_number("Appointment-SEED-$item->id") .".png") }}">


                                <div class="icon mb-4">
                                    {!! orion('hour-1', 'w-20 h-20') !!}
                                </div>

                                <div class="font-bold text-lg mb-3 --c-text-title">{{ \Carbon\Carbon::parse($item->date)->toFormattedDateString() }}, {{ (new \Sandy\Blocks\booking\Helper\Time($bio->id))->format_minutes($item->start_time) }}</div>
                                <div class="checkout-barber gap-4">
    
                                    <div
                                        class="checkout-barber-info flex flex-col justify-between w-full py-2 overflow-x-hidden">
                                        <div class="checkout-barber-name font-black">{!! $sandy->price($item->price) !!}</div>
                                        <div class="checkout-barber-name m-0 --c-text-title hidden">Sasuke Uchiha</div>
                                        <div class="checkout-barber-location truncate --c-text-title hidden">Alabama</div>
    
                                        <div class="text-xs text-green-600">{{ __('Services') }}: {{ $item->services_name }}</div>
                                    </div>
                                </div>
                                <a app-sandy-prevent="" href="{{ $sandy->route('sandy-blocks-booking-booking-view', ['booking_id' => $item->id]) }}" class="sandy-expandable-btn px-10"><span>{{ __('Manage') }}</span></a>
                            </div>
                        </div>
                        @endforeach

                        @else
                            
                        <div class="no-results-w mt-5">
                            <div class="icon-w flex justify-center">
                            {!! orion('alarm-clock-1', 'w-20 h-20 text-current') !!}
                            </div>
                            <h2 >{{ __('You have no booking for this day.') }}</h2>
                            <a href="{{ $sandy->route('sandy-blocks-booking-booking') }}" class="sandy-expandable-btn mt-5 px-10"><span>{{ __('Book') }}</span></a>
                        </div>
                        @endif

                        
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-20"></div>
@endsection
