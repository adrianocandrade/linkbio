@extends('layouts.app')
@section('title', __('Two-Factor Authentication'))
@section('content')
<div class="auth-row justify-center">
  <div class="auth-col hidden"></div>
  <div class="auth-col">
    <div class="landing-form items-center flex-col">
      <div class="auth-go-back mb-10">
        <a href="{{ route('user-login') }}" class="auth-go-back-a">
          <i class="la la-arrow-left"></i>
        </a>
      </div>
      <div class="form-box login-register-form-element p-0 lg:p-10">
        <div class="mb-16">
          <h2 class="form-box-title text-2xl mb-1">{{ __('Two-Factor Verification') }}</h2>
          <span display="inline" class="text-sm">{{ __('Please enter the code from your authenticator app.') }}</span>
        </div>
        
        <div class="login-include">
            <form class="form" method="post" action="{{ route('2fa.verify') }}">
                @csrf
                <div class="form-row">
                    <div class="form-item">
                        <div class="form-input">
                            <label for="code">{{ __('Verification Code') }}</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" required autofocus placeholder="000000" style="text-align: center; letter-spacing: 5px; font-size: 1.5rem;" autocomplete="off">
                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-row mt-10">
                    <div class="form-item">
                        <button class="shadow-none w-full button bg-blue-600 text-white toast-custom-close sandy-loader-flower">{{ __('Verify') }}</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
