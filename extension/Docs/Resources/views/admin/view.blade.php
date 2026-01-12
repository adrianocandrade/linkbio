@extends('admin::layouts.master')
@section('title', __('Docs Guides'))
@section('content')
<div class="section-header mb-10">
  <div class="section-header-info">
    <p class="section-pretitle">{{ __('Guides') }}</p>
    <h2 class="section-title">{{ __('All Docs Guides') }}</h2>
  </div>
  <div class="section-header-actions">
    <a app-sandy-prevent href="{{ route('admin-docs-guide-create', $doc->id) }}" class="section-header-action">{{ __('Create New') }}</a>
  </div>
</div>
<div class="page-trans rounded-2xl">
  @if (!$guides->isEmpty())
  <div class="flex-table mt-4">
    <!--Table header-->
    <div class="flex-table-header">
      <span class="is-grow">{{ __('Name') }}</span>
      <span>{{ __('Status') }}</span>
      <span>{{ __('Doc') }}</span>
      <span>{{ __('Action') }}</span>
    </div>
    @foreach ($guides as $item)
    <div class="flex-table-item rounded-2xl">
      <div class="flex-table-cell is-media is-grow" data-th="">
        <div class="h-avatar is-medium mr-4 hidden">
          <img class="avatar is-squared bg-white object-contain" src="" alt="">
        </div>
        <div>
          <span class="item-name dark-inverted is-font-alt is-weight-600">{{ $item->name }}</span>
          <span class="item-meta text-xs mt-2">
            <span>{{ ao($item->content, 'subdes') }}</span>
          </span>
        </div>
      </div>
      <div class="flex-table-cell" data-th="{{ __('Status') }}">
        <span class="tag is-green is-rounded">{{ $item->status ? __('Active') : __('Hidden') }}</span>
      </div>
      <div class="flex-table-cell" data-th="{{ __('Docs') }}">
        <a class="action-link is-pushed-mobile">{{ $doc->name }}</a>
      </div>
      <div class="flex-table-cell cell-end" data-th="{{ __('Actions') }}">
        <a href="{{ route('admin-docs-guide-edit', ['id' => $doc->id, 'guide_id' => $item->id]) }}" app-sandy-prevent class="text-sticker mt-0 ml-auto mr-3 font-light">{{ __('Edit') }} <i class="flaticon-edit ml-3"></i></a>
        <form action="{{ route('admin-docs-guide-delete', ['id' => $doc->id, 'guide_id' => $item->id]) }}" method="post">
          @csrf
          <button data-delete="{{ __('Are you sure you want to delete this?') }}" class="text-sticker bg-red-500 text-white m-0"><i class="flaticon-delete"></i></button>
        </form>
      </div>
    </div>
    @endforeach
  </div>
  @else
    <div class="is-empty full md:p-10 text-center">
      <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
      <p class="mt-10 text-lg font-bold">{{ __('It\'s kinda lonely here! Start creating.') }}</p>


      <a app-sandy-prevent href="{{ route('admin-docs-guide-create', $doc->id) }}" class="text-sticker mt-5">{{ __('Create') }}</a>
    </div>
  @endif
  
</div>
@endsection