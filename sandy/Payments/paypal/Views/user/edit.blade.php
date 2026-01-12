@extends('mix::layouts.master')
@section('title', __('Paypal'))
@section('namespace', 'sandy-payments-paypal-user-edit')
@section('content')

<div class="p-10">
    <form class="relative" method="post" action="{{ route('user-mix-settings-post', 'payments') }}">
        @csrf
        <div class="card customize mb-5">
            <div class="card-header md:flex items-center">
                <div class="h-avatar mr-4 mb-5 md:mb-0 bg-white p-2 is-video">
                    <img src="{{ getStorage('assets/image/payments', 'paypal-icon.png') }}" class="object-contain" alt="">
                </div>
                <div>                
                    <p class="title text-xl">{{ __('Paypal') }}</p>
                    <p class="subtitle">{{ __('Setup your paypal by adding your credentials') }}</p>


                    @if (Route::has('docs-index'))
                        <a href="{{ route('docs-index', ['query' => 'Payment']) }}" target="_blank" app-sandy-prevent class="mt-5 text-xs c-black font-bold href-link-button">{{ __('Need Help?') }}</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="mort-main-bg p-5 rounded-2xl">
            <div class="form-input mb-5">
                <label class="initial">
                    {{ __('Status') }}
                </label>
                <select name="payments[paypal][status]" class="bg-w">
                    <option value="1" {{ user('payments.paypal.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ user('payments.paypal.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>

            <div class="form-input">
                <label class="initial">
                    {{ __('Mode') }}
                </label>
                <select name="payments[paypal][mode]" class="bg-w">
                    <option value="live" {{ user('payments.paypal.mode') == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                    <option value="sandbox" {{ user('payments.paypal.mode') == 'sandbox' ? 'selected' : '' }}>{{ __('SandBox') }}</option>
                </select>
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your Client Id') }}
                </label>
                <input type="text" name="payments[paypal][client]" class="bg-w" value="{{ user('payments.paypal.client') }}">
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your secret key') }}
                </label>
                <input type="text" name="payments[paypal][secret]" class="bg-w" value="{{ user('payments.paypal.secret') }}">
            </div>
        </div>

        <button class="button mt-5">{{ __('Save') }}</button>
    </form>
</div>
@endsection