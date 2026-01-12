@extends('layouts.app')
@section('title', __('Reset Password'))
@section('namespace', 'user-login-reset-pw')
@section('content')
<div class="">
    <div class="landing-form col-span-2 min-h-screen">
        <div class="form-box login-register-form-element m-auto">
            <!-- /FORM BOX DECORATION -->
            <div class="mb-20">
                <h2 class="form-box-title text-2xl mb-1">{{ __('Reset Password') }}</h2>
                <span display="inline" class="text-sm">{{ __('Enter your new password.') }}</span>
            </div>
            
            <!-- FORM -->
            <form class="form" method="post" action="{{ route('user-login-reset-pw-post', ['token' => $password->token]) }}" autocomplete="off">
                @csrf
                <div class="form-input mb-5">
                    <label>{{ __('New Password') }}</label>
                    <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="off">

                    <div class="text-xs italic">{{ __('(Note: password must have at least one uppercase, lowercase number, special characters)') }}</div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-input mb-5">
                    <label>{{ __('Confirm Password') }}</label>
                    <input type="text" class="form-control" name="password_confirmation">
                </div>
                <!-- FORM ROW -->
                <div class="form-row mt-5">
                    <!-- FORM ITEM -->
                    <div class="form-item">
                        <!-- BUTTON -->
                        <button class="button w-full">{{ __('Reset') }}</button>
                        <!-- /BUTTON -->
                    </div>
                    <!-- /FORM ITEM -->
                </div>
                <!-- /FORM ROW -->
            </form>
        </div>
    </div>
</div>
@endsection