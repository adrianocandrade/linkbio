@extends('index::layouts.master')
@section('title', $page->name)
@section('namespace', 'index-page-single')
@section('content')
<!-- Section Article:START -->
<div class="blog-article center mx-auto">
    <!-- Section Banner:START -->
    <div class="banner-title-inner">
      <h1>
        {{ $page->name }}
      </h1>

      @if (mediaExists('media/site/page', $page->thumbnail))
      <div class="blog-banner">
          <img src="{{ getStorage('media/site/page', $page->thumbnail) }}" alt="">
      </div>
      @endif
    </div>
    <!-- Section Banner:END -->

    <!-- Section Content:START -->
    <div class="blog-content mt-10 tiny-content-init">
        {!! clean($page->description, 'titles') !!}
    </div>
    <!-- Section Content:END -->
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
                $thislocation = $item->type == 'internal' ? route('index-page-single', $item->location) : $item->location;
                $thistarget = $item->type == 'internal' ? '_self' : '_blank';
            @endphp


            <div class="avatar-blog bg-snow" data-sal="slide-up" data-sal-duration="600" data-sal-delay="5">
                @if (mediaExists('media/site/page', $page->thumbnail))
                <a class="blog-cover" href="{{ $thislocation }}" target="{{ $thistarget }}">
                    <img src="{{ getStorage('media/site/page', $item->thumbnail) }}" alt=" ">
                </a>
                @endif
                <div class="blog-body mt-5">
                    <a href="{{ $thislocation }}" target="{{ $thistarget }}" class="blog-link">
                      <h4 class="blog-title">
                        {{ $item->name }}
                      </h4>
                    </a>
                  </div>
            </div>
            @endforeach
        </div>
    </section>
<!-- Section blog trending:END -->
@endsection
