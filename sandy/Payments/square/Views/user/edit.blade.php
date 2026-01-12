@extends('mix::layouts.master')
@section('title', __('Square'))
@section('namespace', 'sandy-payments-square-user-edit')
@section('content')

<div class="p-10">
    <form class="relative" method="post" action="{{ route('user-mix-settings-post', 'payments') }}">
        @csrf
        <div class="card customize mb-5">
            <div class="card-header md:flex items-center">
                <div class="h-avatar mr-4 mb-5 md:mb-0">
                    <img src="{{ getStorage('assets/image/payments', 'square.jpg') }}" alt="">
                </div>
                <div>                
                    <p class="title text-xl">{{ __('Square') }}</p>
                    <p class="subtitle">{{ __('Square gives every business owner an easier way to take credit cards.') }}</p>
                    <p class="subtitle text-xs italic">{{ __('Note: this uses your square location currency.') }}</p>
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
                <select name="payments[square][status]" class="bg-w">
                    <option value="1" {{ user('payments.square.status') == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ user('payments.square.status') == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                </select>
            </div>

            <div class="form-input mt-5">
                <label class="initial">
                    {{ __('Mode') }}
                </label>
                <select name="payments[square][mode]" class="bg-w">
                    <option value="production" {{ user('payments.square.mode') == 'production' ? 'selected' : '' }}>{{ __('Production') }}</option>
                    <option value="sandbox" {{ user('payments.square.mode') == 'sandbox' ? 'selected' : '' }}>{{ __('SandBox') }}</option>
                </select>
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your Application ID') }}
                </label>
                <input type="text" name="payments[square][app_id]" class="bg-w" value="{{ user('payments.square.app_id') }}">
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your Access Token') }}
                </label>
                <input type="text" name="payments[square][access_token]" class="bg-w" value="{{ user('payments.square.access_token') }}">
            </div>

            <div class="form-input mt-5">
                <label>
                    {{ __('Your Location ID') }}
                </label>
                <input type="text" name="payments[square][location_id]" class="bg-w" value="{{ user('payments.square.location_id') }}">
            </div>
        </div>

        <button class="button mt-5">{{ __('Save') }}</button>
    </form>
</div>
@endsection