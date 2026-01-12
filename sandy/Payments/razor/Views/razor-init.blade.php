@extends('index::layouts.master')
@section('title', __('Hold on...'))
@section('content')

<style>
  header, footer{
    display: none !important;
  }
</style>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="index-hero is-payment-error">
  
  <div class="index-hero-container">
    <div class="hero-left pt-10 md:p-0 m-auto h-full">
      <div class="h-avatar bg-white is-video mb-5">
          <img src="{{ gs('assets/image/payments', 'razorpay-glyph.svg') }}" alt="">
      </div>
      <h1 class="mb-3 font-bold text-xl">{{ __('Opening RazorPay...') }}</h1>
      <p class="m-0 font-bold">{{__('Hold on... A RazorPay popup will be opened.')}}</p>
      <p class="mt-5 mb-0 italic underline text-sm">({{__('Note: if the popup does not come up, kindly go back and retry the process.')}})</p>

      <form name="form" action="{{ route('sandy-payments-razor-verify') }}" method="get">
          <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
          <input type="hidden" name="sxref" value="{{ $sxref }}">
      </form>
      <a href="{{ url()->previous() }}" app-sandy-prevent="" class="text-sticker">{{ __('Go Back!') }}</a>

    </div>
    </div>
</div>


  <script>
    var options = {!! $data !!};
    options.handler = function (response){
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.form.submit();
    };
    options.theme.image_padding = false;
    options.modal = {
        ondismiss: function() {
          window.location = "{{ route('index-home') }}";
        },
        escape: true,
        backdropclose: false
    };
    var rzp = new Razorpay(options);
    rzp.open();
  </script>
@stop