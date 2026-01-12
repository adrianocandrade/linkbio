@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-unlock_image-create") }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner rounded-2xl">
        {!! Elements::icon('unlock_image') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('unlock_image', 'name') }}</h1>
        <p>{{ Elements::config('unlock_image', 'description') }}</p>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        
        <div class="form-input mb-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" class="bg-w" name="label">
        </div>
        <div class="form-input is-link mb-7 always-active active bg-white">
            <label>{{ __('Price') }}</label>
            <div class="is-link-inner">
                <div class="side-info">
                    <p>{!! Currency::symbol(ao($user->payments, 'currency')) !!}</p>
                </div>
                <input type="text" name="content[price]" class="bg-w">
            </div>
        </div>
        <div class="form-input mb-7">
            <label>{{ __('Description') }}</label>
            <textarea name="content[description]" class="bg-w"></textarea>
        </div>
        <div class="form-input block">
            <div class="flex">
                
                <div class="text-sticker sandy-upload-modal-open p-2 h-full flex items-center mb-4 cursor-pointer">
                    <div class="h-avatar sm">
                        <div class="lozad image"></div>
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
    {!! sandy_upload_modal() !!}
</form>
@endsection