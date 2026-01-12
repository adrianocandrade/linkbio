@extends('admin::layouts.master')
@section('title', __('Square'))
@section('namespace', 'sandy-payments-paystack-user-edit')
@section('content')

<div class="mix-padding-10">
    <form class="relative" method="post" action="{{ route('admin-settings-post') }}">
        @csrf
        <div class="card customize mb-8">
            <div class="card-header md:flex items-center">
                <div class="h-avatar mr-4 mb-5 md:mb-0">
                    <img src="{{ getStorage('assets/image/payments', 'square.jpg') }}" alt="">
                </div>
                <div>                
                    <p class="title text-xl">{{ __('Square') }}</p>
                    <p class="subtitle">{{ __('Square gives every business owner an easier way to take credit cards.') }}</p>
                    <p class="subtitle text-xs italic">{{ __('Note: this uses your square location currency.') }}</p>
                </div>
            </div>
        </div>

        <div class="mort-main-bg p-5 rounded-3xl">
            <div class="form-input">
                <label class="initial">
                    {{ __('Status') }}
                </label>
                <select name="settings[payment_square][status]" class="bg-w">
                    <option value="1" {{ settings('payment_square.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ settings('payment_square.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>

            <div class="form-input mt-5">
                <label class="initial">
                    {{ __('Mode') }}
                </label>
                <select name="settings[payment_square][mode]" class="bg-w">
                    <option value="production" {{ settings('payment_square..mode') == 'production' ? 'selected' : '' }}>{{ __('Production') }}</option>
                    <option value="sandbox" {{ settings('payment_square..mode') == 'sandbox' ? 'selected' : '' }}>{{ __('SandBox') }}</option>
                </select>
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your Application ID') }}
                </label>
                <input type="text" name="settings[payment_square][app_id]" class="bg-w" value="{{ settings('payment_square.app_id') }}">
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your Access Token') }}
                </label>
                <input type="text" name="settings[payment_square][access_token]" class="bg-w" value="{{ settings('payment_square.access_token') }}">
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your Location ID') }}
                </label>
                <input type="text" name="settings[payment_square][location_id]" class="bg-w" value="{{ settings('payment_square.location_id') }}">
            </div>
            <button class="text-sticker mt-5 is-loader-submit black flex items-center">{{ __('Save') }}</button>
        </div>
    </form>
</div>
@endsection