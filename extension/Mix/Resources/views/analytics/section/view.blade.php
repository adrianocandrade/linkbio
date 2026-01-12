@extends('mix::layouts.master')
@section('title', __('Analytics views'))
@section('namespace', 'user-mix-analytics-views')
@section('content')
<div class="mix-padding-10">
  <div class="card customize mb-5">
    <div class="card-header">
      <div class="flex items-center">
        <div class="h-avatar sm is-video bg-white mr-2">
          <i class="flaticon-analytics c-black"></i>
        </div>
        <p class="title m-0">{{ __('Views') }}</p>
      </div>
    </div>
  </div>
  <div class="p-2 md:p-5 mort-main-bg rounded-2xl">
    <div class="h-56 mort-main-bg">
      <div id="chart-earning" data-chart="chart" class="chart-line"></div>
    </div>
  </div>
  <div class="my-5">
    <div class="mort-main-bg insight-split-card rounded-2xl">
      <div class="split-card">
        <div class="heading">{{ __('Unique Views') }}</div>
        <div class="bold-stats">{{ ao($visitors, 'getviews.unique') }}</div>
        <div class="sub-heading">
          {{ __('All Time') }}
        </div>
      </div>
      <div class="split-card">
        <div class="heading">{{ __('Views') }}</div>
        <div class="bold-stats">{{ ao($visitors, 'getviews.visits') }}</div>
        <div class="sub-heading">
          {{ __('All Time') }}
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class="grid grid-cols-2 gap-3 md:gap-4">
      <div class="insight-card shadow-none bg-gray-10 mort-main-bg">
        <h2>{{ count(ao($visitors, 'cities')) }}</h2>
        <h5>{{ __('Cities') }}</h5>
        <a class="view href-link-button insight-cities-open">{{ __('View Details') }}</a>
      </div>
      <div class="insight-card shadow-none bg-gray-10 mort-main-bg">
        <h2>{{ count(ao($visitors, 'countries')) }}</h2>
        <h5>{{ __('Country') }}</h5>
        <a class="view href-link-button insight-countries-open">{{ __('View Details') }}</a>
      </div>
      <div class="insight-card shadow-none bg-gray-10 mort-main-bg">
        <h2>{{ count(ao($visitors, 'devices')) }}</h2>
        <h5>{{ __('Device Os') }}</h5>
        <a href="#" class="view href-link-button insight-devices-open">{{ __('View Insight') }}</a>
      </div>
      <div class="insight-card shadow-none bg-gray-10 mort-main-bg">
        <h2>{{ count(ao($visitors, 'browsers')) }}</h2>
        <h5>{{ __('Browser') }}</h5>
        <a class="view href-link-button insight-browsers-open">{{ __('View Insight') }}</a>
      </div>
    </div>
  </div>
  <div data-popup=".insight-cities" class="p-0">
    <div class="sandy-dialog-overflow">
      
      <div class="card customize mb-10">
        <div class="card-header">
          <div class="flex items-center mb-3">
            <div class="h-avatar sm is-video bg-white mr-2">
              <i class="sni sni-flag c-black"></i>
            </div>
            <p class="title m-0">{{ __('Cities') }}</p>
          </div>
          <p class="subtitle">{{ __('Get to know which city your visitors come from.') }}</p>
        </div>
      </div>
      
      <div>
        <div class="flex-table is-insight">
          @foreach (ao($visitors, 'cities') as $key => $item)
          <div class="flex-table-item no-shadow mort-main-bg rounded-xl">
            <div class="flex-table-cell is-media is-grow" data-th="">
              <div class="h-avatar sm is-trans">
                <img src="{{ Country::icon(ao($item, 'iso')) }}" class="w-full h-full" alt=" ">
              </div>
              <div>
                <span class="item-name text-xs">{{ $key }}</span>
                <span class="item-meta text-xs">{{ ao($item, 'iso') }}</span>
              </div>
            </div>
            <div class="flex-table-cell p-0 justify-end" data-th="{{ __('Views') }}">
              <span class="tag is-success is-rounded">{{ nr(ao($item, 'visits')) }}</span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <button class="insight-cities-close hidden" data-close-popup><i class="flaticon-close"></i></button>
  </div>
  <div data-popup=".insight-countries" class="p-0">
    <div class="sandy-dialog-overflow">
      
      <div class="card customize mb-10">
        <div class="card-header">
          <div class="flex items-center mb-3">
            <div class="h-avatar sm is-video bg-white mr-2">
              <i class="sni sni-flag c-black"></i>
            </div>
            <p class="title m-0">{{ __('Countries') }}</p>
          </div>
          <p class="subtitle">{{ __('Get to know which country your visitors come from.') }}</p>
        </div>
      </div>
      <div>
        <div class="flex-table is-insight">
          @foreach (ao($visitors, 'countries') as $key => $item)
          <div class="flex-table-item no-shadow mort-main-bg rounded-xl">
            <div class="flex-table-cell is-media is-grow" data-th="">
              <div class="h-avatar sm is-trans">
                <img src="{{ Country::icon($key) }}" class="w-full h-full" alt=" ">
              </div>
              <div>
                <span class="item-name text-xs">{{ ao($item, 'name') }}</span>
                <span class="item-meta text-xs">{{ $key }}</span>
              </div>
            </div>
            <div class="flex-table-cell p-0 justify-end" data-th="{{ __('Views') }}">
              <span class="tag is-success is-rounded">{{ nr(ao($item, 'visits')) }}</span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <button class="insight-countries-close hidden" data-close-popup><i class="flaticon-close"></i></button>
  </div>
  <div data-popup=".insight-devices" class="p-0">
    <div class="sandy-dialog-overflow">
      
      <div class="card customize mb-10">
        <div class="card-header">
          <div class="flex items-center mb-3">
            <div class="h-avatar sm is-video bg-white mr-2">
              <i class="la la-phone-alt c-black"></i>
            </div>
            <p class="title m-0">{{ __('Devices') }}</p>
          </div>
          <p class="subtitle">{{ __('Get to know which devices your visitors use.') }}</p>
        </div>
      </div>
      <div>
        @foreach (ao($visitors, 'devices') as $key => $item)
        <div class="flex justify-between items-center mort-main-bg p-5 mb-4 rounded-xl">
          <span class="item-name text-xs">{{ ao($item, 'name') }}</span>
          <span class="tag is-success is-rounded">{{ nr(ao($item, 'visits')) }}</span>
        </div>
        @endforeach
      </div>
    </div>
    <button class="insight-devices-close hidden" data-close-popup><i class="flaticon-close"></i></button>
  </div>
