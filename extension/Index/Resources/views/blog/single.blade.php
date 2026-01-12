@extends('index::layouts.master')
@section('title', $blog->name)
@section('namespace', 'index-blog-single')
@section('content')
<!-- Section Article:START -->
<div class="blog-article center mx-auto">
    <!-- Section Banner:START -->
    <div class="banner-title-inner">
        <span class="ttr">{{ $blog->ttr }}</span>
      <h1>
        {{ $blog->name }}
      </h1>

      @if (mediaExists('media/site/blog', $blog->thumbnail))
      <div class="blog-banner">
          <img src="{{ getStorage('media/site/blog', $blog->thumbnail) }}" alt="">
      </div>
      @endif
    </div>
    <!-- Section Banner:END -->

    <!-- Section Content:START -->
    <div class="blog-content mt-10 tiny-content-init">
        {!! clean($blog->description, 'titles') !!}
    </div>
    <!-- Section Content:END -->


    <!-- Section User:START -->
    <div class="article-user mt-24">
        <div class="person mb-0 media vertical">
          @if ($avatar = avatar($blog->postedBy ?? 'none'))
              <div class="h-avatar sm mr-3">
                  <img src="{{ $avatar }}" class="h-full" alt="">
              </div>
          @endif
          <div class="media-body">
                <div class="txt">
                  <h3>{{ $blog->author ?? user('name', $blog->postedBy ?? 'n') }}</h3>
                  <time>{{ \Carbon\Carbon::parse($blog->created_at)->toFormattedDateString() }}</time>
                </div>
          </div>
        </div>
    </div>
    <!-- Section User:END -->

    <!-- Section SHARE:START -->
    <div class="article-share center">
          <h5 class="mb-5">{{ __('Share') }}</h5>
          <svg width="36px" height="15px" viewBox="0 0 36 8" class="transform rotate-90 ">
            <g id="misc" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round"><path d="M34,4 C32.2311949,6.66666667 29.3686392,6.66666667 27.5998342,4 C25.8311949,1.33333333 22.9688051,1.33333333 21.2,4 C19.4311949,6.66666667 16.5686392,6.66666667 14.8,4 C13.0311949,1.33333333 10.1686392,1.33333333 8.4,4 C6.63119494,6.66666667 3.76880506,6.66666667 2,4" id="icon/decoration" stroke-width="2"></path></g>
          </svg>

          <div class="share-buttons">
              <a href="{{ share_to_media('facebook', $blog->name, route('index-blog-single', $blog->location)) }}">{{ __('Facebook') }}</a>
              <a href="{{ share_to_media('twitter', $blog->name, route('index-blog-single', $blog->location)) }}">{{ __('Twitter') }}</a>
              <a href="{{ share_to_media('whatsapp', $blog->name, route('index-blog-single', $blog->location)) }}">{{ __('Whatsapp') }}</a>
              <a data-copy="{{ route('index-blog-single', $blog->location) }}" data-after-copy="{{ __('Copied') }}" class="cursor-pointer">{{ __('Copy Link') }}</a>
          </div>
    </div>
    <!-- Section SHARE:END -->
</div>
<!-- Section Article:END -->


<!-- Section blog trending:START -->
    <section class="blog-trending center sm:mx-auto mt-16" {{ empty($most3Read) ? 'hidden' : '' }}>
        <div class="title-sections">
            <h2>{{ __('Most Read') }}</h2>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($most3Read as $item)

            @php
                $thislocation = $item->type == 'internal' ? route('index-blog-single', $item->location) : $item->location;
                $thistarget = $item->type == 'internal' ? '_self' : '_blank';
            @endphp


            <div class="avatar-blog bg-snow" data-sal="slide-up" data-sal-duration="600" data-sal-delay="5">
                <a class="blog-cover" href="{{ $thislocation }}" target="{{ $thistarget }}">
                    <img src="{{ getStorage('media/site/blog', $item->thumbnail) }}" alt=" ">
                </a>
                <div class="blog-body mt-5">
                    <a href="{{ $thislocation }}" target="{{ $thistarget }}" class="blog-link">
                        <span class="read-time">
                            {{ $item->ttr }} | {{ nr($item->total_views) }} {{ __('Views') }}
                        </span>
                      <h4 class="blog-title">
                        {{ $item->name }}
                      </h4>
                    </a>
                    <a>
                      <div class="person mb-0 media">
                        @if ($avatar = avatar($item->postedBy ?? 'none'))
                            <div class="h-avatar sm mr-3">
                                <img src="{{ $avatar }}" class="h-full" alt="">
                            </div>
                        @endif
                        <div class="media-body">
                          <div class="txt">
                            <h3>{{ $item->author ?? user('name', $item->postedBy ?? 'n') }}</h3>
                            <time>{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</time>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
            </div>
            @endforeach
        </div>
    </section>
<!-- Section blog trending:END -->
@endsection
