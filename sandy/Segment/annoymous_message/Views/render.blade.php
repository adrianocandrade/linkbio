@extends('bio::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
@stop
@section('is_element', true)
<div class="context bio h-screen p-5 {!! radius_and_align_class($bio->id, 'align') !!} is-element flex flex-col">
    <div class="bio-background">
        {!! videoOrImage(gs('media/element/thumbnail', ao($element->thumbnail, 'thumbnail'))) !!}
    </div>

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

    <div class="element-context-body mt-auto pb-5">
        <form class="message" method="post" action="{{ route('sandy-app-annoymous_message-send', $element->slug) }}">
            @csrf
            
            <div class="title-container mb-10">
                <h1 class="title">{{ ao($element->content, 'caption') }}</h1>
            </div>
            <div class="form-input w-full">
                <label>{{ __('Message') }}</label>
                <textarea name="text" cols="30" rows="10"></textarea>
            </div>
            <button class="button sandy-quality-button is-loader-submit loader-white">{{ __('Send Message') }}</button>
        </form>
    </div>
</div>
@endsection