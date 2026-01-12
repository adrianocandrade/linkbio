@extends('index::layouts.master')
@section('title', __('Discover'))
@section('content')

<div class="yetti-hero pb-20 -mt-32 pt-24" bg-style="#f6f6f6">
            
    <div class="hero-copy">
        <h1 class="hero-h1 text-3xl md:text-5xl">{{ __('Monetize And Build Your Storefront') }}</h1>
        <div class="hero-text">{{ __('Our tool helps creators monetize and build their storefronts, booking, courses on their social media.') }}</div>
    </div>
    <div class="hero-button">
        <a href="{{ route('user-register') }}" class="cta w-button">{{ __('Get Started') }}</a>
    </div>

    <div class="text-center">
        <a href="{{ url('/') }}" class="auth-link">{{ __('Learn More >') }}</a>
    </div>
</div>


<div class="sandy-container mt-10">
    
    <div class="grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 grid gap-4">
        
        @foreach ($pages as $items)
        <div class="creator-card">
            <a href="{{ bio_url(ao($items, 'slug')) }}" target="_blank">
                <div class="creator-card-overlay"></div>
                <div class="creator-card-thumb">
                    <span></span>
                    {!! getBioBackground(ao($items, 'user')) !!}
                </div>

                <div class="creator-card-info p-5 absolute bottom-0 z-50">
                    <div class="h-avatar md is-video remove-before remove-after">
                       <img src="{{ avatar(ao($items, 'user')) }}" class="h-full w-full" alt="">
                    </div>

                    <div class="flex flex-col">
                        <div class="text-lg text-white truncate">{{ user('name', ao($items, 'user')) }}</div>
                        <div class="text-sm text-white truncate">{{ '@'. user('username', ao($items, 'user')) }}</div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<!--- Section Signup CTA:START -->
<section class="pricing-signup-cta is-dark grid md:grid-cols-2 gap-4 mt-24 hidden">
    <div class="content">
        <h2>{{ __t('Start Engaging With Your Audience!') }}</h2>
        <p>{{ __t('Start collecting money, feedbacks, emails, anonymous notes and more.') }}</p>
    </div>
    <div class="form md:justify-end flex">
        
        <a href="#" class="register-modal-open sandy-btn">
            <span class="background"></span>
            <span class="hover"></span>
            <span class="text">{{ __t('START CREATING') }}</span>
        </a>
    </div>
</section>
<!--- Section Signup CTA:END -->
<div data-iframe-modal="" class="sandy-bio-element-dialog">
    <div class="iframe-header">
        <div class="icon iframe-trigger-close">
            <i class="flaticon2-cross"></i>
        </div>
        <a class="out" href="#" target="_blank" data-open-popup>
            <i class="la la-external-link-alt"></i>
        </a>
    </div>
    <div class="sandy-dialog-body"></div>
</div>
@endsection