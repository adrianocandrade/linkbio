@extends('layouts.app')
@section('title', __('Register'))
@section('namespace', 'register')
@section('content')
@section('head')
{!! \SandyCaptcha::head() !!}
@stop
@section('footerJS')
<script>
    function password_checker() {
        return {
            password: '',
            field_timer: '',

            response: {
                data: ''
            },
            
            password_checker_send: function(){
                if (this.field_timer) {
                    clearTimeout(this.field_timer);
                    this.field_timer = null;
                }
                this.field_timer = setTimeout(() => {
                    axios.post("{{ route('auth-validate-password') }}", {password: this.password}).then(r => {
                        this.response.data = r.data;
                    });
                }, 500);
            }
        }
    }
    function username_checker() {
        return {
            username: '',
            field_timer: '',

            response: {
                data: ''
            },
            
            username_checker_send: function(){
                if (this.field_timer) {
                    clearTimeout(this.field_timer);
                    this.field_timer = null;
                }
                this.field_timer = setTimeout(() => {
                    axios.post("{{ route('auth-check-username') }}", {username: this.username}).then(r => {
                        this.response.data = r.data;
                    });
                }, 500);
            }
        }
    }
</script>
@stop
<div class="auth-row justify-center">
    <div class="auth-col hidden">
        <a class="auth-logo" href="{{ url('/') }}"><img src="{{ logo('light') }}" alt=" "></a>
        <div class="banner-texts mt-32">
            <div class="banner-text-container">
                <h2 class="text-white mt-auto mb-10 text-5xl font-bold mb-3 w-v70">{{ __('Start Growing Today!') }}</h2>
                <p class="text-white mb-14 w-v80">{{ __('Start collecting money, feedbacks, emails, anonymous notes and more. Create and customize elements from tons of available apps on the platform and more to come!') }}</p>
                <p class="text-white mb-3">{{ __('Already a member?') }}</p>
                <a href="{{ route('user-login') }}" app-sandy-prevent="" class="text-sticker text-black">{{ __('Login') }}</a>
            </div>
        </div>
        <div class="auth-preview"><img alt="" src="{{ gs('assets/image/others', 'auth-main-bg.png') }}"></div>
    </div>
    <div class="auth-col">
        <div class="landing-form items-center flex-col">
            
            <div class="auth-go-back mb-10">
                <a href="{{ route('auth-index') }}" class="auth-go-back-a">
                    <i class="la la-arrow-left"></i>
                </a>
            </div>
            <div class="form-box login-register-form-element p-0 lg:p-10">
                <!-- /FORM BOX DECORATION -->
                <a class="auth-logo hidden mb-5 block" href="{{ url('/') }}"><img src="{{ logo('light') }}" alt=" "></a>
                <div class="mb-16">
                    <h2 class="form-box-title text-2xl mb-1 font-bold">{{ __('Create an account for free') }}</h2>
                    <span display="inline" class="text-sm text-gray-400">{{ __('Start today by creating an account to get started with our biolink solution') }}</span>
                </div>
                
                <div class="social-links is-auth justify-center">
                    @if (config('app.GOOGLE_ENABLE'))
                    <a class="social-link google" app-sandy-prevent="" href="{{ route('user-auth-google') }}">
                        <svg class="icon">
                            <use xlink:href="{{ gs('assets/image/svg','sprite.svg#icon-google-icon') }}"></use>
                        </svg>
                    </a>
                    @endif
                    @if (config('app.FACEBOOK_ENABLE'))
                    <a class="social-link facebook" app-sandy-prevent="" href="{{ route('user-auth-facebook') }}">
                        <i class="sni sni-facebook-f"></i>
                    </a>
                    @endif
                </div>
                @if (config('app.GOOGLE_ENABLE') || config('app.FACEBOOK_ENABLE'))
                <p class="lined-text my-10 font-normal">{{ __('or') }}</p>
                @endif
                
                <!-- FORM -->
                <form class="form" method="post" action="{{ route('user-register-post') }}">
                    @csrf
                    <div class="mb-10 relative z-10">
                        <div class="big-input-sider card card_widget" x-data="username_checker()">
                            <div class="flex">
                                
                                <b >{{ bio_prefix() }}</b>


                                <input type="text" name="username" value="{{ old('username') }}" placeholder="{{ __('username') }}" x-model="username" x-on:keyup="username_checker_send()" autofocus>
                            </div>
                            <div class="user-name-invalid text-xs" x-html="response.data"></div>
                        </div>
                    </div>
                    
                    <div class="form-input mb-5">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-input mb-5">
                        <label for="email">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ !empty(old('email')) ? old('email') : request()->get('email') }}" required autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="md:grid md:grid-cols-2 gap-4">
                        <div class="form-input mb-5 is-password md:mb-0 show-hide-password" x-data="password_checker()">
                            <label for="password">{{ __('Password') }}</label>

                            <div>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" x-model="password" required autocomplete="new-password" x-on:keyup="password_checker_send()">


                                <div class="show-password">
                                    <i class="sni sni-eye"></i>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="user-password-invalid text-xs" x-html="response.data"></div>
                        </div>
                        <div class="form-input">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <div>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                    
                    <div class="my-5 flex justify-center">
                        {!! \SandyCaptcha::html() !!}
                    </div>
                    
                    @if (settings('user.enable_registration'))
                    <!-- FORM ROW -->
                    <div class="form-row mt-5">
                        <!-- FORM ITEM -->
                        <div class="form-item">
                            <!-- BUTTON -->
                            <button class="button w-full">{{ __('Register now') }}</button>
                            <!-- /BUTTON -->
                        </div>
                        <!-- /FORM ITEM -->
                    </div>
                    <!-- /FORM ROW -->
                    @else
                    <div class="flex justify-center text-gray-400">
                        <h1>{{ __('Registration is disabled') }}</h1>
                    </div>
                    @endif
                    <div class="mt-10">
                        {!! terms_and_privacy(__('Register now')) !!}
                    </div>
                    <div class="flex justify-center mt-8 lg:hidden">
                        <div class="auth-text mr-3">{{ __('Already a member?') }}</div>
                        <a class="auth-link" href="{{ route('user-login') }}">
                            <svg class="icon icon-link">
                                <use xlink:href="{{ gs('assets/image/svg','sprite.svg#icon-link') }}"></use>
                            </svg>
                        {{ __('Login') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection