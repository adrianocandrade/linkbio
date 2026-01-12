@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-image_album-edit", $element->slug) }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner rounded-2xl">
        {!! Elements::icon('image_album') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('image_album', 'name') }}</h1>
        <p>{{ Elements::config('image_album', 'description') }}</p>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        <div class="form-input mb-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" value="{{ $element->name }}" class="bg-w" name="label">
        </div>
        <div class="form-input">
            <label>{{ __('Description') }}</label>
            <textarea name="content[description]" class="bg-w">{{ ao($element->content, 'description') }}</textarea>
        </div>
        <div class="form-input mt-5">
            <label class="initial">{{ __('Album Type') }}</label>
            <select name="content[type]" class="bg-w">
                <option value="carousel" {{ ao($element->content, 'type') == 'carousel' ? 'selected' : '' }}>{{ __('Carousel') }}</option>
                <option value="grid" {{ ao($element->content, 'type') == 'grid' ? 'selected' : '' }}>{{ __('Grid') }}</option>
            </select>
        </div>
        <div class="mt-4">
            <button class="button white-solid">{{ __('Save') }}</button>
        </div>
    </div>
</form>
<div class="mix-padding-10 md:pt-0">
    
    <div class="mort-main-bg rounded-2xl p-2">
        <div class="bg-white p-5 pb-0 flex flex-col rounded-2xl">
            <div class="text-lg mb-2 font-bold">{{ __('Images') }}</div>
            <p class="mb-4 text-xs italic">{{ __('(Note: reorder images by dragging the card)') }}</p>
            <div class=" sortable" data-delay="150" data-route="{{ route('sandy-app-image_album-sort-images', $element->slug) }}">
                @if (is_array($gallery = ao($element->content, 'images')))
                @foreach ($gallery as $key => $values)
                <div class="mort-main-bg p-3 rounded-2xl flex items-center mb-5 sortable-item" data-id="{{ $values }}">
                    <div class="text-sticker h-full m-0 break-all mr-auto p-3">
                        <div class="h-avatar sm mr-3"><img src="{{ gs('media/element/others', $values) }}"></div> {{ $values }}
                    </div>
                    <form action="{{ route('sandy-app-image_album-delete-images', $element->slug) }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $values }}" name="image">
                        <button class="ml-2 text-sticker flex items-center justify-center m-0 bg-red-500 text-white" data-delete="{{ __('Are you sure you want to delete this file?') }}"><i class="sni sni-trash text-lg"></i></button>
                    </form>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <form class="block mt-4 p-5 pt-0" method="post" action="{{ route('sandy-app-image_album-add-images', $element->slug) }}" enctype="multipart/form-data">
            @csrf
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
            <button class="text-sticker">{{ __('Upload') }}</button>
        </form>
    </div>
</div>
@endsection