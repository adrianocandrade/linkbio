@extends('admin::layouts.master')
@section('title', __('All Page'))
@section('namespace', 'admin-pages')
@section('content')

<div class="step-banner">
  <div class="section-header">
    <div class="section-header-info">
      <p class="section-pretitle">{{ __('Pages') }} ({{count($pages)}})</p>
      <h2 class="section-title">{{ __('All Pages') }}</h2>
      <p class="mt-5 italic text-xs">{{ __('(Note: drag page cards to reorder.)') }}</p>
    </div>
    <div class="section-header-actions">
      <a href="{{ route('admin-new-page') }}" app-sandy-prevent="" class="section-header-action popup-album-creation-trigger">{{ __('Create New Category') }} +</a>
     </div>
  </div>
</div>


<div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 sortable" data-route="{{ route('admin-sort-page') }}" data-handle=".handle">

  @foreach ($pages as $item)
  <div class="blog-cards sortable-item" data-id="{{ $item->id }}">
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
          <a href="{{ route('admin-edit-page', $item->id) }}" class="text-coolGray-400" app-sandy-prevent="">
            {{ __('Edit') }}
          </a>
          -
          <a href="{{ route('admin-delete-page', $item->id) }}" data-delete="{{ __('Are you sure you want to delete this category?') }}" class="text-red-500 font-bold" app-sandy-prevent="">
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
