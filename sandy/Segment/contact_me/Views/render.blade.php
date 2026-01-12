@extends('bio::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
{!! \SandyCaptcha::head() !!}
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
        <div class="message">
            <div class="title-container mb-5">
                <h1 class="title text-xl font-bold mb-1">{{ $element->name }}</h1>
                <h1 class="title">{{ ao($element->content, 'description') }}</h1>
            </div>
            @if (ao($element->content, 'price.type'))
            <button class="button sandy-quality-button mt-0 is-loader-submit loader-white relative purchase-open">{!! __('Purchase for :price', ['price' => Currency::symbol(ao($bio->payments, 'currency')) . ao($element->content, 'price.price')]) !!}</button>
            @else
            <form method="post" class="w-full" action="{{ route('sandy-app-contact_me-send-message', $element->slug) }}">
                @csrf
                <div class="form-input mb-5">
                    <label>{{ __('Your Email') }}</label>
                    <input type="text" class="bg-w" name="email">
                </div>
                <div class="form-input mb-5">
                    <label>{{ __('Subject') }}</label>
                    <input type="text" class="bg-w" name="subject">
                </div>
                <div class="form-input mb-5">
                    <label>{{ __('Message') }}</label>
                    <textarea name="message" class="bg-w" cols="30" rows="10"></textarea>
                </div>

                <div class="my-5 flex justify-center">
                    {!! \SandyCaptcha::html() !!}
                </div>

                <button class="button sandy-quality-button mt-0 is-loader-submit loader-white relative">{!! __('Send Message') !!}</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection