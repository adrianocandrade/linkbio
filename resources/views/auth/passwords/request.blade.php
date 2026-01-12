@extends('layouts.app')
@section('title', __('Request reset Password'))
@section('namespace', 'user-login-reset-pw-request')
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
                <!-- /FORM BOX DECORATION -->
                <div class="mb-20">
                    <h2 class="form-box-title text-2xl mb-1">{{ __('Request Reset Link') }}</h2>
                    <span display="inline" class="text-sm">{{ __('Enter your email below and we would send you a reset password link.') }}</span>
                </div>
                
                <!-- FORM -->
                <form class="form" method="post" action="{{ route('user-login-reset-pw-request-post') }}">
                    @csrf
                    <div class="form-input mb-5">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="my-5 flex justify-center">
                        {!! \SandyCaptcha::html() !!}
                    </div>
                    <!-- FORM ROW -->
                    <div class="form-row mt-5">
                        <!-- FORM ITEM -->
                        <div class="form-item">
                            <!-- BUTTON -->
                            <button class="button sandy-loader-flower w-full">{{ __('Send Email') }}</button>
                            <!-- /BUTTON -->
                        </div>
                        <!-- /FORM ITEM -->
                    </div>
                    <!-- /FORM ROW -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection