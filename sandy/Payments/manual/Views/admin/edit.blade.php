@extends('admin::layouts.master')
@section('title', __('Manual'))
@section('namespace', 'sandy-payments-admin-user-edit')
@section('content')
<div class="mix-padding-10">
    <form class="relative" method="post" action="{{ route('admin-settings-post') }}">
        @csrf
        <div class="card customize mb-5">
            <div class="card-header md:flex items-center">
                <div class="h-avatar bg-white is-video mr-4 mb-5 md:mb-0">
                    <img src="{{ getStorage('assets/image/payments', 'manual-bank-logo.png') }}" alt="">
                </div>
                <div>
                    <p class="title text-xl">{{ __('Manual') }}</p>
                    <p class="subtitle">{{ __('Setup your manual payment by adding the required info.') }}</p>
                </div>
            </div>
        </div>
        <div class="mort-main-bg p-5 rounded-3xl">
            <div class="form-input">
                <label class="initial">
                    {{ __('Status') }}
                </label>
                <select name="settings[payment_manual][status]" class="bg-w">
                    <option value="1" {{ settings('payment_manual.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ settings('payment_manual.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>
            <div class="form-input mt-5">
                <label>
                    {{ __('Your Bank Details') }}
                </label>

                <textarea name="settings[payment_manual][details]" class="bg-w" cols="30" rows="10">{{ settings('payment_manual.details') }}</textarea>
            </div>

            <button class="text-sticker mt-5 is-loader-submit black flex items-center">{{ __('Save') }}</button>
        </div>
    </form>
</div>
@endsection