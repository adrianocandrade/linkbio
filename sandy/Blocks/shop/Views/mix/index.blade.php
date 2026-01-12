@extends('mix::layouts.master')
@section('title', __('Shop'))
@section('content')
<div class="wallet-page mix-padding-10 m-0">

    @if (!plan('settings.block_shop'))
        <style>
            .not-plan .content{
                padding: 1rem;
            }
        </style>
        @include('include.no-plan')
    @endif


    @if (!$products->isEmpty() && !\App\Models\Block::where('user', $user->id)->where('block', 'shop')->first())
    <form method="post" action="{{-- route('user-mix-block-element-post','shop') --}}" class="hidden">
        @csrf
        <h1 class="font-bold text-lg">{{ __('Block') }}</h1>
        <p class="text-xs text-gray-400 mb-2">{{ __('You have products but no product block found.') }}</p>
        <input type="hidden" name="blocks[all_product]" value="1">
        <button class="button w-full mb-5" type="submit"><span>{{ __('Add Block') }}</span></button>
    </form>
    @endif
    
    <div class="dashboard-header-banner relative mt-0 mb-5">
		<div class="card-container">
			
			<div class="text-lg font-bold">{{ __('Shop') }}</div>
            <div class="side-cta">
                <img src="{{ gs('assets/image/emoji/Yellow-1/Nerdy.png') }}" alt="">
            </div>
		</div>
	</div>


    <div class="relative z-10 hidden">
        <div class="wallet-balance step-banner remove-shadow" bg-style="linear-gradient(180deg, #FFD572 0%, #FEBD38 100%)">
            <h1 class="mb-2 font-bold text-black">{{ __('Sell Products') }}</h1>
            <p class="mb-4 text-xs text-black">{{ __('Setup your yetti store to sell physical and downloadable products.') }}</p>
            <div class="wallet-card">
                <!-- Balance -->
                <div class="balance">
                    <div class="left">
                        <div class="flex items-center">
                            <div class="h-avatar sm is-video mr-4" style="background: {{ao(user('settings'), 'avatar_color')}}">
                                <img src="{{ avatar() }}" class="h-full w-full" alt="">
                            </div>
                            <div>
                                
                                <span class="title text-black">{{ __('Earned') }}</span>
                                <h1 class="total text-black">{!! str_replace('Free', '0', \Bio::price(ao($sales, 'totalEarnings'), $user->id)) !!}</h1>
                            </div>
                        </div>
                        <a class="mt-4 text-xs text-black underline truncate" href="{{ bio_url($user->id) . '/shop' }}" target="_blank">{{ bio_url($user->id) . '/shop' }}</a>
                    </div>
                    <div class="right hidden">
                        <a href="#" class="flex items-center justify-center h-full p-2 no-shadow">
                            <i class="sio shopping-icon-024-store sligh-thick text-black text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <div class="quick-actions grid grid-cols-2 gap-4 mt-5">

        <a class="quick-action" href="{{ route('sandy-blocks-shop-mix-shipping-index') }}">

            <div class="quick-action-inner">{{ __('Shipping') }}<span class="arrow-go">→</span>
            </div>
            
            {!! svg_i('truck-1') !!}
        </a>

        <a class="quick-action" href="{{ route('sandy-blocks-shop-mix-orders') }}">

            <div class="quick-action-inner">{{ __('Orders') }}<span class="arrow-go">→</span>
            </div>
            
            {!! svg_i('pie-chart-1') !!}
        </a>

        <a class="quick-action col-span-2" href="{{ route('sandy-blocks-shop-mix-settings') }}">

            <div class="quick-action-inner">{{ __('Settings') }}<span class="arrow-go">→</span>
            </div>
            {!! svg_i('cogwheel-1') !!}
        </a>

        <a class="quick-action col-span-2 hidden" app-sandy-prevent href="{{ route('sandy-blocks-shop-mix-new-product') }}">

            <div class="quick-action-inner">{{ __('Create Product') }}<span class="arrow-go">→</span>
            </div>
            {!! svg_i('store-1') !!}
        </a>
    </div>


    <div class="grid grid-cols-2 gap-4 mt-5 hidden">
        
        <div class="wallet-small-cards relative opacity-100 min-h-full" bg-style="radial-gradient( circle 993px at 0.5% 50.5%,  rgba(137,171,245,0.37) 0%, rgba(245,247,252,1) 100.2% )">
            <div class="icon mt-5 mb-5">
                {!! feather('dollar-sign', 'w-10 h-10') !!}
            </div>
            <div class="title mb-2">
                {!! str_replace('Free', '0', \Bio::price(ao($sales, 'totalEarnings'), $user->id)) !!}
            </div>
            <div class="subtitle">
                {{ nr($products->count(), true) }} {{ __('Products') }}
            </div>
            <div class="flex flex-col mt-auto">
                <p class="subtitle">{{ __('A little about your shop') }}</p>
                <a href="#" class="hidden sales-insight-open sandy-expandable-btn rounded-lg mt-2"><span>{{ __('Sales Insight') }}</span></a>
            </div>
        </div>
        
        <div class="wallet-small-cards relative opacity-100 min-h-full" bg-style="#fff8c7">
            <div class="icon mt-5 mb-5">
                {!! feather('shopping-bag', 'w-10 h-10') !!}
            </div>
            <div class="title mb-2">
                {{ __('Orders') }}
            </div>
            <div class="subtitle">
                {{ __('View & Manage your shop orders.') }}
            </div>
            <div class="flex flex-col">
                <a href="{{ route('sandy-blocks-shop-mix-orders') }}" class="sandy-expandable-btn rounded-lg mt-2"><span>{{ __('View') }}</span></a>
            </div>
        </div>
        
        <div class="wallet-small-cards relative opacity-100 min-h-full" bg-style="linear-gradient( 106.1deg,  rgba(69,242,143,0.52) 10.2%, rgba(14,228,175,0.61) 83.6% )">
            <div class="icon mt-5 mb-5">
                {!! feather('truck', 'w-10 h-10') !!}
            </div>
            <div class="title mb-2">
                {{ __('Shop Shipping') }}
            </div>
            <div class="subtitle">
                {{ __('Setup and manage your shop shipping.') }}
            </div>
            <div class="flex flex-col">
                <a href="{{ route('sandy-blocks-shop-mix-shipping-index') }}" class="sandy-expandable-btn rounded-lg mt-2"><span>{{ __('Manage') }}</span></a>
            </div>
        </div>
        <div class="wallet-small-cards relative opacity-100 min-h-full" bg-style="#FFEAE9">
            <div class="icon mt-5 mb-5">
                {!! feather('settings', 'w-10 h-10') !!}
            </div>
            <div class="title mb-2">
                {{ __('Settings') }}
            </div>
            <div class="subtitle">
                {{ __('Configure your shop settings.') }}
            </div>
            <div class="flex flex-col">
                <a href="{{ route('sandy-blocks-shop-mix-settings') }}" class="sandy-expandable-btn rounded-lg mt-2 bg-white"><span>{{ __('Edit') }}</span></a>
            </div>
        </div>
    </div>
    @if (!$products->isEmpty())
    <div class="my-7">
        <h1 class="font-bold">{{ __('Products') }}</h1>
        <p class="text-gray-400 text-xs mt-2">{{ __('Drag products to reorder them.') }}</p>
    </div>
    <div class="grid grid-cols-2 gap-4 sortable" data-delay="150" data-route="{{ route('sandy-blocks-shop-mix-sort') }}" data-handle=".handler">
        <a class="short-product-card is-upload pointer-events-auto" app-sandy-prevent href="{{ route('sandy-blocks-shop-mix-new-product') }}">
            <i class="plus-icon la la-plus"></i>
        </a>
        @foreach ($products as $item)
        
        <div class="product-card-v2 sortable-item" data-id="{{ $item->id }}">
            <div class="product-card-v2-preview">
                <?= media_or_url($item->banner, 'media/shop/banner', true) ?>
            </div>
            <div class="product-card-v2-link pb-0">
                <div class="product-card-v2-body">
                    <div class="product-card-v2-line flex-col">
                        <div class="product-card-v2-title mb-0 text-sm md:text-base"><?= $item->name ?></div>
                        <div class="text-gray-400 text-sm h-16 md:14 overflow-hidden hidden"></div>
                    </div>
                </div>
                <div class="product-card-v2-foot block m-0 md:flex">
                    <div class="product-card-v2-status w-full">
                        <span class="block text-stage mb-0 product-type">🔥 <?= $item->productType ? __('Downloadable Product') : __('Normal Product') ?></span>

                        <span><?= \Bio::price($item->price, $item->user) ?></span>
                        <div class="grid-cols-12 grid gap-2">
                            
                            <a class="mt-3 sandy-expandable-btn block rounded-xl col-span-8" href="{{ route('sandy-blocks-shop-mix-edit-product', $item->id) }}" app-sandy-prevent="">
                                <span>{{ __('Edit') }}</span>
                            </a>

                            <p class="mt-3 sandy-expandable-btn block rounded-xl flex items-center justify-center col-span-4 handler">
                                {!! orion('move-1', 'w-3 h-3') !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="mt-5">
        @include('include.is-empty', ['link' => ['link' => route('sandy-blocks-shop-mix-new-product'), 'title' => __('Create Product')]])
    </div>
    @endif
</div>
@endsection