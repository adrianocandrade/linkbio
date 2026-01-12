@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-downloadable_files-edit", $element->slug) }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        
        <div class="form-input">
            <label class="initial">{{ __('Cover / Background') }}</label>
            <div class="h-avatar h-52 w-full is-upload is-outline-dark text-2xl sandy-upload-modal-open" data-generic-preview="">
                <i class="flaticon-upload-1"></i>
                <input type="file" name="cover">
                {!! videoOrImage(media_or_url($element->thumbnail, 'media/element/thumbnail')) !!}
                
                <div class="file-name"></div>
            </div>
            <p class="mt-0 mb-5 italic underline text-xs c-gray">( {{__('Note: Image / Video should not exceed :mb in size.', ['mb' => Elements::config('downloadable_files', 'config.image_size.value') .'mb']) }})</p>
        </div>
        <div class="form-input mb-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" value="{{ $element->name }}" class="bg-w" name="label">
        </div>
        <div class="form-input">
            <label>{{ __('Description') }}</label>
            <textarea name="content[description]" class="bg-w">{{ ao($element->content, 'description') }}</textarea>
        </div>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        
        <div class="form-input mb-5">
            <label class="initial">{{ __('Enable Background Image') }}</label>
            <select name="content[price][type]" class="bg-w" data-sandy-select=".select-shift">
                <option value="1" {{ ao($element->content, 'price.type') ? 'selected' : '' }}>{{ __('Fixed Price') }}</option>
                <option value="0" {{ !ao($element->content, 'price.type') ? 'selected' : '' }}>{{ __('Let customers pay') }}</option>
            </select>
        </div>
        <div class="select-shift">
            <div class="form-input is-link always-active active bg-white hide" data-sandy-open="1">
                <label>{{ __('Price') }}</label>
                <div class="is-link-inner">
                    <div class="side-info">
                        <p>{!! Currency::symbol(ao(user('payments', $element->user), 'currency')) !!}</p>
                    </div>
                    <input type="text" name="content[price][price]" value="{{ ao($element->content, 'price.price') }}" class="bg-w">
                </div>
            </div>
            <div data-sandy-open="0" class="hide">
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-input is-link always-active active bg-white">
                        <label>{{ __('Min Price') }}</label>
                        <div class="is-link-inner">
                            <div class="side-info">
                                <p>{!! Currency::symbol(ao(user('payments', $element->user), 'currency')) !!}</p>
                            </div>
                            <input type="text" name="content[price][min_price]" value="{{ ao($element->content, 'price.min_price') }}" class="bg-w">
                        </div>
                    </div>
                    <div class="form-input is-link always-active active bg-white">
                        <label>{{ __('Suggest Price') }}</label>
                        <div class="is-link-inner">
                            <div class="side-info">
                                <p>{!! Currency::symbol(ao(user('payments', $element->user), 'currency')) !!}</p>
                            </div>
                            <input type="text" name="content[price][suggest_price]" value="{{ ao($element->content, 'price.suggest_price') }}" class="bg-w">
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
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
<div class="mix-padding-10 md:pt-0">
    
    <div class="mort-main-bg rounded-2xl p-5">
        <div class="bg-white p-5 pb-0 flex flex-col rounded-2xl">
            <div class="text-lg mb-4 font-bold">{{ __('Files') }}</div>
            @if (is_array($downloadables = ao($element->content, 'downloadables')))
            @foreach ($downloadables as $key => $values)
            <div class="mort-main-bg p-3 rounded-2xl flex items-center mb-5">
                <div class="text-sticker h-full m-0 break-all mr-auto">{{ $values }}</div>
                <form action="{{ route('sandy-app-downloadable_files-delete-downloadables', $element->slug) }}" method="POST">
                    @csrf

                    <input type="hidden" value="{{ $values }}" name="downloadable">
                    <button class="ml-2 text-sticker flex items-center justify-center m-0 bg-red-500 text-white" data-delete="{{ __('Are you sure you want to delete this file?') }}"><i class="sni sni-trash text-lg"></i></button>
                </form>
            </div>
            @endforeach
            @endif
        </div>
        <form class="block mt-4" method="post" action="{{ route('sandy-app-downloadable_files-add-downloadables', $element->slug) }}" enctype="multipart/form-data">
            @csrf
            <div class="flex">
                
                <label class="text-sticker p-2 h-full flex items-center mb-4 cursor-pointer" data-generic-preview="" for="input-files">
                    <div class="h-avatar sm is-upload">
                        <div class="lozad image"></div>
                        <input type="file" name="downloadable_files" id="input-files">
                    </div>
                    <p class="ml-2 file-name break-all">{{ __('Select files to be unlocked') }}</p>
                </label>
            </div>
            <p class="mt-0 mb-5 italic text-xs c-gray">( {{__('Note: Image should not exceed :mb in size. Supported formats are : :formats', ['mb' => Elements::config('downloadable_files', 'config.file_size.value') .'mb', 'formats' => Elements::config('downloadable_files', 'config.file_size.formats')]) }})</p>
            <p class="text-xs italic mb-0">{{ __('Your visitors will get access to these files after purchase.') }}</p>
            <button class="text-sticker">{{ __('Upload') }}</button>
        </form>
    </div>
</div>
@endsection