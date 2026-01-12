@extends('install::layouts.master')
@section('title', 'User')
@section('content')
<div class="m-auto">
    <div class="relative z-50">
        
        <form class="card is-install-card p-0 card_widget card-shadow mx-5 md:mx-20" action="{{ route('install-steps-user-post') }}" method="POST">
            @csrf
            <div class="card-container">
                <div class="side-cta is-small">
                    <img src="{{ gs('assets/image/others/Asset-555.png') }}" alt="">
                </div>
                <div class="flex items-center mb-5">
                    <i class="text-4xl sio database-and-storage-055-security-shield mr-3"></i>
                </div>
                <p class="mb-7">Enter user information for default/admin user.</p>
                <div>
                    <div class="form-input mb-5">
                        <label for="name">{{ __('Name') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input mb-5">
                        <label for="name">{{ __('Username') }}</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}">
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-input mb-5">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ !empty(old('email')) ? old('email') : request()->get('email') }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="md:grid md:grid-cols-2 gap-4">
                        <div class="form-input mb-5 is-password md:mb-0 show-hide-password">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <div class="show-password">
                                    <i class="sni sni-eye"></i>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-input">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex relative z-50">
                    <button class="ml-auto text-sticker">{{ __('Proceed') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection