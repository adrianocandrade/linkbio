@extends('layouts.app')
@section('head')
{!! \SandyCaptcha::head() !!}
@stop
@section('title', __('Need activation'))
@section('content')
<div class="auth-row justify-center">
  <div class="auth-col hidden"></div>
  <div class="auth-col">
    <div class="landing-form items-center flex-col">
      <div class="auth-go-back mb-10">
        <a href="{{ route('user-logout') }}" class="auth-go-back-a">
          <i class="la la-arrow-left"></i>
        </a>
      </div>
      <div class="form-box login-register-form-element p-0 lg:p-10">
        <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half" alt="">
        <p class="mt-10 text-lg font-bold">{{ __('Email needs activation. Kindly check your inbox for verification link.') }}</p>
        <p class="my-10 italic">{{ __('Or') }}</p>
        <form action="{{ route('user-reset-activate-email') }}" method="post" class="mt-10">
          @csrf

          <div class="my-5">
            {!! \SandyCaptcha::html() !!}
          </div>
          <button class="text-sticker">{{ __('Resend') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection