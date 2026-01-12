@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-image_album-create") }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner rounded-2xl">
        {!! Elements::icon('image_album') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('image_album', 'name') }}</h1>
        <p>{{ Elements::config('image_album', 'description') }}</p>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        <div class="form-input mb-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" class="bg-w" name="label">
        </div>
        <div class="form-input">
            <label>{{ __('Description') }}</label>
            <textarea name="content[description]" class="bg-w"></textarea>
        </div>
        <div class="form-input mt-5">
            <label class="initial">{{ __('Album Type') }}</label>
            <select name="content[type]" class="bg-w">
                <option value="carousel">{{ __('Carousel') }}</option>
                <option value="grid">{{ __('Grid') }}</option>
            </select>
        </div>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        <div class="block">
            <div class="flex">
                
                <label class="text-sticker p-2 h-full flex items-center mb-4 cursor-pointer" data-generic-preview="" for="input-files">
                    <div class="h-avatar sm is-upload">
                        <div class="lozad image"></div>
                        <input type="file" name="image_album" id="input-files" accept="image/*">
                    </div>
                    <p class="ml-2 file-name break-all">{{ __('Select files to be unlocked') }}</p>
                </label>
            </div>
            <p class="mt-0 mb-5 italic text-xs c-gray">( {{__('Note: Image should not exceed :mb in size. Supported formats are : :formats', ['mb' => Elements::config('image_album', 'config.file_size.value') .'mb', 'formats' => Elements::config('image_album', 'config.file_size.formats')]) }})</p>
        </div>
        <div class="mt-4">
            <button class="button white-solid">{{ __('Save') }}</button>
        </div>
    </div>
</form>
@endsection