@extends('docs::layouts.master')
@section('title', $guide->name)
@section('namespace', 'docs-guide')
@section('content')
<!-- Section Article:START -->
<div class="blog-article center mx-auto md:px-14 px-0 mb-20">
    <!-- Section Banner:START -->
    <div class="banner-title-inner">
      <h1>
        {{ $guide->name }}
      </h1>

      <span class="ttr">{{ ao($guide->content, 'subdes') }}</span>

      @if (mediaExists('media/site/docs/guide', ao($guide->media, 'banner')))
      <div class="blog-banner">
          <img src="{{ gs('media/site/docs/guide', ao($guide->media, 'banner')) }}" alt="">
      </div>
      @endif
    </div>
    <!-- Section Banner:END -->

    <!-- Section Content:START -->
    <div class="blog-content mt-10 tiny-content-init">
        {!! clean($content, 'titles') !!}
    </div>
    <!-- Section Content:END -->


    <!-- Section SHARE:START -->
    <div class="article-share center px-0 md:px-14">
          <h5 class="mb-5">{{ __('Share') }}</h5>
          <svg width="36px" height="15px" viewBox="0 0 36 8" class="transform rotate-90 ">
            <g id="misc" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round"><path d="M34,4 C32.2311949,6.66666667 29.3686392,6.66666667 27.5998342,4 C25.8311949,1.33333333 22.9688051,1.33333333 21.2,4 C19.4311949,6.66666667 16.5686392,6.66666667 14.8,4 C13.0311949,1.33333333 10.1686392,1.33333333 8.4,4 C6.63119494,6.66666667 3.76880506,6.66666667 2,4" id="icon/decoration" stroke-width="2"></path></g>
          </svg>

          <div class="share-buttons">
              <a class="text-sticker" href="{{ share_to_media('facebook', $guide->name, route('docs-guide', $guide->slug)) }}">{{ __('Facebook') }}</a>
              <a class="text-sticker" href="{{ share_to_media('twitter', $guide->name, route('docs-guide', $guide->slug)) }}">{{ __('Twitter') }}</a>
              <a class="text-sticker" href="{{ share_to_media('whatsapp', $guide->name, route('docs-guide', $guide->slug)) }}">{{ __('Whatsapp') }}</a>
              <a class="text-sticker" data-copy="{{ route('docs-guide', $guide->slug) }}" data-after-copy="{{ __('Copied') }}" class="cursor-pointer">{{ __('Copy Link') }}</a>
          </div>
    </div>
    <!-- Section SHARE:END -->
</div>
<!-- Section Article:END -->
@endsection
