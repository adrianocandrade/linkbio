@extends('admin::layouts.master')
@section('title', __('Analytics'))
@section('namespace', 'admin-analytics')
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
timepicker: false,
toggleSelected: false,
range: true,
maxDate: new Date(),
onSelect: (formatted_date, date) => {
if(date.length > 1) {
let [ start_date, end_date ] = formatted_date.split(',');
if(typeof end_date == 'undefined') {
end_date = start_date
}
/* Redirect */
redirect(`{{ route('admin-analytics') }}?start_date=${start_date}&end_date=${end_date}`, true);
}
}
});
</script>
@stop
@section('content')
<div class="sandy-page-row relative">
  <div class="sandy-page-col pl-0 relative">
    <div class="page__head">
      <div class="step-banner remove-shadow">
        <div class="section-header">
          <div class="section-header-info">
            <h2 class="section-title">{{ __('Analytics') }}</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="details details-big mb-10">
      <div class="details-container">
        <div class="details-list mt-8">
          <div class="details-item flex-none w-half">
            <div class="details-head">
              <div class="details-preview bg-blue">
                
              </div>
              <div class="details-text caption-sm">{{ __('Logged in users') }}</div>
            </div>
            <div class="details-counter h3">{{ \App\Models\MySession::activity(10)->hasUser()->count() }}</div>
            <div class="details-indicator">
              <div class="details-progress bg-orange" style="width: 70%;"></div>
            </div>
            <div class="tag-link-wrapper mb-0">
              <a class="text-sticker bg-gray text-white" href="{{ route('admin-analytics-logged-in') }}">{{ __('View') }}</a>
            </div>
          </div>
          <div class="details-item flex-none w-half">
            <div class="details-head">
              <div class="details-preview bg-black">
                <i class="sio internet-053-group-users"></i>
              </div>
              <div class="details-text caption-sm">{{ __('Total Earnings') }}</div>
            </div>
            <div class="details-counter h3">{!! price_with_cur(settings('payment.currency'), ao($analytics, 'totalEarnings')) !!}</div>
            <div class="details-indicator">
              <a class="text-sticker bg-gray text-white" href="{{ route('admin-payments') }}">{{ __('View') }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="details details-big mb-10">
      <div class="details-container">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
          <div class="col-span-2">
            <div class="details details-big mb-0">
              <div class="details-container p-0">
                <div class="details-title h6">{{ __('Users') }}</div>
                <div class="details-box">
                  <div class="details-chart-counter">
                    <div id="chart-earning" data-chart="users_chart" class="chart-line"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="details-container mb-10">
      <div class="details-title h6">{{ __('Bio Visits') }}</div>
      <div class="col-span-2">
        <div class="details details-big mb-0">
          <div class="details-container p-0">
            <div class="details-box">
              <div class="details-chart-counter">
                <div id="chart-earning" data-chart="user_visitors" class="chart-line"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="details-list mt-8">
        <div class="details-item flex-none w-half">
          <div class="details-head">
            <div class="details-preview bg-orange">
              
            </div>
            <div class="details-text caption-sm">{{ __('Total Views') }}</div>
          </div>
          <div class="details-counter h3">{{ nr(ao($analytics, 'total_user_views.visits')) }}</div>
          <div class="details-indicator">
            <div class="details-progress bg-orange" style="width: 70%;"></div>
          </div>
        </div>
        <div class="details-item flex-none w-half">
          <div class="details-head">
            <div class="details-preview bg-purple">
              <i class="sio internet-053-group-users"></i>
            </div>
            <div class="details-text caption-sm">{{ __('Unique Views') }}</div>
          </div>
          <div class="details-counter h3">{{ nr(ao($analytics, 'total_user_views.unique')) }}</div>
          <div class="details-indicator">
            <div class="details-progress bg-purple" style="width: 52%;"></div>
          </div>
        </div></div>
        <div class="tag-link-wrapper mt-5">
          <a class="tag-link active" href="{{ route('admin-analytics-most-visited') }}">{{ __('View') }}</a>
        </div>
      </div>
      <div class="details details-big">
        <div class="details-container">
          <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
            <div class="col-span-2">
              <div class="details details-big mb-0">
                <div class="details-container p-0">
                  <div class="details-title h6">{{ __('Payments & Earnings') }}</div>
                  <div class="details-box">
                    <div class="details-chart-counter">
                      <div id="chart-earning" data-chart="payments_earnings" class="chart-line"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="sandy-page-col sandy-page-col_pt100">
      <div class="card card_widget">
        <div class="card__head card__head_mb32">
          <div class="card__title h6">{{ __('Filter') }}</div>
        </div>
        <label class="position-relative flex justify-center sandy-date-pickr-wrapper">
          <div id="date-selector"></div>
          <input
          id="date-selector"
          type="text"
          data-range="true"
          name="date_range"
          value=""
          placeholder=""
          autocomplete="off"
          readonly="readonly"
          class="sandy-analytics-date hide"
          >
        </label>
        <a class="card__reset" href="{{ route('admin-analytics') }}">{{ __('Reset filters') }}</a>
      </div>
    </div>
  </div>
  <script>
  var users_chart = {
  labels: {!! ao($analytics, 'users.labels') ?? '[]' !!},
  series: [{
  name: "{{ __('Users') }}",
  data: {!! ao($analytics, 'users.count') ?? '[]' !!}
  }],
  };
  var payments_earnings = {
  labels: {!! ao($analytics, 'payments.labels') ?? '[]' !!},
  series: [{
  name: "{{ __('Payments') }}",
  data: {!! ao($analytics, 'payments.payments') ?? '[]' !!}
  }, {
  name: "{{ __('Earnings') }}",
  data: {!! ao($analytics, 'payments.earnings') ?? '[]' !!}
  }],
  };
  var user_visitors = {
  labels: {!! ao($analytics, 'user_visitors.labels') ?? '[]' !!},
  series: [{
  name: "{{ __('Visits') }}",
  data: {!! ao($analytics, 'user_visitors.visits') ?? '[]' !!}
  }, {
  name: "{{ __('Unique') }}",
  data: {!! ao($analytics, 'user_visitors.unique') ?? '[]' !!}
  }],
  };
  </script>
  @endsection