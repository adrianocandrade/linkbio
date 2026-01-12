@extends('admin::layouts.master')
@section('title', __('Documentation'))
@section('content')
<div class="section-header mb-10">
    <div class="section-header-info">
        <p class="section-pretitle">{{ __('Documentation') }}</p>
        <h2 class="section-title">{{ __('All Docs') }}</h2>
    </div>
    <div class="section-header-actions">
        <a href="{{ route('admin-docs-create') }}" class="section-header-action">{{ __('New Docs') }}</a>
    </div>
</div>
@if (count($docs)>0)
<div class="grid lg:grid-cols-3 docs-crate mb-10 gap-4">
    @foreach ($docs as $item)
    <div class="crate-item h-full rounded-2xl">
        <div class="item-background mort-main-bg rounded-2xl">
            <div class="item-background-hover rounded-2xl"></div>
        </div>
        <div class="crate-item-contents flex flex-col py-10">
            <div class="content">
                <div class="icon">
                    
                </div>
                <h3 class="text-lg">{{ $item->name }}</h3>
            </div>
            <div class="crate-li my-10">
                @foreach ($guides[$item->id]['guide'] as $guide)
                <a href="{{ route('admin-docs-guide-edit', ['id' => $item->id, 'guide_id' => $guide->id]) }}" app-sandy-prevent class="flex items-center">
                    <svg class="icon icon-settings mr-3">
                        <use xlink:href="{{ gs('assets/image/svg', 'sprite.svg#icon-document') }}"></use>
                    </svg>
                    <span>{{ $guide->name }}</span>
                </a>
                @endforeach
            </div>
            
            <div class="flex mt-auto">
                <a href="{{ route('admin-docs-view', $item->id) }}" class="text-sticker bg-gray-200 flex items-center justify-center m-0">
                    <span class="text-sm font-medium text-secondary">{{ __('View All') }}</span>
                </a>
                <a href="{{ route('admin-docs-edit', $item->id) }}" class="text-sticker m-0 ml-4">
                    <span>{{ __('Edit') }}</span>
                </a>

                <form action="{{ route('admin-docs-delete', $item->id) }}" method="POST" class="ml-auto">
                    @csrf

                    <button data-delete="{{ __("Are you sure you want to delete this Docs and it guide's?") }}" class="text-sticker danger m-0 ml-4"><i class="flaticon-delete"></i></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
  @else
    <div class="is-empty full md:p-10 text-center">
      <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
      <p class="mt-10 text-lg font-bold">{{ __('It\'s kinda lonely here! Start creating.') }}</p>


      <a app-sandy-prevent href="{{ route('admin-docs-create') }}" class="text-sticker mt-5">{{ __('Create') }}</a>
    </div>
  @endif
@endsection