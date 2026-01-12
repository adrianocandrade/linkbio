@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-qrCode-edit", $element->slug) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner">
        <div class="h-avatar md">
            {!! videoOrImage(media_or_url($element->thumbnail, 'media/element/thumbnail')) !!}
        </div>
        <h1 class="mt-5 text-base">{{ Elements::config($ElemName, 'name') }}</h1>
        <p>{{ Elements::config($ElemName, 'description') }}</p>
        <div class="form-input mt-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Leave a Tip') }}" class="bg-w" name="label" value="{{ $element->name }}">
        </div>
        <div class="mt-4">
            <button class="text-sticker is-loader-submit black flex items-center">{{ __('Save') }}</button>
        </div>
    </div>
    <div class="p-10">
        <div class="form-input mb-10">
            
            <label class="initial">{{ __('Cover / Background') }}</label>
            <div class="h-avatar h-40 w-40 is-upload is-outline-dark text-2xl active sandy-upload-modal-open" data-generic-preview="">
                <i class="flaticon-upload-1"></i>
                {!! videoOrImage(media_or_url($element->thumbnail, 'media/element/thumbnail')) !!}
                <div class="file-name"></div>
            </div>
            
            <p class="mt-3 mb-5 text-xs c-gray">( {{__('Note: Image / Video should not exceed :mb in size.', ['mb' => Elements::config('qrCode', 'config.cover_size.value') .'mb']) }})</p>
        </div>
        <div class="form-input mb-7">
            <label>{{ __('Url For QrCode') }}</label>
            <input type="text" name="url" value="{{ ao($element->content, 'url') }}">
        </div>
        <div class="form-input mb-7">
            <label>{{ __('Caption') }}</label>
            <textarea name="caption">{{ ao($element->content, 'caption') }}</textarea>
        </div>
    </div>
    {!! sandy_upload_modal($element->thumbnail, 'media/element/thumbnail') !!}
</form>
@endsection