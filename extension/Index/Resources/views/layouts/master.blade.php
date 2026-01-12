<!DOCTYPE html>
<html lang="en">
   <head>
      @include('include.mix-tag.mix-head-tag')
   </head>
   <body id="app-sandy-index" app-sandy="wrapper" {!! barba_prevent() !!}>
      <header class="index-header js-header js-header-remove relative" data-id="#header">
         <div class="index-header-center center">
            <a class="index-header-logo md:m-0" href="{{ url('/') }}">
               <img class="some-icon" src="{{ logo('light') }}" alt="{{ config('app.name') }}">
            </a>
            <div class="index-header-wrapper js-header-wrapper">
               <nav class="index-header-nav md:mx-auto border-0">
                  <a class="index-header-link js-nav-link ml-0" href="{{ route('index-blog-all') }}">{{ __('Blog') }}</a>
                  <a class="index-header-link sandy-smooth-href js-nav-link hidden" href="{{ url('/#start-exploring') }}">{{ __('How it works') }}</a>
                  <a class="index-header-link js-nav-link" href="{{ route('pricing-index') }}">{{ __('Pricing') }}</a>
                  <a class="index-header-link js-nav-link" href="{{ route('index-accelerated-pages') }}">{{ __('Accelerated Page') }}</a>

                  @if (Route::has('discover-index'))
                     <a class="index-header-link js-nav-link" href="{{ route('discover-index') }}">{{ __('Discover') }}</a>
                  @endif
                  
                  @if (Route::has('docs-index'))
                     <a class="index-header-link js-nav-link" href="{{ route('docs-index') }}">{{ __('Docs') }}</a>
                  @endif
               </nav>
               @guest
               <a class="mr-4 font-bold mb-5 md:mb-0 register-modal-open" href="#">{{ __('Create an Account') }}</a>
               @endguest
            </div>
            <div class="dropdown trans-index-dropdown">
               <button class="dropdown__head shadow-none m-0 mr-3 text-lg">
               <i class="las la-language"></i>
               </button>
               <div class="dropdown__body">
                  <form action="{{ route('index-switch-lang') }}" method="POST">
                     @csrf
                     <div class="card-header mort-main-bg p-5 rounded-2xl mb-5">
                        <i class="sio network-icon-090-world-wide-web text-2xl"></i>
                        <p class="text-sm">{{ __('Languages') }}</p>
                     </div>
                     @foreach (all_locale() as $key => $item)
                     <label class="sandy-big-radio mb-3">
                        <input type="radio" name="locale" value="{{ ao(pathinfo($item), 'filename') }}" class="custom-control-input" {{ App::getLocale() == ao(pathinfo($item), 'filename') ? 'checked' : '' }}>
                        <div class="radio-select-inner locale">
                           
                           
                           <p class="text-title">{{ string_uppercase(ao(pathinfo($item), 'filename')) }}</p>
                        </div>
                     </label>
                     @endforeach
                  </form>
               </div>
            </div>
            <button class="index-header-burger js-header-burger mr-4"></button>
            @auth
            <div class="index-header-item index-header-item_user">
               <button class="index-header-head js-header-head">
               <div class="h-avatar md is-video" style="background: {{ao(user('settings'), 'avatar_color')}}">
                  <img src="{{ avatar() }}" class="h-full w-full" alt="">
               </div>
               </button>
               <div class="index-header-body js-header-body">
                  <div class="index-header-name">{{ user('name') }}</div>
                  <div class="index-header-code">
                     <a class="index-header-number text-xs" href="{{ bio_url(user('id')) }}" target="_blank">{{ bio_url(user('id'), 'short') }}</a>
                     <button class="index-header-copy copy-btn" data-copy="{{ bio_url(user('id')) }}" data-after-copy="{{ __('Copied') }}">
                     <i class="icon flaticon2-copy"></i>
                     </button>
                  </div>
                  <div class="index-header-wrap">
                     <div class="index-header-line">
                        <div class="index-header-img">
                           <img src="{{avatar()}}" alt="">
                        </div>
                        <div class="index-header-details">
                           <div class="index-header-info">{{ __('Plan') }}</div>
                           <div class="index-header-money">{{ plan('name') }}</div>
                        </div>
                     </div>
                     <a href="{{ route('pricing-index') }}" class="this-button text-sticker w-full flex justify-center">{{ __('Upgrade my Plan') }}</a>
                  </div>
                  <div class="index-header-menu">
                     

                                    @if (is_admin(user('id')))
                                    <a class="index-header-link prevent" app-sandy-prevent="" href="{{ route('admin-dashboard') }}">
                                        <div class="index-header-icon">
                                            {!! feather('shield', 'w-4 h-4') !!}
                                        </div>
                                        <div class="index-header-text">{{ __('Admin') }}</div>
                                    </a>
                                    @endif
                                    <a class="index-header-link" app-sandy-prevent="" href="{{ bio_url(user('id')) }}" target="_blank">
                                        <div class="index-header-icon">
                                            {!! feather('monitor', 'w-4 h-4') !!}
                                        </div>
                                        <div class="index-header-text">{{ __('View Bio') }}</div>
                                    </a>
                                    <a class="index-header-link sm:hidden" href="{{ route('pricing-index') }}">
                                        <div class="index-header-icon">
                                            {!! feather('list', 'w-4 h-4') !!}
                                        </div>
                                        <div class="index-header-text">{{ __('Pricing') }}</div>
                                    </a>
                                    <a class="index-header-link" href="{{ route('user-mix') }}">
                                        <div class="index-header-icon">
                                            {!! feather('file-text', 'w-4 h-4') !!}
                                        </div>
                                        <div class="index-header-text">{{ __('Dashboard') }}</div>
                                    </a>
                                    <a class="index-header-link" href="{{ route('user-mix-settings') }}">
                                        <div class="index-header-icon">
                                            {!! feather('settings', 'w-4 h-4') !!}
                                        </div>
                                        <div class="index-header-text">{{ __('Settings') }}</div>
                                    </a>
                                    <a class="index-header-link" href="{{ route('user-logout') }}" app-sandy-prevent>
                                        <div class="index-header-icon">
                                           {!! feather('log-out', 'w-4 h-4') !!}
                                        </div>
                                        <div class="index-header-text">{{ __('Logout') }}</div>
                                    </a>
                  </div>
               </div>
            </div>
            @endauth
            @guest
            <a href="{{ route('user-login') }}" app-sandy-prevent="" class="sandy-btn">
               <span class="background"></span>
               <span class="hover"></span>
               <span class="text">{{ __('Login') }}</span>
            </a>
            @endguest
         </div>
      </header>
      <div app-sandy="container" app-sandy-namespace="@yield('namespace')">
         @yield('content')
      </div>

      @include('include.index.footer')
      <div data-popup=".register-modal" class="rounded-3xl p-0">
         <div class="login-modal-wrapper">
            <div class="text-center">
               <div>
                  <div class="text-4xl font-bold mb-5 mt-5">{{ __('Get Started') }}</div>
                  <div class="mb-7 text-sm text-gray-600">{{ __('Start today by creating an account to get started with our biolink solution') }}</div>
               </div>
               <div class="social-links is-auth justify-center">
                  @if (config('app.GOOGLE_ENABLE'))
                  <a class="social-link google rounded-2xl" app-sandy-prevent="" href="{{ route('user-auth-google') }}">
                     <svg class="icon">
                        <use xlink:href="{{ gs('assets/image/svg','sprite.svg#icon-google-icon') }}"></use>
                     </svg>
                  </a>
                  @endif
                  @if (config('app.FACEBOOK_ENABLE'))
                  <a class="social-link facebook rounded-2xl" app-sandy-prevent="" href="{{ route('user-auth-facebook') }}">
                     <i class="sni sni-facebook-f"></i>
                  </a>
                  @endif
               </div>
               @if (config('app.GOOGLE_ENABLE') || config('app.FACEBOOK_ENABLE'))
               <p class="lined-text my-10 font-normal">{{ __('Or continue with email') }}</p>
               @endif
               <form method="GET" action="{{ route('user-register') }}" class="subscription-btn-wrapper">
                  <input class="subscription-input" type="email" name="email" placeholder="{{ __('Enter your email') }}" required="">
                  <button class="subscription-btn">
                  <i class="sni sni-arrow-right"></i>
                  </button>
               </form>
               
               <div class="flex justify-center mt-8">
                  <div class="auth-text mr-3">{{ __('Already a member?') }}</div>
                  <a class="auth-link" href="{{ route('user-login') }}">
                     <svg class="icon icon-link">
                        <use xlink:href="{{ gs('assets/image/svg','sprite.svg#icon-link') }}"></use>
                     </svg>
                  {{ __('Login') }}</a>
               </div>
            </div>
         </div>
         
         <button class="register-modal-close" data-close-popup><i class="flaticon-close"></i></button>
      </div>
      <div class="notification-bar is-cookie hide">
         <div class="notification-text">
             {{ __('We use cookies to give you the best experience.') }}
         </div>
         
         <div class="noti-close-btn" tabindex="0">
             <i class="sni sni-cross"></i>
         </div>
     </div>
     
      @include('include.mix-tag.mix-footer-tag')
   </body>
</html>