</div>
<div data-popup=".insight-browsers" class="p-0">
  <div class="sandy-dialog-overflow">
    
    <div class="card customize mb-10">
      <div class="card-header">
        <div class="flex items-center mb-3">
          <div class="h-avatar sm is-video bg-white mr-2">
            <i class="sni sni-browser c-black"></i>
          </div>
          <p class="title m-0">{{ __('Browsers') }}</p>
        </div>
        <p class="subtitle">{{ __('Get to know which browsers your visitors use.') }}</p>
      </div>
    </div>
    <div>
      @foreach (ao($visitors, 'browsers') as $key => $item)
      <div class="flex justify-between items-center mort-main-bg p-5 mb-4 rounded-xl">
        <span class="item-name text-xs">{{ ao($item, 'name') }}</span>
        <span class="tag is-success is-rounded">{{ nr(ao($item, 'visits')) }}</span>
      </div>
      @endforeach
    </div>
  </div>
  <button class="insight-browsers-close hidden" data-close-popup><i class="flaticon-close"></i></button>
</div>
<script id="chart">
  var chart = {
    colors: ['rgb(52, 132, 145)', 'rgb(255, 99, 152)'],
    textColor: '#000',
    labels: {!! ao($visitors, 'thisyear.labels') ?? '[]' !!},
      series: [{
        name: "{{ __('Visits') }}",
        data: {!! ao($visitors, 'thisyear.visits') ?? '[]' !!}
      }, {
        name: "{{ __('Unique') }}",
        data: {!! ao($visitors, 'thisyear.unique') ?? '[]' !!}
      }],
  };
</script>
@endsection