@extends('mix::layouts.master')
@section('title', __('Paystack'))
@section('namespace', 'sandy-payments-paystack-user-edit')
@section('content')

<div class="p-10">
    <form class="relative" method="post" action="{{ route('user-mix-settings-post', 'payments') }}">
        @csrf
        <div class="card customize mb-5">
            <div class="card-header md:flex items-center">
                <div class="h-avatar mr-4 mb-5 md:mb-0">
                    <img src="{{ getStorage('assets/image/payments', 'paystack-icon.png') }}" alt="">
                </div>
                <div>                
                    <p class="title text-xl">{{ __('Paystack') }}</p>
                    <p class="subtitle">{{ __('Setup your paystack payment method by adding your secret key.') }}</p>
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
                <select name="payments[paystack][status]" class="bg-w">
                    <option value="1" {{ user('payments.paystack.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ user('payments.paystack.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your secret key') }}
                </label>
                <input type="text" name="payments[paystack][secret]" class="bg-w" value="{{ user('payments.paystack.secret') }}">
            </div>
        </div>

        <button class="button mt-5">{{ __('Save') }}</button>
    </form>
</div>
@endsection