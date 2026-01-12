@extends('bio::layouts.master')
@section('content')
<style>
.bio-menu{
display: none !important;
}
</style>
<div class="relative z-10 pb-20">
    @include('Blocks-shop::bio.include.inner-page-header', ['previous' => url()->previous()])
    <div class="p-10">
        <div class="my-7">
            <div class="text-lg font-bold">{{ __('Cart') }}</div>
            <p class="text-gray-400 text-xs">{{ __('Add your shipping information.') }}</p>
        </div>
        {!! (new \Sandy\Blocks\shop\Helper\Cart)->get_cart($bio->id, true) !!}
        
        <div class="info mt-10">
            @if ($auth_user = \Auth::user())
            <div class="avatar-upload sandy-upload-modal-open flex justify-between items-center mb-5">
                <div class="avatar rounded-2xl h-20 w-20 flex items-center justify-center">
                    {!! avatar($auth_user->id, $html = true) !!}
                </div>
                <div class="content text-right">
                    <p class="text-gray-400 text-xs mb-2">{{ __('Logged in as.') }}</p>
                    <h5>{{ $auth_user->name }}</h5>
                </div>
            </div>
            @endif
        </div>
        <form action="{{ \Bio::route($bio->id, 'sandy-blocks-shop-cart-checkout') }}" method="post">
            @csrf
            
            <div class="form-input mb-5">
                <label>{{ __('Email') }}</label>
                <input type="text" name="email" value="{{ \Auth::check() ? \Auth::user()->email : '' }}">
            </div>

            @if (user('settings.store.shipping.enable', $bio->id))
            <div class="shipping">
                <div class="my-7">
                    <div class="text-lg font-bold">{{ __('Shipping') }}</div>
                    <p class="text-gray-400 text-xs">{{ __('Add your shipping information.') }}</p>
                </div>
                <div class="form-input mb-5">
                    <label>{{ __('Full Name') }}</label>
                    <input type="text" name="shipping[full_name]">
                </div>
                <div class="form-input mb-5">
                    <label>{{ __('Full Address') }}</label>
                    <input type="text" name="shipping[address]">
                </div>
                <div class="form-input mb-5">
                    <label>{{ __('Street Name') }}</label>
                    <input type="text" name="shipping[street_name]">
                </div>
                <div class="form-input mb-5">
                    <label>{{ __('House Number') }}</label>
                    <input type="text" name="shipping[house_number]">
                </div>
                <div class="form-input mb-5">
                    <label>{{ __('Phone Number') }}</label>
                    <input type="text" name="shipping[phone_number]">
                </div>
                <div class="form-input mb-5">
                    <label>{{ __('Additional Info') }}</label>
                    <textarea name="shipping[additional_info]"></textarea>
                    <p class="mt-3 text-xs text-gray-400">{{ __('Additional info can be a phone number and information that are not in the fieldset.') }}</p>
                </div>
                @if (!user('settings.store.shipping.type', $bio->id))
                <div class="form-input mb-5">
                    <label>{{ __('State') }}</label>
                    <input type="text" name="shipping[state]">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    
                    <div class="form-input">
                        <label>{{ __('City') }}</label>
                        <input type="text" name="shipping[city]">
                    </div>
                    <div class="form-input">
                        <label>{{ __('Country') }}</label>
                        <input type="text" name="shipping[country]">
                    </div>
                </div>
                @endif
            </div>
            @if (!$shipping->isEmpty())
            <div class="my-7">
                <div class="text-lg font-bold">{{ __('Shipping Locations') }}</div>
                <p class="text-gray-400 text-xs">{{ __('These are the locations we can ship to.') }}</p>
            </div>
            @foreach ($shipping as $ship)
            @php
            $locations = \Sandy\Blocks\shop\Models\ProductShippingLocation::where('shipping_id', $ship->id)->get();
            @endphp
            <div class="links-accordion">
                <div class="sandy-accordion">
                    <div class="sandy-accordion-head flex items-center">
                        <div class="h-avatar sm">
                            <img data-src="{{ \Country::icon($ship->country_iso) }}" class="lozad" alt="">
                        </div>
                        <span class="font-bold ml-3">{{ $ship->country }}</span>
                    </div>
                    <div class="sandy-accordion-body mt-5 pb-0">
                        
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($locations as $item)
                            <label class="sandy-big-checkbox remove-flow relative product-variation">
                                <input type="radio" name="shipping_location" value="{{ $item->id }}" class="sandy-input-inner" data-shipping-price="{!! \Bio::price($item->price, $bio->id) !!}">
                                
                                <div class="product-variation-inner flex justify-end flex-col w-full">
                                    <div class="text-sm font-bold mt-5 mb-3">{{  $item->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $item->description }}</div>
                                    <span class="mt-3 ml-auto">{!! \Bio::price($item->price, $bio->id) !!}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            @endif
            @if (!\DarryCart::session($bio->id)->isEmpty())
            <div class="my-7">
                <div class="text-lg font-bold">{{ __('Price') }}</div>
                <p class="text-gray-400 text-xs">{{ __('Check total and subtotal to pay.') }}</p>
            </div>
            <div class="cart-receipt">
                <div class="cart-wrap">
                    @if (user('settings.store.shipping.enable', $bio->id))
                    <div class="flex justify-between mb-5">
                        <div class="cart-text font-bold text-lg">{{ __('Shipping') }}:</div>
                        <div class="text-gray-500 text-lg shipping-total">-</div>
                    </div>
                    @endif
                    <div class="flex justify-between mb-5">
                        <div class="cart-text font-bold text-lg">{{ __('Quantity') }}:</div>
                        <div class="text-gray-500 text-lg">{!! nr(\DarryCart::session($bio->id)->getTotalQuantity(), 2, true) !!}</div>
                    </div>
                    <div class="flex justify-between">
                        <div class="cart-text font-bold text-lg">{{ __('Total') }}:</div>
                        <div class="text-gray-500 text-lg">{!! \Bio::price(\DarryCart::session($bio->id)->getTotal(), $bio->id) !!} <span class="shipping-total"></span></div>
                    </div>
                </div>
            </div>
            <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-10" >
            <span>{{ __('Pay') }}</span>
            @auth
            <div class="tiny-avatar"><?= avatar(user('id'), true) ?></div>
            @endauth
            </button>
            @endif
        </form>
        @if (\DarryCart::session($bio->id)->isEmpty())
        <a href="{{ \bio_url($bio->id) }}" class="mt-5 sandy-expandable-btn rounded-lg sandy-loader-flower"><span>{{ __('Start Shopping') }}</span></a>
        @endif
    </div>
</div>
@section('footerJS')
<script>
jQuery('[data-shipping-price]').each(function(){
var price = jQuery(this).data('shipping-price');
jQuery(this).on('change', function(){
jQuery('.shipping-total').text(' + ' + price);
});
});

</script>
@stop
@endsection