@extends('index::layouts.master')
@section('title', __t('Apps'))
@section('content')
<div bg-style="#f6f6f6" class="yetti-hero pb-20 -mt-32 pt-24 mb-20" style="background: rgb(246, 246, 246) none repeat scroll 0% 0%;">
            
    <div class="hero-copy">
        <h1 class="hero-h1 text-3xl md:text-5xl">{{ __('Accelerated Pages') }}</h1>
        <div class="hero-text">{{ __('Build more advance and interactive bio with our accelerated pages set.') }}</div>
    </div>
    <form class="w-full flex justify-center hidden">
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

<div class="center mt-7">
    <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($apps as $key => $value)
        <a class="app-tile" href="{{ route("index-accelerated-pages-view", $key) }}" iframe-trigger="">
            <div class="app-tile-box rounded-2xl">
                @if (ao($value, 'thumbnail.type') == 'icon')
                <div class="thumbnail h-avatar is-elem md is-video h-16" style="background: {{ ao($value, 'thumbnail.background') }}; color: {{ ao($value, 'thumbnail.i-color') }}">
                    <i class="{{ ao($value, 'thumbnail.thumbnail') }}"></i>
                </div>
                @endif
                <div class="content z-50 relative">
                    <div>
                        <span class="name">
                            {{ __(ao($value, 'name')) }}
                        </span>
                        <span class="description">
                            {{ __(ao($value, 'description')) }}
                        </span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection