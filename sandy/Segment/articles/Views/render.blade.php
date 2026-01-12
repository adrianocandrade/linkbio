@extends('bio::layouts.master')
@section('index-bio', true)
@section('seo')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
@stop
@section('is_element', true)
<div class="context bio p-3 {!! radius_and_align_class($bio->id, 'align') !!} is-element">
    <div class="context-head pt-10">
        <div class="avatar-thumb relative z-10 mb-5">
            <div class="avatar-container">
                <a href="/<?= e(config('app.bio_prefix')) ?><?= $bio->username ?>">
                    <div class="thumb" style="background: {{ao($bio->settings, 'avatar_color')}}">
                        {!! avatar($bio->id, true) !!}
                    </div>
                </a>
            </div>
            <div class="bio-info-container">
                <div class="bio-name-text theme-text-color flex">
                    {{ $bio->name }} - {{ __('Article') }}
                    {!! user_verified($bio->id) !!}
                </div>
                <div class="bio-username-text theme-text-color">
                    {{ '@' . $bio->username }}
                </div>
            </div>
        </div>
    </div>
    <div class="context-body mt-5 pb-0 relative">
        <div class="message">
            <div class="p-5 mb-5">
                <h1 class="text-2xl mb-5">{{ $element->name }}</h1>
                <div class="title-info">{{ \Carbon\Carbon::parse($element->created_at)->toFormattedDateString() }} | {{ ao($element->content, 'ttr') }}</div>
                @if (ao($element->content, 'paywall.enable') == 'enable')
                <div class="tiny-content-init">

                    {!! ao($paywall_content, 'content') !!}
                    @if (!ao($paywall_content, 'is_unlocked'))
                    <div class="flex relative z-50 mt-10">

                        <div class="paywall-card text-center mx-0 step-banner bg-dark">
                            <h1 class="text-base">{{ __('Unlock to view the rest of this content.') }}</h1>
                            <button class="button white-solid mt-5 purchase-open px-10">{{ __('Unlock') }} {!! Currency::symbol(ao($bio->payments, 'currency')) . ao($element->content, 'paywall.price') !!}</button>
                        </div>
                    </div>
                    @endif
                </div>
                @else
                {!! clean(ao($element->content, 'description'), 'titles') !!}
                @endif
            </div>
        </div>
    </div>
</div>
<div data-popup=".purchase">
    <form method="post" action="{{ route('sandy-app-articles-purchase', $element->slug) }}">
        @csrf
        <div class="text-center">
            <div>
                <div class="text-2xl font-bold mb-5 mt-5">{{ __('Before you continue') }}</div>
                <div class="mb-7 text-sm text-gray-600">{{ __('We would need your email for us to process your payment.') }}</div>
            </div>
            <div class="form-input">
                <label>{{ __('Email') }}</label>
                <input type="text" name="email">
            </div>
            <button class="button mt-5 w-full">{{ __('continue') }}</button>
        </div>
    </form>
</div>
@endsection