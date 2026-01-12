@extends('index::layouts.master')
@section('title', __('Hold on...'))
@section('content')

<style>
  header, footer{
    display: none !important;
  }
</style>
<div class="index-hero is-payment-error">
  
  <div class="index-hero-container">
    <div class="hero-left pt-10 md:p-0 m-auto h-full">
      <div class="h-avatar bg-white is-video mb-5">
          <img src="{{ gs('assets/image/payments', 'paytm-logo.png') }}" alt="">
      </div>
      <p class="m-0 font-bold">{{__('Hold on... Please enter your phone number to proceed.')}}</p>
      <p class="mt-5 mb-0 italic underline text-sm">({{__('Note: This info is required by PayTM before proceeding. Kindly fill in the below field.')}})</p>

      <form class="mt-5" action="{{ route('sandy-payments-paytm-create') }}" method="get">

          <div class="form-input">
            <label for="">{{ __('Phone Number') }}</label>
            <input type="text" name="phone">
          </div>

          <input type="hidden" name="sxref" value="{{ $sxref }}">

          <button class="text-sticker mt-5">{{ __('Proceed') }}</button>
      </form>

    </div>
    </div>
</div>
@stop