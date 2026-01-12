@extends('bio::layouts.master')
@section('content')
@section('head')

<style>
    .bio-menu{
        display: none !important;
    }
    #zuck-modal #zuck-modal-content .story-viewer .slides .item > .media{
        object-fit: contain !important;
    }

    #zuck-modal #zuck-modal-content .story-viewer .head .left .time{
        display: none !important;
    }
</style>
@stop

<div class="p-7 flex items-center justify-center mt-20 relative z-10">
  
    <div class="flex flex-col text-center items-center w-full max-w-md">

      {!! orion('checkbox-confirm-circle-1', 'w-20 h-20 stroke-current text-green-400 mb-5 relative z-10') !!}
      <div class="font-bold text-3xl --c-text-title">{{ __('Your appointment booking is successful.') }}</div>
      <div class="font-light text-sm mt-3 --c-text-title hidden">{{ __('You can view the appointment booking info in the “Appointment” section.') }}</div>
  
  
      <a app-sandy-prevent="" href="{{ $sandy->route('sandy-blocks-booking-booking') }}" class="button mt-10 w-full h-16 rounded-lg flex items-center justify-center text-lg font-bold relative z-20">{{ __('Continue Booking') }}</a>
      <a href="{{ $sandy->route('sandy-blocks-booking-bookings') }}" class="auth-link mt-2 w-full justify-center h-16 rounded-3xl mb-10 flex items-center font-bold relative z-20">{{ __('Go to bookings') }}</a>
    </div>
  </div>
@endsection