<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Seo:START -->

    @yield('seo')
    @if (!\View::hasSection('seo'))
        <title>{{ '@'.$bio->username }} | {{ config('app.name', 'Sandy :)') }}</title>
        <!-- Favicon -->
        <link href="{{ avatar(1) }}" rel="shortcut icon" type="image/png" />
    @endif
    <!-- Seo:END -->
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="{{ gs('assets/icons/flaticon/flaticon.min.css') }}" rel="stylesheet">
    <!-- App -->
    <link href="{{ gs('assets/css/app.css') . '?v=' . date('Y-m-d H:i:s') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ gs('assets/icons/icons.bundle.css') }}" rel="stylesheet">
    <!-- tailwind -->
    <link href="{{ gs('assets/css/tailwind.min.css') }}" rel="stylesheet">
    <!-- Sandy.Bundles -->
    <link href="{{ gs('assets/css/sandy.bundles.css?v=3') }}" rel="stylesheet">
    {!! $sandy->header_functions() !!}
    @yield('head')
    @includeIf('bio::integrations.header')

    @livewireStyles

    
    {!! user_pwa($bio->id) !!}
</head>
<body class="bio-body scroll-behavior {{ $sandy->body_classes() }}" app-sandy="wrapper" {!! barba_prevent() !!}>
    <div id="app-sandy-mix" class="is-bio w-700 max-w-full m-auto">
        <div app-sandy="container" app-sandy-namespace="@yield('namespace')">
            <div class="pb-0">
                <!-- Bio BACKGROUND:START -->
                {!! $sandy->bio_body_bg() !!}
                <!-- Bio BACKGROUND:END -->


                @hasSection('is_element')
                    <div class="auth-go-back mt-10 mx-0">
                        <a href="{{ \Bio::route($bio->id, 'user-bio-home') }}" app-sandy-prevent="" class="auth-go-back-a inline-flex items-center justify-center">
                            <i class="la la-arrow-left font-20"></i>
                        </a>
                    </div>
                @endif
                
                @yield('content')
                <!-- Bio Branding:START -->
                @if (bio_branding_display($bio->id))
                    @hasSection('is_element')
                        <div class="mt-20"></div>
                    @endif
                    <div class="bio-branding-mobile-wrapper mt-0 mb-10 yetti-account-open">
                        <div class="bio-branding-mobile">
                            <a href="{{ url(config('app.url')) }}" target="_blank">
                                <span>{{ __('Created With :name', ['name' => config('app.name')]) }}</span>
                            </a>
                        </div>
                    </div>
                @endif
                <!-- Bio Branding:END -->
            </div>
            
            {{-- \BioStyle::get_bottom_bar($bio->id) --}}
        </div>
        
        <label class="bio-dark">
            <input type="checkbox" name="toggle-switch" data-route="{{ \Bio::route($bio->id, 'user-bio-dark-mode') }}">
            {!! svg_i('moon-waning-1', 'night w-5 h-5') !!}
            {!! svg_i('sunrise-1', 'light hide w-5 h-5') !!}
        </label>
    </div>
    <!-- Login Modal:START -->
    @guest
    <div data-popup=".login-modal" class="rounded-3xl small">
        <div class="login-modal-wrapper p-0">
            @include('auth.include.login', ['extra' => ['redirect' => url()->current()]])
        </div>
    </div>
    @endguest
    <div data-popup=".yetti-account" class="half-short sandy-dialog p-0 border-0">
        <div style="
            background: url(&quot;https://assets.production.linktr.ee/profiles/_next/static/images/signup-banner-4f6a179612843b63eece35332rr61aa931.jpg&quot;), linear-gradient(-40deg, transparent 0%, rgba(0, 0, 0, 0.2) 100%);
            background-size: cover;
            background-position: center center;
            width: 100%;
            flex-basis: 80px;
            height: 100px;
            border-radius: inherit;
        "></div>
        <div class="login-modal-wrapper pt-5 md:p-20">
            <div class="text-left">
                <div class="mb-5">
                    <div class="text-xl font-bold mb-2 mt-5">{{ __('Get Started') }}</div>
                    <div class="mb-7 text-sm text-gray-600">{{ __('Get started with one of the most advance link in bio solution.') }}</div>
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
                    <a class="auth-link cursor-pointer login-modal-open">
                        <svg class="icon icon-link">
                            <use xlink:href="{{ gs('assets/image/svg','sprite.svg#icon-link') }}"></use>
                        </svg>
                    {{ __('Login') }}</a>
                </div>
            </div>
        </div>
        
    </div>
    <!-- Login Modal:END -->
    @if (bio_branding_display($bio->id))
        
        <div class="bio-claim-page yetti-account-open hidden">

            <div class="absolute top-5 right-10">
                <div class="p-5 rounded-full bg-white">
                    {!! orion('close-1', 'w-5 h-5') !!}
                </div>
            </div>
            <div class="bio-claim-input-div bg-gray-200 rounded-xl">
                <button type="button" class="bio-claim-input-div-button">
                <div class="flex items-center justify-center w-full h-full">
                    <div>
                        <p class="text-claim-text is-site">{{ parse(config('app.url'), 'host') }}/</p>
                    </div>
                    <p class="text-claim-text">@username</p>
                </div>
                </button>
            </div>
            <div class="bio-claim-page-description flex items-center justify-center">
                <p class="text-xs">{{ __('Build awesome pages with :app_name 😍', ['app_name' => config('app.name')]) }}</p>
            </div>
        </div>
    @endif
    
    <!-- Social Modal:START -->
    <div data-popup=".social-modal" class="small bio-social-modal">
        <div class="connect-img">
            <img src="{{ avatar($bio->id) }}" alt="{{ user('name', $bio->id) }}" class="user-avatar">
        </div>
        <div class="connect-header">
            <h2 class="connect-title">{{ __('Connect') }}</h2>
            <p class="connect-subtitle">{{ __('You can also reach out to me through any of my social profiles') }}</p>
        </div>
        <div class="connect-social">
            @foreach (\App\User::ordered_social($bio->id) as $key => $items)
            @if (!empty(user("social.$key", $bio->id)))
            <a href="{{ user('social.'.$key, $bio->id) ?? '' }}">
                <h3>{{ ao($items, 'name') }}</h3>
                <i class="{{ ao($items, 'icon') }}"></i>
                {{ ao($items, 'svg') }}
            </a>
            @endif
            @endforeach
        </div>
        <button type="button" class="social-modal-close hidden" data-close-popup><i class="flaticon-close"></i></button>
    </div>
    <!-- Social Modal:END -->


    <div id="sandy-embed-dialog" class="sandy-embed-dialog-container" style="z-index:2147000001" aria-modal="true" role="dialog" aria-hidden="true"><div class="sandy-embed-dialog-overlay" data-a11y-dialog-hide=""></div><div role="document" class="sandy-embed-dialog-content-wrapper"><a href="" target="_blank" class="sandy-embed-dialog-source sandy-embed-dialog-btn sandy-embed-dialog-btn-white" data-orii-ignore></a><button class="sandy-embed-dialog-close" type="button" data-a11y-dialog-hide="" aria-label="Close this dialog window"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke-linecap="round" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M19.953 4.045c4.393 4.393 4.393 11.517 0 15.91-4.393 4.393-11.517 4.393-15.91 0-4.393-4.393-4.393-11.517 0-15.91 4.393-4.393 11.517-4.393 15.91 0M7.5 16.5l9-9M16.5 16.5l-9-9"></path></g></svg></button><div class="sandy-embed-dialog-content"></div></div></div>

    <div class="bio-bottom">
        @includeIf('bio::integrations.index')
    </div>
    

    @if (\App\Bio::can_install_pwa($bio->id))
    <div class="bio-installation-bar-wrapper" data-id="{{ $bio->id }}">
        
        <div class="notification-bar is-install-app is-android hide">
            <div class="add-pwa">
                <i class="la la-plus"></i>
            </div>
            <div class="notification-text font-bold text-xs">{{ __("Tap options and select \"Install App\" to install :username on your homescreen.", ['username' => $bio->username]) }}</div>
            <div class="noti-close-btn right-0" tabindex="0">
                <i class="sni sni-cross"></i>
            </div>
        </div>


        <div class="notification-bar is-install-app is-ios hide">
            <div class="add-pwa">
                <i class="la la-plus"></i>
            </div>
            <div class="notification-text font-bold text-xs">{!! __("Install :username to your homescreen by tapping the share icon and Add to homescreen.", ['username' => $bio->username]) !!}</div>
            <div class="noti-close-btn right-0" tabindex="0">
                <i class="sni sni-cross"></i>
            </div>
        </div>
    </div>
    @endif



    {{-- Livewire Scripts --}}
    @livewireScripts
    <script src="{{ gs('assets/js/livewire-sortable.js') }}"></script>
    @includeIf('bio::include.toast')


    
    {!! \App\Bio::push_notification_script($bio->id) !!}
    @include('include.mix-tag.mix-footer-tag')
</body>
</html>