@extends('index::layouts.master')
@section('title', __('Pricing'))
@section('content')


<div class="pricing-plan-page-wrapper mx-auto">
    
    <div class="yetti-hero pb-20 -mt-32 pt-24 px-0">
                
        <div class="hero-copy">
            <h1 class="hero-h1 text-3xl md:text-5xl">{{ __('Choose what that works best for you.') }}</h1>
            <div class="hero-text">{{ __('You can switch your plan anytime.') }}</div>
        </div>
    </div>

        
    <div class="center">
        <div class="change-pricing-selector">
            <a href="#" class="active" data-price-change=".monthly">{{ __('Monthly') }}</a>
            <a href="#" data-price-change=".annually">{{ __('Annual') }}</a>
        </div>
        <div class="pricing-page-grid">
            @foreach ($plans as $plan)
            <div class="pricing-table-card has-cta-bg-shade {{ ao($plan->extra, 'featured') ? 'active' : '' }}">
                <div class="pricing-table-header z-10E relative">
                    <div class="pricing-title">
                        <h5>{{ $plan->name }}</h5>
                        <p>{{ ao($plan->extra, 'description') }}</p>
                    </div>
                    <div class="pricing-price-content">
                        <div class="number">
                            @switch($plan->price_type)
                            @case('free')
                            <p class="price">{{ __('Free') }}</p>
                            @break
                            @case('paid')
                            <p class="price monthly" data-price-selector>{!! price_with_cur(\Currency::symbol(settings('payment.currency')), ao($plan->price, 'monthly')) !!}</p>
                            <p class="annually price hide" data-price-selector>{!! price_with_cur(\Currency::symbol(settings('payment.currency')), ao($plan->price, 'annually')) !!}</p>
                            @break
                            @case('trial')
                            <p class="price">{{ __(':trial Days.', ['trial' => ao($plan->price, 'trial_duration')]) }}</p>
                            @break
                            @endswitch
                            
                            @if ($plan->price_type == 'paid')
                            <span class="duration monthly" data-price-selector>/ {{ __('mo') }}</span>
                            <span class="duration annually hide" data-price-selector>/ {{ __('yr') }}</span>
                            @endif
                        </div>
                        @switch($plan->price_type)
                        @case('free')
                        <p class="des">{{ __('Free Forever') }}</p>
                        @break
                        @case('paid')
                        <p class="des">{{ __('Pay once monthly or annually') }}</p>
                        @break
                        @case('trial')
                        <p class="des">{{ __('Enjoy a free :trial day pro trial plan.', ['trial' => ao($plan->price, 'trial_duration')]) }}</p>
                        @break
                        @endswitch
                    </div>
                </div>
                
                @auth
                <a href="{{ route('user-mix-purchase-plan', $plan->id) }}" class="pricing-btn prevent">{{ __('Select') }}</a>
                @else
                <a href="{{ route('user-register') }}" class="pricing-btn">{{ __('Sign Up') }}</a>
                @endauth
                <ul class="pricing-list">
                    @foreach ($skeleton() as $key => $value)
                    <li>
                        @if (ao($plan->settings, $key))
                        <i class="flaticon2-checkmark icon mr-4"></i>
                        @else
                        <i class="flaticon2-cross icon mr-4"></i>
                        @endif
                        <span>{{ $skeleton("$key.name") }}</span>
                    </li>
                    @endforeach
                    <hr class="my-7">
                    @foreach (['blocks_limit' => 'Blocks Creation', 'pixel_limit' => 'Pixel Creation'] as $key => $value)
                    <li>
                        <span class="text-sticker mt-0 mr-4">{{ ao($plan->settings, $key) }}</span>
                        <span>{{ __($value) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="relative">
    <div class="div-block-10"></div>
</div>

<!--- Section Hero:END -->
<div class="pricing-table-v2 hidden">
    <div class="pricing__center center">
        <div class="pricing__list grid md:grid-cols-3">
            @foreach ($plans as $plan)
            <div class="pricing__item {{ ao($plan->extra, 'featured') ? 'active' : '' }}">
                <div class="pricing__head">
                    @if (ao($plan->extra, 'featured'))
                    
                    <div class="pricing__note">{{ __('Featured') }}</div>
                    @endif
                    <div class="pricing__subtitle">{{ $plan->name }}</div>
                    <div class="pricing__price">
                        @switch($plan->price_type)
                        @case('free')
                        <p class="price pricing__number">{{ __('Free') }}</p>
                        @break
                        @case('paid')
                        <span class="pricing__currency">{!! \Currency::symbol(settings('payment.currency')) !!}</span>
                        <p class="price monthly pricing__number" data-price-selector>{!! ao($plan->price, 'monthly') !!}</p>
                        <p class="annually price hide pricing__number" data-price-selector>{!! ao($plan->price, 'annually') !!}</p>
                        @break
                        @case('trial')
                        <p class="price pricing__number">{{ __(':trial Days.', ['trial' => ao($plan->price, 'trial_duration')]) }}</p>
                        @break
                        @endswitch
                        @if ($plan->price_type == 'paid')
                        <span class="pricing__time duration monthly" data-price-selector>/ {{ __('mo') }}</span>
                        <span class="pricing__time duration annually hide" data-price-selector>/ {{ __('yr') }}</span>
                        @endif
                    </div>
                    <div class="pricing__text">{{ ao($plan->extra, 'description') }}</div>
                    @auth
                    <a href="{{ route('user-mix-purchase-plan', $plan->id) }}" class="button outline-dark prevent">{{ __('Select') }}</a>
                    @else
                    <a href="{{ route('user-register') }}" class="button outline-dark">{{ __('Sign Up') }}</a>
                    @endauth
                </div>
                <div class="pricing__details">
                    @if ($loop->first)
                    <div class="pricing__stage">{{ __('Core features') }}</div>
                    @endif
                    <div class="pricing__category">{{ $plan->name }}</div>
                    <a class="pricing__view" href="#">{{ __('See features') }}</a>
                    <ul class="pricing__options">
                        
                        @foreach ($skeleton() as $key => $value)
                        <li>
                            <span>{{ ao($value, "name") }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="pricing-signup-cta grid md:grid-cols-2 gap-4 has-cta-bg-shade hidden">
    <div class="cta-background-shade opacity-100">
        <img src="{{ gs('assets/image/others/index-cta-bg-02.png') }}" alt="">
    </div>
    <div class="content">
        <h2>{{ __('Start Engaging With Your Audience!') }}</h2>
        <p>{{ __t('Start collecting money, feedbacks, emails, anonymous notes and more.') }}</p>
    </div>
    <div class="form">
        <form action="{{ route('user-register') }}" method="get" class="index-form-register">
            <label>
                <input name="email" type="email">
                <span>{{ __('Enter your email ...') }}</span>
            </label>
            <button class="sandy-btn">
            <span class="background"></span>
            <span class="hover"></span>
            <span class="text">{{ __('Register') }}</span>
            </button>
        </form>
    </div>
</div>
@endsection