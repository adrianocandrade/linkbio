@extends('admin::layouts.master')

@section('title', __('Plugins'))
@section('namespace', 'admin-plugins-types')
@section('content')
<div class="grid md:grid-cols-2 gap-4">  

    <div>
        <div class="card card_widget mb-7 block has-sweet-container">
            <div class="card-container">
                
                <div class="side-cta">
                    <img src="{{ gs('assets/image/others/Asset-555.png') }}" alt="">
                </div>
                <div class="icon ">
                    <i class="sio technology-flaticon-016-plug text-6xl"></i>
                </div>
                <div class="mt-5 text-2xl">{{ __('General Plugin') }}</div>
                <div class="my-2 text-xs is-info">{{ __('Delete, install plugins to add more functionalities to your script.') }}</div>
                <a href="{{ route('admin-general-plugins') }}" class="text-sticker bg-gray text-white">{{ __('View') }}</a>
            </div>
        </div>
    </div>

    <div>
        <div class="card card_widget mb-7 block has-sweet-container">
            <div class="card-container">
                
                <div class="side-cta">
                    <img src="{{ gs('assets/image/others/Asset-555.png') }}" alt="">
                </div>
                <div class="icon ">
                    <i class="sio security-icon-042-thunder-bolt text-6xl"></i>
                </div>
                <div class="mt-5 text-2xl">{{ __('Elements Addon') }}</div>
                <div class="my-2 text-xs is-info">{{ __('Edit, configure or install elements to be available to your users.') }}</div>
                <a href="{{ route('admin-bio-elements') }}" class="text-sticker bg-gray text-white">{{ __('View') }}</a>
            </div>
        </div>
    </div>

    <div>
        <div class="card card_widget mb-7 sm:mb-0 block has-sweet-container">
            <div class="card-container">
                
                <div class="side-cta">
                    <img src="{{ gs('assets/image/others/Asset-555.png') }}" alt="">
                </div>
                <div class="icon ">
                    <i class="sio shopping-icon-034-payment-gateway text-6xl"></i>
                </div>
                <div class="mt-5 text-2xl">{{ __('Payments Addon') }}</div>
                <div class="my-2 text-xs is-info">{{ __('Select & configure your installed payment method to be used when purchasing plans.') }}</div>
                <a href="{{ route('admin-payments-plugins') }}" class="text-sticker bg-gray text-white">{{ __('Configure') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
