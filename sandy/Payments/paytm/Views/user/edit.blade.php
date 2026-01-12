@extends('mix::layouts.master')
@section('title', __('PayTm'))
@section('namespace', 'sandy-payments-paytm-user-edit')
@section('content')
<div class="p-10">
    <form class="relative" method="post" action="{{ route('user-mix-settings-post', 'payments') }}">
        @csrf
        <div class="card customize mb-5">
            <div class="card-header md:flex items-center">
                <div class="h-avatar bg-white is-video mr-4 mb-5 md:mb-0">
                    <img src="{{ getStorage('assets/image/payments', 'paytm-logo.png') }}" alt="">
                </div>
                <div>
                    <p class="title text-xl">{{ __('PayTm') }}</p>
                    <p class="subtitle">{{ __('Setup your PayTm method by adding the required credentials.') }}</p>
                    @if (Route::has('docs-index'))
                        <a href="{{ route('docs-index', ['query' => 'Payment']) }}" target="_blank" app-sandy-prevent class="mt-5 text-xs c-black font-bold href-link-button">{{ __('Need Help?') }}</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="mort-main-bg p-5 rounded-2xl">
            <div class="form-input">
                <label class="initial">
                    {{ __('Status') }}
                </label>
                <select name="payments[paytm][status]" class="bg-w">
                    <option value="1" {{ user('payments.paytm.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ user('payments.paytm.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>
            <div class="form-input mt-5">
                <label class="initial">
                    {{ __('Environment') }}
                </label>
                <select name="payments[paytm][environment]" class="bg-w">
                    <option value="production" {{ user('payments.paytm.environment') == 'production' ? 'selected' : '' }}>{{ __('Production') }}</option>
                    <option value="local" {{ user('payments.paytm.environment') == 'local' ? 'selected' : '' }}>{{ __('Local') }}</option>
                </select>
            </div>
            <div class="form-input mt-5">
                <label>
                    {{ __('Your Merchant ID') }}
                </label>
                <input type="text" name="payments[paytm][merchant_id]" class="bg-w" value="{{ user('payments.paytm.merchant_id') }}">
            </div>
            <div class="form-input mt-5">
                <label>
                    {{ __('Your Merchant Key') }}
                </label>
                <input type="text" name="payments[paytm][merchant_key]" class="bg-w" value="{{ user('payments.paytm.merchant_key') }}">
            </div>
            <div class="form-input mt-5">
                <label>
                    {{ __('Your Merchant Website') }}
                </label>
                <input type="text" name="payments[paytm][merchant_website]" class="bg-w" value="{{ user('payments.paytm.merchant_website') }}">
            </div>
            <div class="form-input mt-5">
                <label class="initial">
                    {{ __('Your Channel') }}
                </label>
                <select name="payments[paytm][channel]" class="bg-w">
                    <option value="WEB" {{ user('payments.paytm.channel') == 'WEB' ? 'selected' : '' }}>{{ __('WEB') }}</option>
                    <option value="WAP" {{ user('payments.paytm.channel') == 'WAP' ? 'selected' : '' }}>{{ __('WAP') }}</option>
                </select>
            </div>
            <div class="form-input mt-5">
                <label>
                    {{ __('Your Industry Type') }}
                </label>
                <input type="text" name="payments[paytm][industry_type]" class="bg-w" value="{{ user('payments.paytm.industry_type') }}">
            </div>

        </div>
        <button class="button mt-5">{{ __('Save') }}</button>
    </form>
</div>
@endsection