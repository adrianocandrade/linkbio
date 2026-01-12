@extends('admin::layouts.master')
@section('title', __('PayTm'))
@section('namespace', 'sandy-payments-admin-user-edit')
@section('content')
<div class="p-10">
    <form class="relative" method="post" action="{{ route('admin-settings-post') }}">
        @csrf
        <div class="card customize mb-5">
            <div class="card-header md:flex items-center">
                <div class="h-avatar bg-white is-video mr-4 mb-5 md:mb-0">
                    <img src="{{ getStorage('assets/image/payments', 'paytm-logo.png') }}" alt="">
                </div>
                <div>
                    <p class="title text-xl">{{ __('PayTm') }}</p>
                    <p class="subtitle">{{ __('Setup your PayTm method by adding the required credentials.') }}</p>
                </div>
            </div>
        </div>
        <div class="mort-main-bg p-5">
            <div class="form-input">
                <label class="initial">
                    {{ __('Status') }}
                </label>
                <select name="settings[payment_paytm][status]" class="bg-w">
                    <option value="1" {{ settings('payment_paytm.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ settings('payment_paytm.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>
            <div class="form-input mt-5">
                <label class="initial">
                    {{ __('Environment') }}
                </label>
                <select name="settings[payment_paytm][environment]" class="bg-w">
                    <option value="production" {{ settings('payment_paytm.environment') == 'production' ? 'selected' : '' }}>{{ __('Production') }}</option>
                    <option value="local" {{ settings('payment_paytm.environment') == 'local' ? 'selected' : '' }}>{{ __('Local') }}</option>
                </select>
            </div>
            <div class="form-input mt-5">
                <label>
                    {{ __('Your Merchant ID') }}
                </label>
                <input type="text" name="settings[payment_paytm][merchant_id]" class="bg-w" value="{{ settings('payment_paytm.merchant_id') }}">
            </div>
            <div class="form-input mt-5">
                <label>
                    {{ __('Your Merchant Key') }}
                </label>
                <input type="text" name="settings[payment_paytm][merchant_key]" class="bg-w" value="{{ settings('payment_paytm.merchant_key') }}">
            </div>
            <div class="form-input mt-5">
                <label>
                    {{ __('Your Merchant Website') }}
                </label>
                <input type="text" name="settings[payment_paytm][merchant_website]" class="bg-w" value="{{ settings('payment_paytm.merchant_website') }}">
            </div>
            <div class="form-input mt-5">
                <label class="initial">
                    {{ __('Your Channel') }}
                </label>
                <select name="settings[payment_paytm][channel]" class="bg-w">
                    <option value="WEB" {{ settings('payment_paytm.channel') == 'WEB' ? 'selected' : '' }}>{{ __('WEB') }}</option>
                    <option value="WAP" {{ settings('payment_paytm.channel') == 'WAP' ? 'selected' : '' }}>{{ __('WAP') }}</option>
                </select>
            </div>
            <div class="form-input mt-5">
                <label>
                    {{ __('Your Industry Type') }}
                </label>
                <input type="text" name="settings[payment_paytm][industry_type]" class="bg-w" value="{{ settings('payment_paytm.industry_type') }}">
            </div>

            <button class="text-sticker mt-5 is-loader-submit black flex items-center">{{ __('Save') }}</button>
        </div>
    </form>
</div>
@endsection