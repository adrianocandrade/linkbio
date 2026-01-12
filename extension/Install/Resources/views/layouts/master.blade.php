<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@hasSection('title') @yield('title') | @endif {{ config('app.name') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 

        @yield('fonts')

        <!-- Styles -->
        <link href="{{ gs('assets/icons/icons.bundle.css') }}" rel="stylesheet">
        <link href="{{ gs('assets/icons/flaticon/flaticon.min.css') }}" rel="stylesheet">
        <!-- Sandy.Bundles -->
        <link href="{{ gs('assets/css/sandy.bundles.css') }}" rel="stylesheet">
        <!-- tailwind -->
        <link href="{{ gs('assets/css/tailwind.min.css') }}" rel="stylesheet">
        <!-- App -->
        <link href="{{ gs('assets/css/app.css') }}" rel="stylesheet">
        @yield('head')
    </head>
    <body>
        
        <div class="installation-center-wrapper">
            <div class="installation-content">
                @yield('content')
            </div>
        </div>


        @include('include.mix-tag.mix-footer-tag')
    </body>
</html>
