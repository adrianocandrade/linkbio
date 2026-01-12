<!DOCTYPE html>
<html lang="en">
    <head>
        @include('include.mix-tag.mix-head-tag')
    </head>
    <body id="app-sandy-docs" app-sandy="wrapper" class="js-header js-header-remove" {!! barba_prevent() !!}>
        <header class="index-header js-header sticky">
            <div class="index-header-center center">
                <a class="index-header-logo" href="{{ url('/') }}">
                    {{ __('Docs') }}
                </a>
                <a href="{{ route('user-support-my-requests') }}" class="text-sticker ml-auto mt-0 mr-4">{{ __('Support') }}</a>
                <button class="index-header-burger js-header-burger docs-sidebar-button"></button>
            </div>
        </header>
        <div class="docs-nav js-header-wrapper" data-simplebar>
            <div class="brand-top m-0">
                <a href="{{ url('/') }}">
                    <span>{{ __('Docs') }}</span>
                </a>
            </div>
            <div class="docs-navbar flex flex-col h-full">
                <a class="nav-link text-sm" href="{{ route('docs-index') }}">
                    <i class="sio maps-and-navigation-049-home i-2"></i>
                    {{ __('Getting Started') }}
                </a>
                @if (Plugins::has('api') && Route::has('sandy-plugins-api-docs-api'))
                <a class="nav-link text-sm" app-sandy-prevent href="{{ route('sandy-plugins-api-docs-api') }}">
                    <i class="sio design-and-development-088-web-development i-2"></i>
                    {{ __('Api Docs') }}
                </a>
                @endif
                <p class="mt-4 mb-2 font-bold text-sm">{{ __('Guides') }}</p>
                @foreach (\App\Models\DocsCategory::get() as $item)
                <a class="nav-link text-sm" href="{{ route('docs-guides', $item->id) }}">
                    {{ $item->name }}
                </a>
                @endforeach
                <div class="card card_widget has-cta-bg-shade mb-5 mt-auto ">
                    <div class="flex justify-center mx-auto z-10 relative h-avatar is-video bg-white card-shadow rounded-xl">
                        <i class="sio shopping-icon-099-support text-5xl text-black sligh-thick"></i>
                    </div>
                    <p class="text-center text-sm mt-5 font-bold block z-10 relative">{{ __('Talk to our active support team!') }}</p>
                    <a class="button w-full mt-5 z-10 relative" href="{{ route('user-support-my-requests') }}">{{ __('My Requests') }}</a>
                </div>
            </div>
        </div>
        <div class="content is-small" app-sandy="container" app-sandy-namespace="@yield('namespace')">
            @yield('content')
            @include('include.index.footer')
        </div>
        @include('include.mix-tag.mix-footer-tag')
    </body>
</html>