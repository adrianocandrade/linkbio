<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('include.mix-tag.mix-head-tag')
    </head>
    <body id="app-sandy" app-sandy="wrapper">
        <div app-sandy="container" app-sandy-namespace="@yield('namespace')">
            <div class="p-1 text-xs flex items-center justify-center bg-yellow-200 hidden">{{ __('BETA') }}</div>
            @yield('content')
        </div>

        
        @include('include.toast')
        @include('include.mix-tag.mix-footer-tag')
    </body>
</html>