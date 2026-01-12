@extends('bio::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
@stop
@section('is_element', true)
<div class="context bio p-0 {!! radius_and_align_class($bio->id, 'align') !!} is-element flex flex-col">
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
    <div class="context-body my-auto pt-0 remove-before pb-0 relative">
        <div class="message">
            <div class="title-container mb-5">
                <h1 class="title text-xl font-bold mb-0">{{ $element->name }}</h1>
                <h1 class="title">{{ ao($element->content, 'description') }}</h1>
            </div>
            @if (ao($element->content, 'type') == 'carousel')
            
            <div class="bio-swiper-container">
                <div class="bio-swiper-wrapper">
                    <div class="bio-swiper-slide">
                        @if (is_array($images = ao($element->content, 'images')))
                        @foreach ($images as $key => $values)
                        <a class="swiper-item sandy-fancybox" data-fancybox="gallery" data-src="{{ gs('media/element/others', $values) }}" href="javascript:;">
                            <div class="is-card">
                                <img src="<?= gs('media/element/others', $values) ?>" alt=" " class="card-image">
                            </div>
                        </a>
                        @endforeach
                        @endif
                    </div>
                    <div class="bio-slider-arrows">
                        <div class="slide-left hidden">
                            <i class="sni sni-arrow-left"></i>
                        </div>
                        <div class="slide-right hidden">
                            <i class="sni sni-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (ao($element->content, 'type') == 'grid')
            <div class="multi-image-container">
                @if (is_array($images = ao($element->content, 'images')))
                    @foreach ($images as $key => $values)
                    <div class="inner-image-container">
                        <a class="inner-image sandy-fancybox" data-fancybox="gallery" data-src="{{ gs('media/element/others', $values) }}" href="javascript:;">
                            <div class="thumbnail">
                                <img src="{{ gs('media/element/others', $values) }}">
                            </div>
                            <span class="fancy-drop"></span>
                        </a>
                    </div>
                    @endforeach
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection