@extends('mix::layouts.master')
@section('title', __('Single Order'))
@section('inner-head', true)
@section('content')
@includeIf('include.back-header', ['route' => route('sandy-blocks-shop-mix-orders')])
<div class="inner-pages-header mb-0">
    <div class="inner-pages-header-container mort-main-bg">
        <a class="previous-page" href="{{ route('sandy-blocks-shop-mix-orders') }}">
            <p class="back-button"><i class="la la-arrow-left"></i></p>
            <h1 class="inner-pages-title ml-3">{{ __('Orders') }}</h1>
        </a>
    </div>
</div>
<div class="mix-padding-10">
    <div class="inter-font flex items-center min-h-5 my-10 mt-5">
        <div class="inline-flex items-center ml-2 text-xs">
            <span class="font-medium mr-1 text-sm">{{ __('Status') }}:</span>
            <span class="text-gray-400">{{ $order_status($order->status) }}</span>
        </div>
        <div class="ml-auto text-xs flex items-center">
            <span class="font-medium mr-1 text-sm dark:text-dark-95">{{ __('Date') }}:</span>
            <span class="text-gray-400">{{ \Carbon\Carbon::parse($order->created_at)->toFormattedDateString() }}</span>
            <div class="relative z-50 ml-4">
                
                <div class="index-header-item index-header-item_user">
                    <button class="index-header-head p-0 order-tooltip bg-gray-100 w-8 h-8 flex items-center justify-center rounded">
                        <i class="sio shopping-icon-008-marketing"></i>
                    </button>
                    <div class="index-header-body js-header-body w-44 p-5 remove-before" data-popper-init="bottom-start" data-popper-button=".order-tooltip">
                        <div class="index-header-menu">
                            <form action="{{ route('sandy-blocks-shop-mix-order-status', ['id' => $order->id, 'type' => 'resend_order']) }}" method="post">
                                @csrf
                                <button class="index-header-link">
                                <div class="index-header-text">{{ __('Re-send Order') }}</div>
                                </button>
                            </form>
                            <form action="{{ route('sandy-blocks-shop-mix-order-status', ['id' => $order->id, 'type' => 'completed']) }}" method="post">
                                @csrf
                                <button class="index-header-link">
                                <div class="index-header-text">{{ __('Mark as Completed') }}</div>
                                </button>
                            </form>
                            <form action="{{ route('sandy-blocks-shop-mix-order-status', ['id' => $order->id, 'type' => 'canceled']) }}" method="post">
                                @csrf
                                <button class="index-header-link">
                                <div class="index-header-text">{{ __('Mark as Canceled') }}</div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (\App\User::find($order->payee_user_id))
    <div class="p-5 rounded-2xl mb-5">
        <div class="info mt-5 p-3 bg-white rounded-2xl">
            <div class="avatar-upload sandy-upload-modal-open flex justify-between flex-col items-center">
                <div class="avatar rounded-2xl h-20 w-20 bg-gray-200 flex items-center justify-center">
                    {!! avatar($order->payee_user_id, true) !!}
                </div>
                <div class="content text-center m-0 mt-5">
                    <h5>{{ user('name', $order->payee_user_id) }}</h5>
                    <p class="text-gray-400 text-xs mt-2">{{ user('email', $order->payee_user_id) }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="rounded-2xl p-5 mort-main-bg mb-5">
        <div class="mt-0 pb-0">
            @if (is_array(ao($order->extra, 'cart')))
            @foreach (ao($order->extra, 'cart') as $key => $value)
            @php
            $product = \Sandy\Blocks\shop\Models\Product::find(ao($value, 'attributes.product_id'));
            $banner = $product ? media_or_url($product->banner, 'media/shop/banner', true) : '';
            @endphp
            <div class="product-cart bg-white items-center">
                @if ($product)
                <div class="banner rounded-2xl h-16 w-20">
                    {!! $banner !!}
                </div>
                @endif
                <div class="content flex flex-col">
                    <a class="text-base mb-1">{{ ao($value, 'name') }}</a>
                    <p class="text-gray-400 text-xs mb-2">{!! \Bio::price(ao($value, 'price'), $user->id) !!} x{{ ao($value, 'quantity') }}</p>
                    @if (!empty(ao($value, 'attributes.options')))
                    <div class="text-stage text-sm text-gray-600">- {{ ao($value, 'attributes.options.name') }}</div>
                    @endif
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="rounded-2xl mb-5 active">
        @if (is_array(ao($order->details, 'shipping_location')) && !empty(ao($order->details, 'shipping_location')))
        <div class="mort-main-bg p-5 rounded-2xl mb-7">
            <div class="mb-5">
                <h1 class="text-base font-bold">{{ __('Selected shipping location') }}</h1>
            </div>
            <div class="divider mb-5"></div>
            @foreach (ao($order->details, 'shipping_location') as $key => $value)
            <span><span class="text-sm">{{ ucwords(str_replace('_', ' ', $key)) }}</span> : {{ $value }}</span><br>
            @endforeach
        </div>
        @endif
        @if (is_array(ao($order->details, 'shipping')) && !empty(ao($order->details, 'shipping')))
        <div class="mort-main-bg p-5 rounded-2xl">
            
            <div class="mb-5">
                <h1 class="text-base font-bold">{{ __('Filled information') }}</h1>
            </div>
            <div class="divider mb-5"></div>
            @foreach (ao($order->details, 'shipping') as $key => $value)
            <span><span class="text-sm">{{ ucwords(str_replace('_', ' ', $key)) }}</span> : {{ $value }}</span> <br>
            @endforeach
        </div>
        @endif
    </div>
    @if ($timeline->isEmpty())
    @include('include.no-record')
    @endif
    @foreach ($timeline as $item)
    <div class="order-timeline">
        <div class="p-5">
            @includeIf("Blocks-shop::mix.orders.timeline.$item->type", ['item' => $item])
        </div>
        <div class="order-timeline-sep"></div>
    </div>
    @endforeach
</div>
@endsection