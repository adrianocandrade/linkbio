@extends('admin::layouts.master')
@section('title', __('Overview'))
@section('content')
<div class="md:grid md:grid-cols-3 gap-4">
  <div class="col-span-2">
    <div class="details details-big mb-10">
      <div class="details-container">
        <div class="details-title h6">{{ __('Overview 💡') }}</div>
        <div class="grid md:grid-cols-3 gap-4">
          <div class="col-span-1">
            <div class="details-top">
              <div class="details-number h1">{{ \App\Models\MySession::activity(10)->hasUser()->count() }}</div>
              <a class="details-line" href="{{ route('admin-analytics') }}">
                <div class="details-preview">
                  <i class="sio science-and-fiction-098-equation"></i>
                </div>
                <div class="details-info caption-sm">{{ __('Logged in Users') }}</div>
              </a>
            </div>
            <div class="details-bottom hidden">
              
              <div class="details-info caption-sm color-gray"></div>
            </div>

            <div class="details-line block">
              <div class="details-preview">
                {{ number_format(ao($analytics, 'pending_plan')) }}
              </div>
              <div class="details-info caption-sm color-gray">{{ __('Number of Pending Payments') }}</div>
            </div>
            
            <a class="button sandy-quality-button" href="{{ route('admin-payments-pending') }}">{{ __('View Pending Payments') }}</a>
          </div>

        @foreach (ao($analytics, 'user_of_the_month') as $key => $value)
          <div class="col-span-2">
            <div class="fancy-user-single">
              <div class="info mb-7">
                <div class="grid grid-cols-3">
                  <div class="flex col-span-2 items-center">
                    <h3 class="m-0 font-bold md:text-xl">{{ __('User of the Month') }}</h3>
                  </div>
                  <div class="ml-auto">
                    <a class="tooltip-round-custom" href="{{ bio_url(ao($value, 'user')) }}" target="_blank">
                      <i class="sio seo-and-marketing-005-eye"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="grid grid-cols-3 info-mid mb-2">
                <div class="col-span-2 d-flex align-items-center">
                  <div class="left-text">
                    <h4>{{ user('name', ao($value, 'user')) }}</h4>
                    <p>{{ __('Views') }}</p>
                    <span>{{ nr(ao($value, 'visits')) }}</span>
                  </div>
                </div>
                <div class="col-7">
                  <div class="img" data-aos="fade-left" data-aos-delay="400">
                    <img src="{{ gs('assets/image/others', 'flame-6.png') }}" class="h-185px" alt="">
                  </div>
                </div>
              </div>
              
              <div class="avatar-side">
                <div class="avatar-inner">
                  <div class="avatar">
                    <img src="{{ avatar(ao($value, 'user')) }}" alt="">
                  </div>
                  <div class="details">
                    <h3>{{ user('email', ao($value, 'user')) }}</h3>
                    <a href="{{ bio_url(ao($value, 'user')) }}" app-sandy-prevent="" target="_blank" class="c-white">/{{ user('username', ao($value, 'user')) }}/</a>
                  </div>
                </div>
                <div class="arrow">
                  <i class="yti arrow_forward"></i>
                </div>
              </div>
            </div>
          </div>

          @endforeach
        </div>
        <div class="details-list mt-8">
          <div class="details-item">
            <div class="details-head">
              <div class="details-preview bg-purple">
                <i class="sio internet-053-group-users"></i>
              </div>
              <div class="details-text caption-sm">{{ __('Users') }}</div>
            </div>
            <div class="details-counter h3">{{ nr(ao($analytics, 'count_users')) }}</div>
            <div class="details-indicator">
              <div class="details-progress bg-purple" style="width: 52%;"></div>
            </div>
          </div>
          <div class="details-item">
            <div class="details-head">
              <div class="details-preview bg-pink">
                
              </div>
              <div class="details-text caption-sm">{{ __('Payments') }}</div>
            </div>
            <div class="details-counter h3">{{ number_format(ao($analytics, 'payments_count')) }}</div>
            <div class="details-indicator">
              <div class="details-progress bg-pink" style="width: 55%;"></div>
            </div>
          </div>
          <div class="details-item">
            <div class="details-head">
              <div class="details-preview bg-blue">

              </div>
              <div class="details-text caption-sm">{{ __('Plans') }}</div>
            </div>
            <div class="details-counter h3">{{ number_format(ao($analytics, 'plans_count')) }}</div>
            <div class="details-indicator">
              <div class="details-progress bg-blue" style="width: 60%;"></div>
            </div>
          </div>
          <div class="details-item">
            <div class="details-head">
              <div class="details-preview bg-orange">
                
              </div>
              <div class="details-text caption-sm">{{ __('Earnings') }}</div>
            </div>
            <div class="details-counter h3">{!! Currency::symbol(settings('payment.currency')) . nr(ao($analytics, 'totalEarnings')) !!}</div>
            <div class="details-indicator">
              <div class="details-progress bg-orange" style="width: 70%;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="sm:grid sm:grid-cols-2 gap-4">
      <div class="sandy-widget has-shadow">
        <div class="sandy-widget-top">
          <div class="sandy-widget-title mr-auto">{{ __('New Payments') }}</div>
          <a href="" class="widget-next">
            <i class="sni sni-arrow-right"></i>
          </a>
        </div>
        <div class="sandy-quality">
          <div class="sandy-quality-list">
            @forelse(ao($analytics, 'newPayments') as $item)
            @php
                $item = (object) $item;
            @endphp
            <div class="sandy-quality-item">
              <div class="sandy-quality-details">
                <div class="sandy-quality-line">
                  <div>{{ GetPlan('name', $item->plan) }}</div>
                  <div class="price">{{ $item->price }}</div>
                </div>
                <div class="sandy-quality-info caption-sm">{{ user('name', $item->user) }}</div>
              </div>
            </div>
            @empty
            <div class="is-empty text-center">
              <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
              <p class="mt-10 text-lg font-bold">{{ __('No new payment. 🙂') }}</p>
              <a href="{{ route('admin-new-plan') }}" app-sandy-prevent="" class="mt-5 text-xs c-black font-bold href-link-button block">{{ __('Create Plan') }}</a>
            </div>
            @endforelse
          </div>
          <a class="button sandy-quality-button bg-black" href="{{ route('admin-payments') }}">{{ __('Show all') }}</a>
        </div>
      </div>
      <div class="sandy-widget has-shadow mt-10 sm:mt-0">
        <div class="sandy-widget-top">
          <div class="sandy-widget-title mr-auto">{{ __('New Users') }}</div>
          <a href="{{ route('admin-users') }}" class="widget-next">
            <i class="sni sni-arrow-right"></i>
          </a>
        </div>
        <div class="sandy-quality">
          <div class="sandy-quality-list">
            @forelse (ao($analytics, 'newusers') as $item)
            @php
                $item = (object) $item;
            @endphp
            <div class="sandy-quality-item">
              <div class="preview bg-pink-opacity">
                <img src="{{ avatar($item->id) }}" class="rounded " alt="">
              </div>
              <div class="sandy-quality-details">
                <div class="sandy-quality-line">
                  <div>{{ $item->name }}</div>
                </div>
                <a class="sandy-quality-info href-link-button" target="_blank" href="{{bio_url($item->id)}}">/{{ $item->username }}/</a>
              </div>
            </div>
            @empty
            <div class="is-empty text-center">
              <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
              <p class="mt-10 text-lg font-bold">{{ __('No new user. 🙂') }}</p>
            </div>
            @endforelse
          </div>
          <a class="button sandy-quality-button bg-black" href="{{ route('admin-users') }}">{{ __('All Users') }}</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-span-1">
    <div class="widget-main is-earning mt-10 md:mt-0">
      
      <div class="widget-title">{{ __('Earning this month') }}</div>
      <div class="widget-counter color-purple">{{ nr(ao($analytics, 'thisMonthsEarnings')) }}</div>
      <a class="widget-text block" href="{{ route('admin-payments-plugins') }}">{{ __('Update your payment method in Settings') }}</a>
      <p class="is-cur mb-5">{!! __('In :currency', ['currency' => settings('payment.currency')]) !!}</p>
      <a class="button sandy-quality-button bg-black mt-0" href="#">{{ __('Show All Earnings') }}</a>
    </div>
    <div class="sandy-widget has-shadow mt-10">
      <div class="sandy-widget-top step-banner h-40">

        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle">{{ __('Users') }}</p>
            <h2 class="section-title text-lg">{{ __('Top Most Viewed Pages') }}</h2>
          </div>
        </div>
      </div>
      <div class="sandy-quality">
        <div class="sandy-quality-list">
          @forelse (ao($analytics, 'topUsers') as $item)
          <div class="sandy-quality-item">
            <a href="{{ bio_url(ao($item, 'user')) }}" target="_blank" class="preview bg-pink-opacity">
              <img src="{{ avatar(ao($item, 'user')) }}" class="rounded " alt="">
            </a>
            <div class="sandy-quality-details">
              <div class="sandy-quality-line">
                <div>{{ user('name', ao($item, 'user')) }}</div>
                <div class="nr">{{ nr(ao($item, 'visits')) }}</div>
              </div>
              <div class="sandy-quality-info caption-sm">{{ user('email', ao($item, 'user')) }}</div>
            </div>
          </div>
          @empty
          <div class="is-empty text-center">
            <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
            <p class="mt-10 text-lg font-bold">{{ __('No user found. 🙂') }}</p>
          </div>
          @endforelse
        </div>
        <a class="button sandy-quality-button bg-black" href="{{ route('admin-analytics-most-visited') }}">{{ __('View All') }}</a>
      </div>
    </div>
  </div>
</div>
@endsection