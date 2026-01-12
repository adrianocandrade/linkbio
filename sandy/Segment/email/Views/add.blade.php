@extends('mix::layouts.master')
@section('content')
@section('title', __('Create Email List'))
<form action="{{ route('sandy-app-email-create') }}" method="post">
    @csrf
    <div class="inner-page-banner">
        <h1>{{ __('Email Collection') }}</h1>
        <p>{{ __('Add a title and description to provide more detail about your list.') }}</p>
        <div class="mt-4">
            <button class="text-sticker m-0">{{ __('Save') }}</button>
        </div>

        <div class="form-input mt-5">
            <label for="">{{ __('Element Label') }}</label>
            <input type="text" class="bg-w" name="label">
        </div>
    </div>
    <div class="mix-padding-10">
        <div class="card customize bg-white mb-10">
            <div class="card-header">
                <div class="form-input mb-7 text-count-limit" data-limit="60">
                    <label>{{ __('Title') }}</label>
                    <span class="text-count-field"></span>
                    <input type="text" name="title">
                </div>
                <div class="form-input text-count-limit" data-limit="200">
                    <label class="initial block mb-3">{{ __('Description') }}</label>
                    <span class="text-count-field"></span>
                    <textarea rows="4" name="description" class="text-xs" placeholder="{{ __('Ex: Sign up with your email address to receive news and updates.') }}"></textarea>
                </div>
                <div class="card customize mt-5">
                  <div class="card-header">
                    <p class="subtitle text-xs">{{ __('Require Name') }}</p>
                    <div class="custom-switch mt-3">
                      <input type="hidden" name="require_name" value="0">
                      <input type="checkbox" class="custom-control-input" name="require_name" id="require-name" value="1">
                      <label class="custom-control-label" for="require-name"></label>
                    </div>
                  </div>
                </div>
                <div class="form-input text-count-limit mt-5" data-limit="200">
                    <label class="initial mb-3 block">{{ __('Disclaimer Info *optional') }}</label>
                    <span class="text-count-field"></span>
                    <textarea rows="2" class="text-xs" placeholder="{{ __('Ex: Your personal information will not be sold to advertisers or other Third Parties.') }}" name="disclaimer"></textarea>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection