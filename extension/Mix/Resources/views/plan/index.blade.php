@extends('mix::layouts.master')
@section('title', __('Purchase Plan'))
@section('namespace', 'user-mix-purchase-plan')
@section('head')
  {!! \SandyCaptcha::head() !!}
@stop
@section('content')

<div class="inner-page-banner mb-10">
    <h1>{{ $plan->name }}</h1>
    <p>{{ __('Choose your preferred payment duration') }}</p>
</div>

<input type="hidden" id="plan-base" value="{{ route('user-mix-purchase-plan', $plan->id) }}">

<section class="plan-duration center mb-10">
    <div class="grid grid-cols-2 gap-4">

        @foreach ($array($prices) as $key => $value)
        <label class="sandy-big-checkbox">
          <input type="radio" name="duration" data-duration="{{ ucfirst($key) }}" data-price="{{ $value }}" class="sandy-input-inner" value="{{ $key }}">
            <div class="checkbox-inner rounded-2xl">
              <div class="checkbox-wrap">
                  <div class="content">
                      <h1 class="text-lg font-bold">{!! price_with_cur(\Currency::symbol(settings('payment.currency')), $value) !!}</h1>
                      <h1>{{ ucfirst($key) }}</h1>
                      <p>{{ __("Pay once $key") }}</p>
                  </div>
                  <div class="icon">
                      <div class="active-dot">
                          <i class="la la-check"></i>
                      </div>
                  </div>
              </div>
            </div>
        </label>
        @endforeach

    </div>
</section>


<section class="plan-payment-method mb-10">
    <div class="mort-main-bg p-5">
            
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach ($payments as $key => $item)
                <label class="sandy-big-checkbox {{ settings("payment_$key.status") ? '' : 'hidden' }}">
                  <input type="radio" name="method" class="sandy-input-inner" data-payment-method="{{ $array($item, 'name') }}" value="{{ $key }}">
                    <div class="checkbox-inner">
                      <div class="checkbox-wrap">
                        <div class="h-avatar">
                            <img src="{{ getStorage('assets/image/payments', $array($item, 'thumbnail')) }}" alt="">
                        </div>
                          <div class="content">
                              <h1>{{ $array($item, 'name') }}</h1>
                              <p>{{ __($array($item, 'description')) }}</p>
                          </div>
                          <div class="icon">
                              <div class="active-dot">
                                  <i class="la la-check"></i>
                              </div>
                          </div>
                      </div>
                    </div>
                </label>
            @endforeach

        </div>

    </div>
</section>


<div class="invoice">
    
</div>


<div class="summary card md:mx-24 mx-6 mb-10">

    <div class="card-shadow p-5 rounded-3xl">
        <div class="card-header mort-main-bg mb-5 p-5 rounded-3xl">
            <p class="title">{{ __('Summary') }}</p>
        </div>
        <div class="flex justify-between mb-5">
            <span class="text-muted text-sm font-bold">{{ __('Plan') }}</span>
            <span class="text-sm">{{$plan->name}}</span>
        </div>

        <div class="flex justify-between mb-5">
            <span class="text-sm font-bold">{{ __('Duration') }}</span>
            <span class="data-duration text-sm text-right">
                <span class="name">{{ __('Monthly') }}</span>
                <small class="block">{{ __('Pay once') }} <span>{{ __('monthly') }}</span></small>
            </span>
        </div>

        <div class="flex justify-between mb-5">
            <span class="text-sm font-bold">{{ __('Payment Method') }}</span>
            <span class="data-payment-method text-sm text-right">{{ __('Not Selected') }}</span>
        </div>

        <div class="flex justify-between mb-8">
            <span class="text-sm font-bold">{{ __('Total') }}</span>
            <span class="data-total text-sm text-right"><span>{{ __('Duration not set') }}</span></span>
        </div>



        <div id="form-plan">
            <form action=""></form>
        </div>

        @if ($hasInvoice)
            <form action="{{ route('user-mix-plan-invoice', $plan->id) }}" class="proceed-form">
                @csrf
                <input type="hidden" name="gateway" value="">
                <input type="hidden" name="duration" value="">
                <div class="my-7">
                    {!! terms_and_privacy(__('Proceed')) !!}
                </div>
                <button class="button sandy-quality-button mt-0 is-loader-submit loader-white">{{ __('Proceed') }}</button>
            </form>

            @else

            <form action="{{ route('user-mix-plan-payment-post', $plan->id) }}" method="post" class="proceed-form">
                @csrf
                <input type="hidden" name="gateway" value="">
                <input type="hidden" name="duration" value="">
                <div class="my-7">
                    {!! terms_and_privacy(__('Proceed')) !!}
                </div>
                
                <div class="my-5 flex justify-center">
                  {!! \SandyCaptcha::html() !!}
                </div>

                <button class="button sandy-quality-button mt-0 is-loader-submit loader-white">{{ __('Proceed') }}</button>
            </form>
        @endif
    </div>
</div>
@endsection
