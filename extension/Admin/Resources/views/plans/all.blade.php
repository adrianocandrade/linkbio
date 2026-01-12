@extends('admin::layouts.master')
@section('title', __('All Plans'))
@section('namespace', 'admin-plans')
@section('content')
<div class="step-banner">
  <div class="section-header">
    <div class="section-header-info">
      <p class="section-pretitle">{{ __('Plans') }} ({{ number_format(\App\Models\Plan::count()) }})</p>
      <h2 class="section-title">{{ __('All Plans') }}</h2>
      <p class="mt-5 italic text-xs">{{ __('(Note: drag plan cards to reorder.)') }}</p>
      <a href="#" class="section-header-action mt-5 add-user-modal-open text-sticker">{{ __('Add a User to Plan') }}</a>
    </div>
    <div class="section-header-actions">
      <a href="{{ route('admin-new-plan') }}" class="section-header-action">{{ __('Create New Plan') }} +</a>
    </div>
  </div>
</div>
<div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-10 sortable" data-delay="250" data-route="{{ route('admin-plans-sort') }}">
  @foreach ($plans as $item)
  <div class="sandy-widget has-shadow mt-10 sm:mt-0 sortable-item" data-id="{{ $item->id }}">
    <div class="sandy-widget-top">
      <div class="step-banner mb-5 plan-star">
        @if (ao($item->extra, 'featured'))
        <span class="star-span"><i class="sio project-management-090-ribbon-badge"></i></span>
        @endif
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle">{{ ucfirst($item->price_type) }}</p>
            <h2 class="section-title text-base">{{ $item->name }}</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="sandy-quality">
      <div class="sandy-quality-list">
        <div class="sandy-quality-item mb-5">
          <div class="preview bg-pink-opacity">
            <i class="sio network-icon-069-users text-2xl"></i>
          </div>
          <div class="sandy-quality-details">
            <div class="sandy-quality-line">
              <div class="text-xs">{{ __('Current Users') }}</div>
            </div>
            <a class="sandy-quality-info href-link-button" href="{{ route('admin-users', ['plan' => $item->id]) }}">{{ \App\Models\Plan::count_users($item->id) }}</a>
          </div>
        </div>
        <div class="sandy-quality-item">
          <div class="preview bg-pink-opacity">
            <i class="sio design-and-development-098-key text-2xl"></i>
          </div>
          <div class="sandy-quality-details">
            <div class="sandy-quality-line">
              <div class="text-xs">{{ __('Number Of Activations') }}</div>
            </div>
            <p class="sandy-quality-info href-link-button">{{ \App\Models\PlansHistory::count_history($item->id) }}</p>
          </div>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4 mt-5">
        
        <a href="{{ route('admin-edit-plan', $item->id) }}" class="text-sticker flex items-center justify-center">{{ __('Edit') }}</a>
        <form action="{{ route('admin-plans-delete', $item->id) }}" method="POST" class="w-full">
          @csrf
          <button data-delete="{{ __('Are you sure you want to delete :plan_name Plan?', ['plan_name' => $item->name]) }}" class="text-sticker delete bg-red-500 text-white flex items-center justify-center w-full">{{ __('Delete') }}</button>
        </form>
      </div>
    </div>
  </div>
  @endforeach
</div>
<div data-popup=".add-user-modal">
  <form action="{{ route('admin-plans-add-to-user') }}" method="POST">
    @csrf
    <div class="grid md:grid-cols-2 grid-cols-1 gap-4">
      <div class="form-input">
        <label class="initial">{{ __('Plan') }}</label>
        <select name="plan_id">
          @foreach ($plans as $plan)
             <option value="{{ $plan->id }}">{{ $plan->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-input">
        <label class="initial">{{ __('User') }}</label>
        <select name="user_id">
          @foreach (\App\User::get() as $user)
             <option value="{{ $user->id }}">{{ '@' . $user->username }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-input mt-5">
      <label class="initial">{{ __('Duration') }}</label>
      <input
      id="date-selector"
      type="text"
      name="date"
      autocomplete="off"
      readonly="readonly"
      class="sandy-analytics-date"
      >
    </div>
    <button class="text-sticker is-loader-submit mb-0 is-submit mt-5">{{ __('Save') }}</button>
  </form>
</div>

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
    var datepicker = jQuery('#date-selector').datepicker({
        language: 'en',
        dateFormat: 'yyyy-mm-dd',
        autoClose: false,
        timepicker: false,
        inline: false,
        classes: 'card-shadow border-0 p-5 rounded-2xl',
        toggleSelected: false,
        startDate: new Date(),
        position: "top right"
    }).click(function(e) {
       jQuery('[data-popup]').show();
    });
</script>
@stop
@endsection