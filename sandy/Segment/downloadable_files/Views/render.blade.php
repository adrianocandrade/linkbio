@extends('bio::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
@stop
@section('is_element', true)
<div class="context bio h-screen p-0 {!! radius_and_align_class($bio->id, 'align') !!} is-element flex flex-col">
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
                    {{ $bio->name }}
                    {!! user_verified($bio->id) !!}
                </div>
                <div class="bio-username-text theme-text-color">
                    {{ '@' . $bio->username }}
                </div>
            </div>
        </div>
    </div>
    <div class="element-context-body mt-auto pb-0 relative">
        <div class="bio-background">
            {!! videoOrImage(media_or_url($element->thumbnail, 'media/element/thumbnail')) !!}
        </div>
        <div class="message">
            <div class="text-sticker is-file-counter">{{ is_array(ao($element->content, 'downloadables')) ? count(ao($element->content, 'downloadables')) : '0' }} {{ __('File(s)') }}</div>
            <div class="title-container mb-5">
                <h1 class="title text-xl font-bold mb-5">{{ $element->name }}</h1>
                <h1 class="title">{{ ao($element->content, 'description') }}</h1>
            </div>
            @if (ao($element->content, 'price.type'))
            <button class="button sandy-quality-button mt-0 is-loader-submit loader-white relative purchase-open">{!! __('Purchase for :price', ['price' => Currency::symbol(ao($bio->payments, 'currency')) . ao($element->content, 'price.price')]) !!}</button>
            @else
            <form method="post" class="w-full" action="{{ route('sandy-app-downloadable_files-purchase', $element->slug) }}">
                @csrf
                <div class="form-input mb-5">
                    <label>{{ __('Email') }}</label>
                    <input type="text" class="bg-white" name="email">
                </div>
                <div class="form-input is-link mb-5 always-active active">
                    <label>{{ __('Amount') }}</label>
                    <div class="is-link-inner">
                        <div class="side-info">
                            <p>{!! Currency::symbol(ao($bio->payments, 'currency')) !!}</p>
                        </div>
                        <input type="text" class="bg-white" name="amount" placeholder="{{ ao($element->content, 'price.suggest_price') }}">
                    </div>
                </div>
                <button class="button sandy-quality-button mt-0 is-loader-submit loader-white relative">{!! __('Purchase') !!}</button>
            </form>
            @endif
        </div>
    </div>
</div>
<div data-popup=".purchase">
    <form method="post" action="{{ route('sandy-app-downloadable_files-purchase', $element->slug) }}">
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