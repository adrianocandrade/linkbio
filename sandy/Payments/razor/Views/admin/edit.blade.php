@extends('admin::layouts.master')
@section('title', __('RazorPay'))
@section('namespace', 'sandy-payments-razor-admin-edit')
@section('content')

<div class="p-10">
    <form class="relative" method="post" action="{{ route('admin-settings-post') }}">
        @csrf
        <div class="card customize mb-8">
            <div class="card-header md:flex items-center">
                <div class="h-avatar mr-4 mb-5 md:mb-0">
                    <img src="{{ gs('assets/image/payments', 'razorpay-glyph.svg') }}" alt="">
                </div>
                <div>                
                    <p class="title text-xl">{{ __('RazorPay') }}</p>
                    <p class="subtitle">{{ __('Setup your RazorPay method by adding the required credentials.') }}</p>
                </div>
            </div>
        </div>

        <div class="mort-main-bg p-5 rounded-3xl">
            <div class="form-input">
                <label class="initial">
                    {{ __('Status') }}
                </label>
                <select name="settings[payment_razor][status]" class="bg-w">
                    <option value="1" {{ settings('payment_razor.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ settings('payment_razor.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your client key') }}
                </label>
                <input type="text" name="settings[payment_razor][client]" class="bg-w" value="{{ settings('payment_razor.client') }}">
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your secret key') }}
                </label>
                <input type="text" name="settings[payment_razor][secret]" class="bg-w" value="{{ settings('payment_razor.secret') }}">
            </div>
        </div>

        <button class="text-sticker mt-5 is-loader-submit black flex items-center">{{ __('Save') }}</button>
    </form>
</div>
@endsection