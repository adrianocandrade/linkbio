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
    <div class="element-context-body pb-0">
        <div class="element-video w-full {{ ao($element->content, 'is_iframe') ? 'h-full' : '' }}">
            <div class="element-single-video {{ ao($element->content, 'is_iframe') ? 'is-iframe h-full' : '' }}">
                @if (!ao($element->content, 'is_iframe'))
                <div class="element-single-video-container" href="<?= getEmbedableLink(ao($element->content, 'type'), ao($element->content, 'link')) ?>">
                    
                    <button class="play-button">
                    <i class="sni sni-play"></i>
                    </button>
                    <img src="<?= ao($element->content, 'thumbnail') ?>" alt="" class="banner">
                </div>
                @else
                <iframe src="<?= getEmbedableLink(ao($element->content, 'type'), ao($element->content, 'link')) ?>" frameborder="0"></iframe>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection