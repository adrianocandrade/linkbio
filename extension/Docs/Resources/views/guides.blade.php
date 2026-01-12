@extends('docs::layouts.master')
@section('title', __('Guides'))
@section('namespace', 'docs-query')
@section('content')
<div class="docs-search-header">
  <div class="search-image-container is-query">
    <img src="{{ gs('assets/image/others/Asset-532.png') }}" class="search-image" alt="">
    <div class="search-image-text">
      <h1 class="search-heading-text">{{ $doc->name }}</h1>
    </div>
  </div>
</div>

@if (!$guides->isEmpty())
<div class="grid md:grid-cols-2 gap-4 mt-5">
  
  @foreach ($guides as $item)
  <div class="avatar-blog horizontal card-shadow p-5 rounded-xl">
    
    <div class="blog-body">
      <a href="{{ route('docs-guide', $item->slug) }}" class="blog-link">
        <span class="read-time">
          {{ ao($item->content, 'subdes') }}
        </span>
        <h4 class="blog-title">
          {{ $item->name }}
        </h4>
      </a>
      <a href="{{ route('docs-guide', $item->slug) }}">
        <div class="person mb-0 media">
          
          <div class="media-body">
            <div class="txt">
              
              <time>{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</time>
            </div>
          </div>
        </div>


        <div class="flex">
          
          <div class="mt-5 text-sticker cursor-pointer ml-auto">{{ __('View') }}</div>
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