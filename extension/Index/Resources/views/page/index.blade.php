@extends('index::layouts.master')
@section('title', __('Blog'))
@section('namespace', 'index-blog-all')
@section('content')
<div class="relative">
    <div class="div-block-10"></div>
</div>
<section class="index-hero text-black h-550">
    <div class="index-hero-container flex">
        <div class="hero-left">
            <div>
                
                <p class="mb-3 font-bold tag w-full">{{ __('Latest news') }}</p>
            </div>
            <h1 class="text-3xl md:text-5xl mb-5 text-black">{{ __('Our Blog Posts.') }}</h1>
            <div class="search-results">
                <form class="search__form w-full" method="GET">
                    <input class="search__input mort-main-bg" type="text" name="query" value="{{ request()->get('query') }}" placeholder="{{ __('Type your search word') }}">
                    
                    <button class="search__btn">
                    <svg class="icon icon-search">
                        <use xlink:href="{{ getStorage('assets/image/svg', 'sprite.svg#icon-search') }}"></use>
                    </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
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