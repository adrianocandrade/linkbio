@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-link_locker-create") }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner">
        {!! Elements::icon('link_locker') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('link_locker', 'name') }}</h1>
        <p>{{ Elements::config('link_locker', 'description') }}</p>
        <div class="form-input mt-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" class="bg-w" name="label">
        </div>
        <div class="mt-4">
            <button class="text-sticker is-loader-submit black flex items-center">{{ __('Save') }}</button>
        </div>
    </div>
    <div class="p-10">
        
        <div class="form-input mb-7">
            <label>{{ __('Description') }}</label>
            <textarea name="content[description]"></textarea>
        </div>
        <div class="form-input mb-2">
            <label>{{ __('URL Link') }}</label>
            <input type="text" name="content[link]">
        </div>
        <p class="text-xs italic mb-7">{{ __('Your visitors will get access to this link after purchase.') }}</p>
        <div class="form-input is-link mb-7 always-active active">
            <label>{{ __('Price') }}</label>
            <div class="is-link-inner">
                <div class="side-info">
                    <p>{!! Currency::symbol(ao($user->payments, 'currency')) !!}</p>
                </div>
                <input type="text" name="content[price]">
            </div>
        </div>
        <div class="form-input">
            <label class="initial">{{ __('Cover / Background') }}</label>
            <div class="h-avatar h-40 w-40 is-upload is-outline-dark text-2xl sandy-upload-modal-open" data-generic-preview="">
                <i class="flaticon-upload-1"></i>
                <input type="file" name="cover">
                <div class="image"></div>
                <div class="file-name"></div>
            </div>
            <p class="mt-0 mb-5 italic underline text-xs c-gray">( {{__('Note: Image / Video should not exceed :mb in size.', ['mb' => Elements::config('link_locker', 'config.cover_size.value') .'mb']) }})</p>
        </div>
    </div>

    {!! sandy_upload_modal() !!}
</form>
@endsection