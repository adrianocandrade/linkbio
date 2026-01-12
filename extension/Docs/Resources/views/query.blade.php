@extends('docs::layouts.master')
@section('title', __('Query - :query', ['query' => request()->get('query')]))
@section('namespace', 'docs-query')
@section('content')
<div class="docs-search-header">
  <div class="search-image-container is-query">
    <img src="{{ gs('assets/image/others/Asset-532.png') }}" class="search-image" alt="">
    <div class="search-image-text">
      <h1 class="search-heading-text">{{ __('Results') }}</h1>
    </div>
  </div>
  <div class="search-results">
    <form class="search__form w-full" method="GET">
      <input class="search__input" type="text" name="query" value="{{ request()->get('query') }}" placeholder="{{ __('Type your search word') }}">
      <button class="search__btn">
      <svg class="icon icon-search">
        <use xlink:href="{{ gs('assets/image/svg', 'sprite.svg#icon-search') }}"></use>
      </svg>
      </button>
    </form>
  </div>
</div>

@if (!$docs->isEmpty())
<div class="grid md:grid-cols-2 gap-4 mt-5">
  
  @foreach ($docs as $item)
  <div class="avatar-blog horizontal">
    
    <div class="blog-body">
      <a href="{{ route('docs-guide', $item->slug) }}" class="blog-link">
        <span class="read-time">
          {{ ao($item->content, 'subdes') }}
        </span>
        <h4 class="blog-title">
          {{ $item->name }}
        </h4>
      </a>
      <a>
        <div class="person mb-0 media">
          
          <div class="media-body">
            <div class="txt">
              
              <time>{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</time>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
  @endforeach
</div>
  @else
  <div class="is-empty full p-10 text-center md:p-20">
  <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="m-auto" alt="">

  <p class="mt-10 text-lg font-bold">{{ __('Not results found.') }}</p>
</div>
@endif
@endsection