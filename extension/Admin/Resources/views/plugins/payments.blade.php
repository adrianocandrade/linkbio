@extends('admin::layouts.master')
@section('title', __('Payment Plugins'))
@section('namespace', 'admin-payments-plugins')
@section('content')
<div class="step-banner">
    <h2 class="page__title h2 text-black">{{ __('Payment Methods') }}</h2>
    <button class="page__btn btn btn_white upload-open">{{ __('Upload new') }}</button>
</div>
<div class="mix-padding-10 page-trans rounded-2xl">
    
    <div class="flex-table mt-4">
        <!--Table header-->
        <div class="flex-table-header">
            <span class="is-grow">{{ __('Method') }}</span>
            <span>{{ __('Status') }}</span>
            <span>{{ __('Version') }}</span>
            <span>{{ __('Action') }}</span>
        </div>
        @foreach ($payments as $key => $item)
        <div class="flex-table-item rounded-2xl">
            <div class="flex-table-cell is-media is-grow" data-th="">
                <div class="h-avatar is-medium mr-4 bg-white p-2 is-video">
                    <img class="avatar is-squared object-contain" src="{{ getStorage('assets/image/payments', $getItem($item, 'thumbnail')) }}" alt="">
                </div>
                <div>
                    <span class="item-name dark-inverted is-font-alt is-weight-600">{{ $getItem($item, 'name') }}</span>
                    <span class="item-meta text-xs mt-2">
                        <span>{{ $getItem($item, 'description') }}</span>
                    </span>
                </div>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Status') }}">
                <span class="tag is-green is-rounded">{{ settings("payment_$key.status") ? __('Enabled') : 'Disabled' }}</span>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Version') }}">
                <a class="action-link is-pushed-mobile">{{ $getItem($item, 'version') }}</a>
            </div>
            <div class="flex-table-cell cell-end" data-th="{{ __('Actions') }}">
                @if (Route::has("sandy-payments-$key-admin-edit"))
                <a href="{{ route("sandy-payments-$key-admin-edit") }}" class="text-sticker mt-0 ml-auto mr-3">{{ __('Edit') }}</a>
                @endif



                <form action="{{ route('admin-payments-plugins-delete') }}" method="post">
                    @csrf

                    <input type="hidden" name="plugin" value="{{ $key }}">

                    <button data-delete="{{ __('Do you want to delete this payment method?') }}" class="text-sticker bg-red-500 text-white mt-0 ml-auto">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div data-popup=".upload">
    <div class="inner-page-banner h-32 mb-10 rounded-2xl">
        <h1 class="text-base">{{ __('Payment method') }}</h1>
        <p>{{ __('Upload a payment method .zip to start using.') }}</p>
        <a href="#" target="_blank" class="mt-5 text-xs c-black font-bold href-link-button">{{ __('Get New Method') }}</a>
    </div>
    <form action="{{ route('admin-payments-plugins-upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        <div data-generic-preview="">
            <div class="h-avatar h-32 w-full is-upload is-outline-dark">
                <i class="flaticon-upload-1"></i>
                <input type="file" name="archive">
                <div class="file-name"></div>
            </div>
        </div>

        <button class="text-sticker mt-5">{{ __('Upload') }}</button>
    </form>
</div>
@endsection