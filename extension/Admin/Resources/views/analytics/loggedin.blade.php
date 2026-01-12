@extends('admin::layouts.master')
@section('title', __('Logged in'))
@section('namespace', 'admin-analytics-logged-in')
@section('content')
<div class="sandy-page-row">
  <div class="sandy-page-col pl-0 relative">
    @if (!\App\License::has_full_license())
    
    <div class="not-plan">
      <div class="content">
        <div class="card card_widget mb-0">
          <div class="section-header">
            <div class="section-header-info">
              <div class="flex items-center mb-2">
                <i class="sio web-hosting-052-error-page text-4xl"></i>
              </div>
              <p class="text-sm">{{ __('Analytics are available on EXTENDED version of this script.') }}</p>
              <div class="section-header-actions mt-2">
                <a href="{{ route('admin-license-index') }}" app-sandy-prevent="" class="section-header-action text-sticker bg-gray-200 text-white">{{ __('Update license') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="opacity-reduce"></div>
    </div>
    @endif
    <div class="page__head">
      <div class="step-banner remove-shadow">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle">{{ __('Users') }}</p>
            <h2 class="section-title">{{ __('Logged in users') }}</h2>
          </div>
        </div>
      </div>
    </div>
    @if (count($live) > 0)
    <div class="flex-table">
      <!--Table header-->
      <div class="flex-table-header">
        <span class="is-grow">{{ __('Customer') }}</span>
        <span>{{ __('Status') }}</span>
        <span>{{ __('Info') }}</span>
        <span class="cell-end">{{ __('Actions') }}</span>
      </div>
      @foreach ($live as $item)
      <div class="flex-table-item rounded-2xl">
        <a href="{{ bio_url(user('id', $item->user_id)) }}" target="_blank" class="flex-table-cell is-media is-grow" data-th="">
          <div class="h-avatar md is-video" style="background: {{ao(user('settings', $item->user_id), 'avatar_color')}}">
            <img class="avatar is-squared lozad" data-src="{{ avatar($item->user_id) }}" alt="">
          </div>
          <div>
            <span class="item-name mb-2">{{ user('name', $item->user_id) }}</span>
            <span class="item-meta">
              <span>{{ user('email', $item->user_id) }}</span>
            </span>
          </div>
        </a>
        <div class="flex-table-cell" data-th="{{ __('Status') }}">
          <div class="ml-auto md:mx-auto">
            @if (user('status', $item->user_id))
            <span class="text-sticker m-0 bg-green text-white">{{ __('Active') }}</span>
            @else
            <span class="text-sticker m-0 bg-red-500 flex items-center text-white">{{ __('Disabled') }}</span>
            @endif
          </div>
        </div>
        <div class="flex-table-cell" data-th="{{ __('Info') }}">
          <div class="flex ml-auto">
            <div class="text-sticker m-0 mr-2 xs" data-hover="{{ __('Registered on - :date', ['date' => \Carbon\Carbon::parse(user('created_at', $item->user_id))->toDayDateTimeString()]) }}">
              <i class="la la-clock text-lg"></i>
            </div>
            <div class="text-sticker m-0 mr-2 xs" data-hover="{{ __('Last Activity - :date', ['date' => \Carbon\Carbon::parse(user('lastActivity', $item->user_id))->toDayDateTimeString()]) }}">
              <i class="la la-user-clock text-lg"></i>
            </div>
            <div class="text-sticker m-0 is-flag xs shadow-none">
              <img src="{{ Country::icon(user('lastCountry', $item->user_id)) }}" alt="">
            </div>
          </div>
        </div>
        <div class="flex-table-cell cell-end" data-th="{{ __('Actions') }}">
          <a href="{{ route('admin-analytics-logged-in', ['insight' => $item->id]) }}" class="text-3xl ml-auto"><i class="sio banking-finance-flaticon-015-analysis"></i></a>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="is-empty p-10 text-center">
      <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
      <p class="mt-10 text-lg font-bold">{{ __('No User Found.') }}</p>
    </div>
    @endif
  </div>
  <div class="sandy-page-col sandy-page-col_pt100 md:p-10">
    <div class="card card_widget">
      <div class="card__head card__head_mb32">
        <div class="card__title h6">{{ __('Insight') }}</div>
      </div>
      @if ($insight)
      <div class="mix-padding-10 mort-main-bg mb-10 grid grid-cols-1 gap-4 rounded-2xl">
        <div class="">
          <div class="card customize mb-10">
            <div class="card-header">
              <div class="flex items-center mb-3">
                <div class="h-avatar sm is-video bg-white mr-2 hidden md:flex">
                  <i class="la la-phone c-black"></i>
                </div>
                <p class="text-sm m-0">{{ __('Device') }}</p>
              </div>
            </div>
          </div>
          <div>
            <div class="flex justify-between items-center bg-white p-5 mb-4 rounded-2xl">
              <span class="item-name text-xs">{{ ao($insight->tracking, 'agent.os') }}</span>
            </div>
          </div>
        </div>
        <div class="">
          <div class="card customize mb-10">
            <div class="card-header">
              <div class="flex items-center mb-3">
                <div class="h-avatar sm is-video bg-white mr-2 hidden md:flex">
                  <i class="sni sni-browser c-black"></i>
                </div>
                <p class="text-sm m-0">{{ __('Browsers') }}</p>
              </div>
            </div>
          </div>
          <div>
            <div class="flex justify-between items-center bg-white p-5 mb-4 rounded-2xl">
              <span class="item-name text-xs">{{ ao($insight->tracking, 'agent.browser') }}</span>
            </div>
          </div>
        </div>
        <div class="col-span-1">
          
          <div class="card customize mb-10">
            <div class="card-header">
              <div class="flex items-center mb-3">
                <div class="h-avatar sm is-video bg-white mr-2 hidden md:flex">
                  <i class="sni sni-flag c-black"></i>
                </div>
                <p class="text-sm m-0">{{ __('Country') }}</p>
              </div>
            </div>
          </div>
          <div>
            <div class="flex-table is-insight">
              <div class="flex-table-item no-shadow bg-white rounded-2xl">
                <div class="flex-table-cell is-media is-grow" data-th="">
                  <div class="h-avatar sm is-trans">
                    <img src="{{ Country::icon(ao($insight->tracking, 'country.iso')) }}" class="w-full h-full" alt=" ">
                  </div>
                  <div>
                    <span class="item-name text-xs">{{ ao($insight->tracking, 'country.city') }}, {{ ao($insight->tracking, 'country.iso') }}</span>
                    <span class="item-meta text-xs">{{ ao($insight->tracking, 'country.name') }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @else
      <div class="is-empty full p-10 text-center">
        <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="m-auto" alt="">

        <p class="mt-10 text-lg font-bold">{{ __('Click on the insight to see here.') }}</p>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection