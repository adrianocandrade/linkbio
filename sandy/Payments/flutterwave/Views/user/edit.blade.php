@extends('mix::layouts.master')
@section('title', __('flutterwave'))
@section('namespace', 'sandy-payments-flutterwave-user-edit')
@section('content')

<div class="p-10">
    <form class="relative" method="post" action="{{ route('user-mix-settings-post', 'payments') }}">
        @csrf
        <div class="card customize mb-5">
            <div class="card-header md:flex items-center">
                <div class="h-avatar mr-4 mb-5 md:mb-0">
                    <img src="{{ getStorage('assets/image/payments', 'flutterwave-icon.png') }}" alt="">
                </div>
                <div>                
                    <p class="title text-xl">{{ __('Flutterwave') }}</p>
                    <p class="subtitle">{{ __('Setup your flutterwave payment method by adding your secret key.') }}</p>
                    @if ($query = search_docs('Payment'))
                        <a href="{{ $query }}" target="_blank" app-sandy-prevent class="mt-5 text-xs c-black font-bold href-link-button">{{ __('Need Help?') }}</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="mort-main-bg p-5 rounded-2xl">
            <div class="form-input">
                <label class="initial">
                    {{ __('Status') }}
                </label>
                <select name="payments[flutterwave][status]" class="bg-w">
                    <option value="1" {{ user('payments.flutterwave.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ user('payments.flutterwave.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your secret key') }}
                </label>
                <input type="text" name="payments[flutterwave][secret]" class="bg-w" value="{{ user('payments.flutterwave.secret') }}">
            </div>
        </div>

        <button class="button mt-5">{{ __('Save') }}</button>
    </form>
</div>
@endsection