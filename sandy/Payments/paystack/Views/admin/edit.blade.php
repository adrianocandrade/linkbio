@extends('admin::layouts.master')
@section('title', __('Paystack'))
@section('namespace', 'sandy-payments-paystack-user-edit')
@section('content')

<div class="mix-padding-10">
    <form class="relative" method="post" action="{{ route('admin-settings-post') }}">
        @csrf
        <div class="card customize mb-8">
            <div class="card-header md:flex items-center">
                <div class="h-avatar mr-4 mb-5 md:mb-0">
                    <img src="{{ getStorage('assets/image/payments', 'paystack-icon.png') }}" alt="">
                </div>
                <div>                
                    <p class="title text-xl">{{ __('Paystack') }}</p>
                    <p class="subtitle">{{ __('Setup your paystack payment method by adding your secret key.') }}</p>
                </div>
            </div>
        </div>

        <div class="mort-main-bg p-5 rounded-3xl">
            <div class="form-input">
                <label class="initial">
                    {{ __('Status') }}
                </label>
                <select name="settings[payment_paystack][status]" class="bg-w">
                    <option value="1" {{ settings('payment_paystack.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ settings('payment_paystack.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your secret key') }}
                </label>
                <input type="text" name="settings[payment_paystack][secret]" class="bg-w" value="{{ settings('payment_paystack.secret') }}">
            </div>
            
            <button class="text-sticker mt-5 is-loader-submit black flex items-center">{{ __('Save') }}</button>
        </div>
    </form>
</div>
@endsection