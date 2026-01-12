@extends('bio::layouts.master')
@section('content')
@if (ao($product->seo, 'enable'))
@section('seo')
@stop
@endif
<style>
.bio-menu{
display: none !important;
}
</style>
<div class="relative z-10">
    <div class="inner-pages-header mb-10">
        <div class="inner-pages-header-container">
            <a class="previous-page" href="{{ bio_url($bio->id) }}">
                <p class="back-button"><i class="la la-arrow-left"></i></p>
                <h1 class="inner-pages-title ml-3">{{ __('Shop') }}</h1>
            </a>
            <a class="buy-now-button" href="{{ \Bio::route($bio->id, 'sandy-blocks-shop-cart-get') }}"> <span>{{ __('Bag') }}</span> </a>
        </div>
    </div>
    <div class="center bio-single-shop-product">
        <div class="single-banner mb-8">
            {!! media_or_url($product->banner, 'media/shop/banner', true) !!}
        </div>
        @if ($has_order && $product->productType == 1)
        @if (is_array($product->files))
        <div class="mb-5">
            <h1 class="font-bold text-lg">{{ __('Unlocked.') }}</h1>
            <p class="text-gray-400 text-xs">{{ __('Download your unlocked files.') }}</p>
        </div>
        @foreach ($product->files as $key => $value)
        <div class="text-sticker rounded-2xl mb-3 w-full justify-between items-center p-3 h-full">
            <p class="is-link truncate">{{ $value }}</p>
            <a href="{{ gs('media/shop/downloadables', $value) }}" download="{{ $value }}" class="sandy-expandable-btn"><span>{{ __('Download') }}</span></a>
        </div>
        @endforeach
        @else
        <p class="text-gray-400 text-xs">{{ __('Downloadables has not been set by this page.') }}</p>
        @endif
        @endif
        <div class="sandy-tabs">
            <div class="lession-or-review flex-wrap">
                <a class="active sandy-tabs-link">{{ __('Product') }}</a>
                <a class="sandy-tabs-link">{{ __('Review') }}</a>
                @if ($has_order)
                <a class="sandy-tabs-link w-full">{{ __('Orders') }}</a>
                @endif
            </div>
            <div class="sandy-tabs-item">
                <div class="text-stage">- {{ $product->productType ? __('Downloadable Product') : __('Normal Product') }}</div>
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="text-base mb-10 tiny-content-init">
                    {!! clean($product->description, 'titles') !!}
                </div>
                @if (ao($product->stock_settings, 'enable'))
                @if (!empty(ao($product->stock_settings, 'sku')))
                <div class="product-code mb-0">{{ __('SKU') }}:<span class="product-number">{{ ao($product->stock_settings, 'sku') }}</span></div>
                @endif
                <div class="product-code mb-0">{{ __('Stock') }}:<span class="product-number">{{ ao($product->stock) }}</span></div>
                @endif
                @if ($variant->isEmpty())
                <div class="flex items-center {{ $product->price_type == 2 ? 'hidden' : '' }}">
                    <div class="product-prices">
                        @if (!empty($product->comparePrice))
                        <div class="compare">{!! \Bio::price($product->price, $bio->comparePrice) !!}</div>
                        @endif
                        <div class="actual">{!! \Bio::price($product->price, $bio->id) !!}</div>
                    </div>
                </div>
                @endif
                <form action="{{ \Bio::route($bio->id, 'sandy-blocks-shop-cart-add-item') }}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    @if (!$variant->isEmpty())
                    <div class="product-options">
                        
                        <div class="my-7">
                            <div class="text-lg font-bold">{{ __('Options') }}</div>
                            <p class="text-gray-400 text-xs">{{ __('Choose a product option to continue.') }}</p>
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($variant as $item)
                            <label class="sandy-big-checkbox relative product-variation">
                                <input type="radio" name="options" value="{{ $item->id }}" class="sandy-input-inner" {{ $loop->first ? 'checked' : '' }}>
                                
                                <div class="product-variation-inner">
                                    <span class="variant-price-tag ml-auto">{!! \Bio::price($item->price, $bio->id) !!}</span>
                                    @if (ao($product->stock_settings, 'enable'))
                                    <span class="absolute right-5 text-xs">{{ $item->stock }} {{ __('Available') }}</span>
                                    @endif
                                    <div class="text-xl font-bold mt-5 mb-3">{{ $item->name }}</div>
                                    <div class="text-sm">{{ $item->description }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if ($product->price_type == 2)
                        <hr>
                    <div class="product-options">
                        <div class="mt-7">
                            <div class="text-lg font-bold">{{ __('Choose a memebership option') }}</div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach (['monthly' => 'Monthly', 'annual' => 'Annually'] as $key => $value)
                                @if (!empty(ao($product->extra, "price_$key")))
                                <label class="sandy-big-checkbox relative product-variation">
                                    <input type="radio" name="membership_price" value="{{ $key }}" class="sandy-input-inner">
                                    
                                    <div class="product-variation-inner p-2 justify-between items-center flex">
                                        <span class="variant-price-tag remove-before remove-after rounded-xl bg-gray-300 m-0">{!! \Bio::price(ao($product->extra, "price_$key"), $bio->id) !!}</span>


                                        <div class="text-sm md:text-lg lg:text-xl font-bold">{{ $value }}</div>
                                    </div>
                                </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="flex mt-5 items-center">
                        @if ($product->price_type !== 2)
                        <div class="sandy-counter js-counter mr-4 mb-0">
                            <button class="counter-btn counter-btn-minus js-counter-minus" type="button"><i class="la la-arrow-left"></i>
                            </button>
                            <input class="counter-input js-counter-input" type="text" value="1" name="quantity" size="3">
                            <button class="counter-btn counter-btn-plus js-counter-plus" type="button"><i class="la la-arrow-right"></i></button>
                        </div>

                        @else
                            <input type="hidden" value="1" name="quantity">
                        @endif


                        <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower">{{ __('Add to Bag') }}</button>
                    </div>
                </form>
            </div>
            <div class="sandy-tabs-item">
                
                <div class="p-5 mb-5 rounded-2xl course-review-wrapper">
                    
                    @if ($has_order)
                    
                    <form class="comment-form m-0" action="{{ \Bio::route($bio->id, 'sandy-blocks-shop-review', ['id' => $product->id]) }}" method="post">
                        @csrf
                        <div class="comment-title">{{ __('Leave a Review') }}</div>
                        <div class="comment-head">
                            <div class="comment-text">{{ __('Leave a review on this product.') }}</div>
                        </div>
                        <p class="mt-3 mb-2 text-base">{{ __('Rating') }}</p>
                        <div class="mb-5">
                            <input type="hidden" value="2" name="rating" id="rating-input">
                            
                            <div class="rating js-rating m-0 p-0" data-rating="2" data-input-id="#rating-input" data-read="false"></div>
                        </div>
                        <div class="form-input text-count-limit" data-limit="500">
                            <span class="text-count-field"></span>
                            <textarea name="review" cols="30" rows="10"></textarea>
                        </div>
                        <button class="text-sticker-v2 mt-4">{{ __('Post') }}</button>
                    </form>
                    @else
                    <p class="text-lg">{{ __('Purchase this product to leave a review.') }}</p>
                    @endif
                    
                    <div class="rounded-2xl course-review-wrapper flex-col m-0 mt-10">
                        <div>
                            <div class="comment">
                                <div class="comment-head">
                                    <div class="comment-title">{{ number_format($review->count()) }} {{ __('Review(s)') }}</div>
                                </div>
                                <div class="comment-list">
                                    @foreach ($review as $item)
                                    
                                    <div class="comment-item">
                                        <div class="comment-details">
                                            <div class="comment-top">
                                                <div class="comment-author">
                                                    <div class="tiny-avatar ml-0 mr-2">
                                                        <img src="{{ avatar($item->reviewer_id) }}" alt=" ">
                                                    </div>
                                                    {{ user('name', $item->reviewer_id) }}
                                                </div>
                                                <div class="rating js-rating" data-rating="{{ !empty($item->rating) ? $item->rating : '0' }}" data-read="true"></div>
                                            </div>
                                            <div class="comment-content">{{ $item->review }}</div>
                                            <div class="comment-foot">
                                                <div class="comment-time">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($has_order)
            <div class="sandy-tabs-item">
                <div class="flex-table mt-10">
                    @if (is_array($user_orders))
                    @foreach ($user_orders as $item)
                    
                    <div class="flex-table-item rounded-2xl shadow-none">
                        <div class="flex-table-cell is-media is-grow" data-th="">
                            <div class="h-avatar md is-trans">
                                {!! avatar($item->payee_user_id, true) !!}
                            </div>
                            <div>
                                <span class="item-name mb-2">{{ user('name', $item->payee_user_id) }}</span>
                                <span class="item-meta">
                                    <span>#{{ $item->id }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="flex-table-cell" data-th="{{ __('Price') }}">
                            <span>
                                {!! \Bio::price($item->price, $bio->id) !!}
                            </span>
                        </div>
                        <div class="flex-table-cell" data-th="{{ __('Status') }}">
                            <span class="my-0">{{ \Sandy\Blocks\shop\Helper\Shop::order_status($item->status) }}</span>
                        </div>
                        <div class="flex-table-cell" data-th="{{ __('Date') }}">
                            <span class="my-0">{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            @endif
        </div>
        <div class="mb-32"></div>
    </div>
</div>
@endsection