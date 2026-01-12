@extends('mix::layouts.master')
@section('title', __('Shipping'))
@section('content')
@includeIf('include.back-header', ['route' => route('sandy-blocks-shop-mix-view')])
<div class="mix-padding-10">
    
    <div class="mb-8">
        <div class="font-bold mb-3">{{ __('Shipping') }}</div>
        <p class="text-xs text-gray-400">{{ __('Add shipping country as well as locations. Set your store shipping type to strict for users to select a location before checkout.') }}</p>
    </div>

    @if (!$shipping->isEmpty())
        <div class="flex-table mt-4">
            <!--Table header-->
            <div class="flex-table-header">
                <span class="is-grow">{{ __('Country') }}</span>
                <span class="cell-end">{{ __('Actions') }}</span>
            </div>

            @foreach ($shipping as $item)
            <div class="flex-table-item rounded-2xl">
                <div class="flex-table-cell is-media is-grow" data-th="">
                    <div class="h-avatar sm">
                        <img data-src="{{ \Country::icon($item->country_iso) }}" class="lozad" alt="">
                    </div>
                    <div>
                        <span class="item-name dark-inverted is-font-alt is-weight-600">{{ $item->country }}</span>
                    </div>
                </div>
                <div class="flex-table-cell cell-end" data-th="{{ __('Actions') }}">

                    <a href="{{ route('sandy-blocks-shop-mix-shipping-locations', $item->id) }}" class="sandy-expandable-btn ml-auto"><span>{{ __('Locations') }}</span></a>


                    <form action="{{ route('sandy-blocks-shop-mix-shipping-delete', $item->id) }}" method="post">
                        @csrf

                        <button class="sandy-expandable-btn ml-2 bg-red-500 text-white" data-delete="{{ __('Are you sure you want to delete this shipping and it locations?') }}"><span>{{ __('Delete') }}</span></button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif


    <a class="sandy-expandable-btn cursor-pointer shipping-new-open mt-5"><span>{{ __('New Shipping') }}</span></a>
</div>
<div data-popup=".shipping-new" class="half-short">
    <form action="{{ route('sandy-blocks-shop-mix-shipping-post-new') }}" method="post">
        @csrf
        
        <div class="form-input">
            <select name="country">
                @foreach (\App\Others\Country::list() as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <p class="text-xs text-gray-400 mt-3">{{ __('Save shipping to add locations.') }}</p>
        <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-10"><span>{{ __('Save') }}</span></button>
    </form>
</div>
@endsection