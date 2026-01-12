@extends('mix::layouts.master')
@section('title', __('Sales'))
@section('footerJS')
<script>
$.fn.datepicker.language['en'] = {
days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
months: ['January','February','March','April','May','June', 'July','August','September','October','November','December'],
monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
today: 'Today',
clear: 'Clear',
dateFormat: 'mm/dd/yyyy',
timeFormat: 'hh:ii aa',
firstDay: 1
};
var redirect = (url, full = false) => {
var base_url = '{{url('/')}}';
window.location.href = full ? url : `${base_url}${url}`;
};
var datepicker = jQuery('#date-selector').datepicker({
language: 'en',
dateFormat: 'yyyy-mm-dd',
autoClose: true,
classes: 'card-shadow border-0 p-5 rounded-2xl',
timepicker: false,
toggleSelected: false,
inline: false,
range: true,
maxDate: new Date(),
onSelect: (formatted_date, date) => {
if(date.length > 1) {
let [ start_date, end_date ] = formatted_date.split(',');
if(typeof end_date == 'undefined') {
end_date = start_date
}
/* Redirect */
redirect(`{{ route('sandy-blocks-course-mix-sales') }}?start_date=${start_date}&end_date=${end_date}`, true);
}
}
});
</script>
@stop
@section('content')
@includeIf('include.back-header', ['route' => route('sandy-blocks-course-mix-dashboard')])
<div class="mix-padding-10">
    <div class="flex my-5">
        <label class="position-relative flex sandy-date-pickr-wrapper">
            <div class="text-xl text-gray-400 ml-auto">{{ __('Filter') }}</div>
            <input
            id="date-selector"
            type="text"
            data-range="true"
            name="date_range"
            value=""
            placeholder=""
            autocomplete="off"
            readonly="readonly"
            class="sandy-analytics-date absolute" style="z-index: -1;"
            >
        </label>
    </div>
    <div class="h-56 mort-main-bg rounded-2xl">
        <div id="chart-earning" data-chart="payments_earnings" class="chart-line"></div>
    </div>
    @if (!$orders->isEmpty())
    <div class="flex-table mt-10">
        <!--Table header-->
        <div class="flex-table-header">
            <span class="is-grow">{{ __('Customer') }}</span>
            <span>{{ __('Course') }}</span>
            <span>{{ __('Price') }}</span>
            <span class="cell-end">{{ __('Date') }}</span>
        </div>
        @foreach ($orders as $item)
        <div class="flex-table-item rounded-2xl">
            <div class="flex-table-cell is-media is-grow" data-th="">
                <div class="h-avatar md is-trans">
                    {!! avatar($item->payee_user_id, true) !!}
                </div>
                <div>
                    <span class="item-name mb-2">{{ user('name', $item->payee_user_id) }}</span>
                    <span class="item-meta">
                        <span>{{ user('email', $item->payee_user_id) }}</span>
                    </span>
                </div>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Course') }}">
                <span>
                    @php
                    $course = \Sandy\Blocks\course\Models\Course::find($item->course_id);
                    @endphp
                    {{ $course ? $course->name : __('Course not found') }}
                </span>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Price') }}">
                <span>
                    {!! \Bio::price($item->price, $user->id) !!}
                </span>
            </div>
            <div class="flex-table-cell cell-end" data-th="{{ __('Date') }}">
                <span class="ml-auto my-0">{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
            </div>
        </div>
        @endforeach
        <div class="mt-10">
            {!! $orders->links() !!}
        </div>
    </div>
    @else
    <div class="p-10 py-20">
        @include('include.no-record')
    </div>
    @endif
</div>
<script>
var payments_earnings = {
colors: ['rgb(52, 132, 145)', 'rgb(255, 99, 152)'],
textColor: '#000',
labels: {!! ao($analytics, 'payments.labels') ?? '[]' !!},
series: [{
name: "{{ __('Order') }}",
data: {!! ao($analytics, 'payments.payments') ?? '[]' !!}
}, {
name: "{{ __('Earnings') }}",
data: {!! ao($analytics, 'payments.earnings') ?? '[]' !!}
}],
};
</script>
@endsection