@extends('admin::layouts.master')
@section('title', __('Paypal'))
@section('namespace', 'sandy-payments-paypal-user-edit')
@section('content')

<div class="mix-padding-10">
    <form class="relative" method="post" action="{{ route('admin-settings-post') }}">
        @csrf
        <div class="card customize mb-5">
            <div class="card-header md:flex items-center">
                <div class="h-avatar mr-4 mb-5 md:mb-0 bg-white p-2 is-video">
                    <img src="{{ getStorage('assets/image/payments', 'paypal-icon.png') }}" class="object-contain" alt="">
                </div>
                <div>                
                    <p class="title text-xl">{{ __('Paypal') }}</p>
                    <p class="subtitle">{{ __('Setup your paypal by adding your credentials') }}</p>
                </div>
            </div>
        </div>

        <div class="mort-main-bg p-5">
            <div class="form-input mb-5">
                <label class="initial">
                    {{ __('Status') }}
                </label>
                <select name="settings[payment_paypal][status]" class="bg-w">
                    <option value="1" {{ settings('payment_paypal.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ settings('payment_paypal.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>

            <div class="form-input">
                <label class="initial">
                    {{ __('Mode') }}
                </label>
                <select name="settings[payment_paypal][mode]" class="bg-w">
                    <option value="live" {{ settings('payment_paypal.mode') == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                    <option value="sandbox" {{ settings('payment_paypal.mode') == 'sandbox' ? 'selected' : '' }}>{{ __('SandBox') }}</option>
                </select>
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your Client Id') }}
                </label>
                <input type="text" name="settings[payment_paypal][client]" class="bg-w" value="{{ settings('payment_paypal.client') }}">
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your secret key') }}
                </label>
                <input type="text" name="settings[payment_paypal][secret]" class="bg-w" value="{{ settings('payment_paypal.secret') }}">
            </div>
            
            <button class="text-sticker mt-5 is-loader-submit black flex items-center">{{ __('Save') }}</button>
        </div>

    </form>
</div>
@endsection