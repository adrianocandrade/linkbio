@extends('layouts.app')
@section('title', __('Login'))
@section('head')
{!! \SandyCaptcha::head() !!}
@stop
@section('content')
<div class="auth-row justify-center">
  <div class="auth-col hidden"></div>
  <div class="auth-col">
    <div class="landing-form items-center flex-col">
      <div class="auth-go-back mb-10">
        <a href="{{ route('auth-index') }}" class="auth-go-back-a">
          <i class="la la-arrow-left"></i>
        </a>
      </div>
      <div class="form-box login-register-form-element p-0 lg:p-10">
        <div class="mb-16">
          <h2 class="form-box-title text-2xl mb-1">{{ __('Sign in to :website', ['website' => config('app.name')]) }}</h2>
          <span display="inline" class="text-sm">{{ __('Lot of fun things to do ;)') }}</span>
        </div>
        @include('auth.include.login')
      </div>
    </div>
  </div>
</div>
@endsection