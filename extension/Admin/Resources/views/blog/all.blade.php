@extends('admin::layouts.master')
@section('title', __('All Blog'))
@section('namespace', 'admin-blogs')
@section('content')

<div class="step-banner">
  <div class="section-header">
    <div class="section-header-info">
      <p class="section-pretitle">{{ __('Blogs') }} ({{count($blogs)}})</p>
      <h2 class="section-title">{{ __('All Blogs') }}</h2>
      <p class="mt-5 italic text-xs">{{ __('(Note: drag blog cards to reorder.)') }}</p>
    </div>
    <div class="section-header-actions">
      <a href="{{ route('admin-new-blog') }}" app-sandy-prevent="" class="section-header-action popup-album-creation-trigger">{{ __('Create New Post') }} +</a>
     </div>
  </div>
</div>


<div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 sortable" data-route="{{ route('admin-sort-blog') }}" data-handle=".handle">

  @foreach ($blogs as $item)
  <div class="blog-cards sortable-item" data-id="{{ $item->id }}">
    <div class="thumbnail">
      <img src="{{ getStorage('media/site/blog', $item->thumbnail) }}" alt="">
    </div>

    <div class="content">
      <p class="text-sticker"><span class="highlighted">{{ __('by') }}</span> {{ $item->author }}</p>

      <p class="blog-title mb-5">
        {{ $item->name }}
      </p>

      <div class="flex justify-between">
        <div>
          {{ $item->ttr }}
        </div>

        <div>
          <a href="{{ route('admin-edit-blog', $item->id) }}" class="text-coolGray-400" app-sandy-prevent="">
            {{ __('Edit') }}
          </a>
          -
          <a href="{{ route('admin-delete-blog', $item->id) }}" data-delete="{{ __('Are you sure you want to delete this post?') }}" class="text-red-500 font-bold" app-sandy-prevent="">
            {{ __('Delete') }}
          </a>
        </div>
      </div>
    </div>

    <div class="drag cursor-pointer handle">
      <i class="la la-arrows"></i>
    </div>
  </div>
  @endforeach
</div>
@endsection
