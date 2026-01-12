@if (!$cart->isEmpty())
    @foreach ($cart as $item)
    <div class="product-cart">
        <div class="banner rounded-2xl h-20 w-20">
            {!! media_or_url($item->associatedModel->banner, 'media/shop/banner', true) !!}
        </div>
        <div class="content">
            <a class="text-base" href="{{ \Bio::route($bio->id, 'sandy-blocks-shop-single-product', ['id' => $item->associatedModel->id]) }}">{{ $item->name }}</a>
            <p class="text-gray-400 text-sm mb-2">{!! \Bio::price($item->price, $bio->id) !!} x{{ $item->quantity }}</p>

            @if (!empty(ao($item, 'attributes.options')))
                <div class="text-stage text-sm text-gray-600">- {{ ao($item, 'attributes.options.name') }}</div>
            @endif
        </div>
        <form action="{{ \Bio::route($bio->id, 'sandy-blocks-shop-cart-remove-item') }}" method="post">
            @csrf
            <input type="hidden" value="{{ $item->id }}" name="cart_id">
            <button class="cart-remove">
            <i class="sni sni-cross"></i>
            </button>
        </form>
        
    </div>
    @endforeach
@else
<div class="no-record">
    <div class="rounded-3xl block">
        <div class="text-center flex justify-center flex-col items-center">
            <img data-src="{{ \Bio::emoji('Confused_Face') }}" class="lozad w-20" alt="">
            <div class="text-xl font-bold mt-5">{{ __('Cart is empty.') }}</div>
            <div class="w-3/4 mt-3">
                <div class="text-sm text-gray-400">{{ __('Add items to cart to proceed.') }}</div>
            </div>
            <a href="<?= \Bio::route($bio->id, 'sandy-blocks-shop-home') ?>" class="mt-5 sandy-expandable-btn rounded-lg sandy-loader-flower"><span>{{ __('Start Shopping') }}</span></a>
        </div>
    </div>
</div>
@endif