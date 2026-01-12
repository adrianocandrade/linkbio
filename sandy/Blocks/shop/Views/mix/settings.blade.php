@extends('mix::layouts.master')
@section('title', __('Shop Settings'))
@section('content')
@includeIf('include.back-header', ['route' => route('sandy-blocks-shop-mix-view')])
<div class="mix-padding-10">
    <div class="mb-5 rounded-2xl flex justify-between align-end items-center p-8 md:p-14 mort-main-bg">
        <div class="flex align-center">
            <div class="color-primary flex flex-col">
                <span class="font-bold text-lg mb-1">{{ __('Shop Settings') }}</span>
                <span class="text-xs text-gray-400">{{ __('Setup your shop and start selling both physical & digital products.') }}</span>
            </div>
        </div>
    </div>
    <form action="{{ route('sandy-blocks-shop-mix-settings-post') }}" method="post">
        @csrf
        <div class="mort-main-bg rounded-2xl p-5 mb-5">
            <div class="form-input mb-5">
                <label>{{ __('Shop Name') }}</label>
                <input type="text" class="bg-w" name="store[shop_name]" value="{{ user('settings.store.shop_name') }}">
            </div>
            <div class="form-input">
                <label>{{ __('Shop Description') }}</label>
                <textarea name="store[shop_description]" class="bg-w" cols="30" rows="10">{{ user('settings.store.shop_description') }}</textarea>
            </div>
            <button class="text-sticker mt-5">{{ __('Save') }}</button>
        </div>
        
        <div class="mort-main-bg rounded-2xl p-5 mb-5">
            <div class="card customize mb-5 bg-white">
                <div class="card-header flex justify-between">
                    <p class="title mb-0">{{ __('Enable shipping') }}</p>
                    <label class="sandy-switch">
                        <input type="hidden" name="store[shipping][enable]" value="0">
                        <input class="sandy-switch-input" name="store[shipping][enable]" {{ user('settings.store.shipping.enable') ? 'checked' : '' }} value="1" type="checkbox">
                        <span class="sandy-switch-in"><span class="sandy-switch-box"></span></span>
                    </label>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="sandy-big-checkbox relative">
                    <input type="radio" name="store[shipping][type]" {{ !user('settings.store.shipping.type') ? 'checked' : '' }} value="0" class="sandy-input-inner">
                    <div class="checkbox-inner rounded-2xl">
                        <div class="checkbox-wrap">
                            <div class="content">
                                <h1>{{ __('No strict') }}</h1>
                                <p>{{ __('Customers can use any shipping location') }}</p>
                            </div>
                            <div class="icon">
                                <div class="active-dot">
                                    <i class="la la-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
                
                <label class="sandy-big-checkbox">
                    <input type="radio" name="store[shipping][type]" {{ user('settings.store.shipping.type') ? 'checked' : '' }} value="1" class="sandy-input-inner">
                    <div class="checkbox-inner rounded-2xl">
                        <div class="checkbox-wrap">
                            <div class="content">
                                <h1>{{ __('Strict') }}</h1>
                                <p>{{ __('Customers can only use your created shipping locations') }}</p>
                            </div>
                            <div class="icon">
                                <div class="active-dot">
                                    <i class="la la-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <a href="{{ route('sandy-blocks-shop-mix-shipping-index') }}" class="sandy-expandable-btn mt-5 mb-5"><span>{{ __('Create a shipping location') }}</span></a>
            
            <button class="text-sticker mt-5 block">{{ __('Save') }}</button>
        </div>
    </form>
</div>
@endsection