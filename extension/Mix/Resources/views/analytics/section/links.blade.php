@extends('mix::layouts.master')
@section('title', __('Links Insight'))
@section('namespace', 'user-mix-analytics-links')
@section('content')
<div class="mix-padding-10">
    
<div class="card customize">
    <div class="card-header">
      <div class="flex items-center">
        <div class="h-avatar sm is-video bg-white mr-2">
          <i class="flaticon-analytics c-black"></i>
        </div>
  
        <p class="title m-0">{{ __('Links clicks') }}</p>
      </div>
    </div>
  </div>
  
  <div class="my-5">
      <div class="mort-main-bg insight-split-card rounded-2xl">
          <div class="split-card">
              <div class="heading">{{ __('Total Links') }}</div>
              <div class="bold-stats">{{ count($links) }}</div>
              <div class="sub-heading">
                  {{ __('All Time') }}
              </div>
          </div>
          <div class="split-card">
              <div class="heading">{{ __('Total Clicks') }}</div>
              <div class="bold-stats">{{ ao($linksVisit, 'visits') }}</div>
              <div class="sub-heading">
                  {{ __('All Time') }}
              </div>
          </div>
      </div>
  </div>
  
  <div>
      <div class="p-5 mort-main-bg rounded-2xl">
          <div class="bg-white p-3 flex justify-between items-center mb-5 rounded-xl">
              <p class="title text-sm m-0">{{ __('All Clicks') }}</p>
          </div>
          <div class="flex-table is-insight">
              <!--Table header-->
              <div class="flex-table-header">
                  <span class="is-grow">{{ __('Link') }}</span>
                  <span>{{ __('Views') }}</span>
                  <span></span>
              </div>
              <!--Table item-->
  
              @foreach ($links as $key => $value)
              <div class="flex-table-item rounded-xl">
                  <div class="flex-table-cell is-media is-grow" data-th="">
                      <div>
                          <span class="item-meta text-xs">{{ $key }}</span>
                          <span class="item-meta text-xs break-all">{{ ao($value, 'link') }}</span>
                      </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Views') }}">
                      <span class="light-text">{{ ao($value, 'visits') }}</span>
                  </div>
                  <div class="flex-table-cell text-xs" data-th="{{ __('Action') }}">
                      <a class="text-sticker ml-auto text-xs m-0 flex items-center" href="{{ route('user-mix-analytics-link', $key) }}">{{ __('View insight') }}</a>
                  </div>
              </div>
              @endforeach
          </div>
      </div>
  </div>
</div>
@endsection