@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-sendWhatsapp-edit", $element->slug) }}" method="post">
    @csrf
    <div class="inner-page-banner">
        {!! Elements::icon('sendWhatsapp') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('sendWhatsapp', 'name') }}</h1>
        <p>{{ Elements::config('sendWhatsapp', 'description') }}</p>
        <div class="form-input mt-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" class="bg-w" name="label" value="{{ $element->name }}">
        </div>
        <div class="mt-4">
            <button class="text-sticker is-loader-submit black flex items-center">{{ __('Save') }}</button>
        </div>
    </div>
    <div class="p-10">
        <div class="form-input mb-7">
            <label class="initial">{{ __('Phone') }}</label>
            <input type="text" placeholder="{{ __('Add your phone number with country code.') }}" name="phone" value="{{ ao($element->content, 'phone') }}">
        </div>
        
        <!-- Branding Start -->
        <div class="card customize mb-10 rounded-xl">
            <div class="flex items-center justify-between">
                <p>{{ __('Send message only once') }}</p>
                <div class="custom-switch mr-4 mb-2">
                    <input type="hidden" name="one_message" value="0">
                    <input type="checkbox" class="custom-control-input" name="one_message" id="one-message" value="1" {{ ao($element->content, 'one_message') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="one-message"></label>
                </div>
            </div>
        </div>
        <!-- Branding End -->
        <div class="form-input mb-7">
            <label>{{ __('Caption') }}</label>
            <textarea name="caption">{{ ao($element->content, 'caption') }}</textarea>
        </div>
    </div>
</form>
@endsection