@extends('admin::layouts.master')
@section('title', __('Most Visited'))
@section('content')
<div class="sandy-page-row">
  <div class="sandy-page-col pl-0 mx-auto relative">
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
            <p class="section-pretitle">{{ __('Visits') }}</p>
            <h2 class="section-title">{{ __('Your most visited users') }}</h2>
          </div>
        </div>
      </div>
    </div>
    @if (count($visted) > 0)
    <div class="flex-table">
      <!--Table header-->
      <div class="flex-table-header">
        <span class="is-grow">{{ __('Customer') }}</span>
        <span>{{ __('Info') }}</span>
        <span class="cell-end">{{ __('Views') }}</span>
      </div>
      @foreach ($visted as $item)
      
      <div class="flex-table-item rounded-2xl">
        <a href="{{ bio_url(user('id', ao($item, 'user'))) }}" target="_blank" class="flex-table-cell is-media is-grow" data-th="">
          <div class="h-avatar md is-video" style="background: {{ao(user('settings', ao($item, 'user')), 'avatar_color')}}">
            <img class="avatar is-squared lozad" data-src="{{ avatar(ao($item, 'user')) }}" alt="">
          </div>
          <div>
            <span class="item-name mb-2">{{ user('name', ao($item, 'user')) }}</span>
            <span class="item-meta">
              <span>{{ user('email', ao($item, 'user')) }}</span>
            </span>
          </div>
        </a>
        <div class="flex-table-cell" data-th="{{ __('Info') }}">
          <div class="flex ml-auto md:ml-0">
            <div class="text-sticker m-0 mr-2 xs" data-hover="{{ __('Registered on - :date', ['date' => \Carbon\Carbon::parse(user('created_at', ao($item, 'user')))->toDayDateTimeString()]) }}">
              <i class="la la-clock text-lg"></i>
            </div>
            <div class="text-sticker m-0 is-flag xs shadow-none">
              <img src="{{ Country::icon(user('lastCountry', ao($item, 'user'))) }}" alt="">
            </div>
          </div>
        </div>
        <div class="flex-table-cell cell-end" data-th="{{ __('Views') }}">
          <span class="text-sticker ml-auto my-0 bg-blue2 text-white">{{ __('Views') }} - {{ number_format(ao($item, 'visits')) }}</span>
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
</div>
@endsection