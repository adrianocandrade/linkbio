@extends('index::layouts.master')
@section('title', __('Blog'))
@section('namespace', 'index-blog-all')
@section('content')
<div bg-style="#f6f6f6" class="yetti-hero pb-20 -mt-32 pt-24 mb-20">
            
  <div class="hero-copy">
      <h1 class="hero-h1 text-3xl md:text-5xl">{{ __('Latest News') }}</h1>
      <div class="hero-text">{{ __('We’ve created blog post’s that can help you get a better expericence from our site. Scroll down to start reading!') }}</div>
  </div>
  <form class="w-full flex justify-center">
        <div class="search__form shadow-none w-full">
            <input class="search__input" type="text" name="query" value="{{ request()->get('query') }}" placeholder="{{ __('Type your search word') }}">
            <button class="search__btn">
               <svg class="icon icon-search">
                  <use xlink:href="{{ getStorage('assets/image/svg', 'sprite.svg#icon-search') }}"></use>
               </svg>
            </button>
        </div>
  </form>  
</div>

<!-- Section blog trending:START -->
    <section class="blog-trending center sm:mx-auto" {{ empty($most3Read) ? 'hidden' : '' }} {{ request()->get('query') ? 'hidden' : '' }}>
        <div class="title-sections">
            <h2>{{ __('Most Read') }}</h2>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($most3Read as $item)

            @php
                $thislocation = $item->type == 'internal' ? route('index-blog-single', $item->location) : $item->location;
                $thistarget = $item->type == 'internal' ? '_self' : '_blank';
            @endphp


            <div class="avatar-blog bg-snow">
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




<!-- Section Articles:START -->

@if (!$blogs->isEmpty())
<section class="articles center mt-10">
    <div class="title-sections">
        <h2>{{ __('Articles') }}</h2>
    </div>
    

    <div class="grid md:grid-cols-2 gap-4">
        @foreach ($blogs as $item)

            @php
                $thislocation = $item->type == 'internal' ? route('index-blog-single', $item->location) : $item->location;
                $thistarget = $item->type == 'internal' ? '_self' : '_blank';
            @endphp

            <div class="avatar-blog horizontal">
                <a href="{{ $thislocation }}" target="{{ $thistarget }}" class="blog-cover">
                    <img src="{{ getStorage('media/site/blog', $item->thumbnail) }}" alt="">
                </a>
                <div class="blog-body">
                    <a href="{{ $thislocation }}" target="{{ $thistarget }}" class="blog-link">
                        <span class="read-time">
                            {{ $item->ttr }}
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
@else
<div class="is-empty p-20 w-3/6 text-center mx-auto">
  <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-3/6 m-auto" alt="">

  <p class="mt-10 text-lg font-bold">{{ __('Nothing Found.') }}</p>
</div>
@endif
<!-- Section Articles:END -->
@endsection
