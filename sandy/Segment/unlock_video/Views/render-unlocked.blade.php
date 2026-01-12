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
    <div class="element-context-body p-5 flex-col h-full">
        <div class="my-auto {{ ao($element->content, 'video.is_iframe') ? 'h-full' : '' }}">
            
            <div class="text-base mb-4 font-bold">{{ __('Here is your unlocked video') }}</div>
            <div class="element-video w-full {{ ao($element->content, 'video.is_iframe') ? 'h-full' : '' }}">
                <div class="element-single-video {{ ao($element->content, 'video.is_iframe') ? 'is-iframe h-full' : '' }}">
                    @if (!ao($element->content, 'video.is_iframe'))
                    <div class="element-single-video-container" href="<?= getEmbedableLink(ao($element->content, 'video.type'), ao($element->content, 'video.link')) ?>">
                        
                        <button class="play-button">
                        <i class="sni sni-play"></i>
                        </button>
                        <img src="<?= ao($element->content, 'video.thumbnail') ?>" alt="" class="banner">
                    </div>
                    @else
                    <iframe src="<?= getEmbedableLink(ao($element->content, 'video.type'), ao($element->content, 'video.link')) ?>" frameborder="0"></iframe>
                    @endif
                </div>
            </div>
            <div class="flex gap-4 mt-5">
                <a class="text-sticker rounded-xl ml-auto" href="{{ route('sandy-app-unlock_video-render', $element->slug) }}">{{ __('Go back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection