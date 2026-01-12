@extends('admin::layouts.master')
@section('title', __('Stripe'))
@section('namespace', 'sandy-payments-stripe-admin-edit')
@section('content')

<div class="p-10">
    <form class="relative" method="post" action="{{ route('admin-settings-post') }}">
        @csrf
        <div class="card customize mb-5">
            <div class="card-header md:flex items-center">
                <div class="h-avatar mr-4 mb-5 md:mb-0">
                    <img src="{{ getStorage('assets/image/payments', 'stripe.png') }}" alt="">
                </div>
                <div>                
                    <p class="title text-xl">{{ __('Stripe') }}</p>
                    <p class="subtitle">{{ __('Setup your stripe method by adding the required credentials.') }}</p>
                </div>
            </div>
        </div>

        <div class="mort-main-bg p-5">
            <div class="form-input">
                <label class="initial">
                    {{ __('Status') }}
                </label>
                <select name="settings[payment_stripe][status]" class="bg-w">
                    <option value="1" {{ settings('payment_stripe.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ settings('payment_stripe.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your client key') }}
                </label>
                <input type="text" name="settings[payment_stripe][client]" class="bg-w" value="{{ settings('payment_stripe.client') }}">
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your secret key') }}
                </label>
                <input type="text" name="settings[payment_stripe][secret]" class="bg-w" value="{{ settings('payment_stripe.secret') }}">
            </div>
        </div>

        <button class="text-sticker mt-5 is-loader-submit black flex items-center">{{ __('Save') }}</button>
    </form>
</div>
@endsection