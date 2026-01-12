@extends('bio::layouts.master')
@section('content')
@section('head')

<style>
    .bio-menu{
        display: none !important;
    }
</style>
@stop
<div class="context bio a-left">
    <div class="inner-pages-header mb-10">
        <div class="inner-pages-header-container">
            <a class="previous-page" href="{{ bio_url($bio->id) }}">
                <p class="back-button"><i class="la la-arrow-left"></i></p>
                <h1 class="inner-pages-title ml-3">{{ __('Home') }}</h1>
            </a>
            <a class="buy-now-button" href="{{ \Bio::route($bio->id, 'sandy-blocks-shop-cart-get') }}"><span>{{ __('Bag') }}</span></a>
        </div>
    </div>
    <div class="context-head px-5 md:px-10 pt-10 pb-0 mt-0">
        <div class="avatar-thumb mb-5">
            <div class="avatar-container">
                <div class="thumb" style="background: {{ao($bio->settings, 'avatar_color')}}">
                    {!! avatar($bio->id, true) !!}
                </div>
            </div>
        </div>
        <div class="shop-name-text text-2xl theme-text-color flex">{{ user('settings.store.shop_name', $bio->id) }}</div>
        <div class="bio-des mt-5 text-sm mb-7 theme-text-color">{{ user('settings.store.shop_description', $bio->id) }}</div>
    </div>
    <div class="mix-padding-10">
        @if (!$products->isEmpty())
        <h1 class="my-7 font-bold">{{ __('Products') }}</h1>
        <div class="grid grid-cols-2 gap-4">
            @foreach ($products as $item)
            <?= \Sandy\Blocks\shop\Helper\Shop::shop_product_item($item) ?>
            @endforeach
        </div>
        @else
        <div class="is-empty p-20 text-center">
            <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
            <p class="mt-10 text-lg font-bold">{{ __('No product found.') }}</p>
        </div>
        @endif
    </div>
</div>
<div class="pb-20"></div>
@endsection