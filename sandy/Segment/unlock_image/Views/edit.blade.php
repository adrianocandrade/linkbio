@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-unlock_image-edit", $element->slug) }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner rounded-2xl">
        {!! Elements::icon('unlock_image') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('unlock_image', 'name') }}</h1>
        <p>{{ Elements::config('unlock_image', 'description') }}</p>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        
        <div class="form-input mb-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" class="bg-w" name="label" value="{{ $element->name }}">
        </div>
        <div class="form-input is-link mb-7 always-active active bg-white">
            <label>{{ __('Price') }}</label>
            <div class="is-link-inner">
                <div class="side-info">
                    <p>{!! Currency::symbol(ao(user('payments', $element->user), 'currency')) !!}</p>
                </div>
                <input type="text" name="content[price]" class="bg-w" value="{{ ao($element->content, 'price') }}">
            </div>
        </div>
        <div class="form-input mb-7">
            <label>{{ __('Description') }}</label>
            <textarea name="content[description]" class="bg-w">{{ ao($element->content, 'description') }}</textarea>
        </div>
        <div class="form-input block">
            <div class="flex">
                
                <div class="text-sticker sandy-upload-modal-open p-2 h-full flex items-center mb-4 cursor-pointer">
                    <div class="h-avatar sm">
                        {!! videoOrImage(media_or_url($element->thumbnail, 'media/element/thumbnail')) !!}
                    </div>
                    <p class="ml-2">{{ __('Select an image to be unlocked') }}</p>
                </div>
            </div>
            <p class="mt-0 mb-5 italic underline text-xs c-gray">( {{__('Note: Image should not exceed :mb in size.', ['mb' => Elements::config('unlock_image', 'config.image_size.value') .'mb']) }})</p>
        </div>
        <p class="text-xs italic mb-7">{{ __('Your visitors will get access to this image after purchase.') }}</p>
        <div class="mt-4">
            <button class="button white-solid">{{ __('Save') }}</button>
        </div>
    </div>
    @php
    $thumbnail = $element->thumbnail;
    $thumbnail['upload'] = gs('media/element/thumbnail', ao($element->thumbnail, 'upload'));
    @endphp
    {!! sandy_upload_modal($thumbnail) !!}
</form>
@endsection