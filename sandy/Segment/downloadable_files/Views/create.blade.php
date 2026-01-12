@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-downloadable_files-create") }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        
        <div class="form-input">
            <label class="initial">{{ __('Cover / Background') }}</label>
            <div class="h-avatar h-52 w-full is-upload is-outline-dark text-2xl sandy-upload-modal-open" data-generic-preview="">
                <i class="flaticon-upload-1"></i>
                <input type="file" name="cover">
                <div class="image"></div>
                <div class="file-name"></div>
            </div>
            <p class="mt-0 mb-5 italic underline text-xs c-gray">( {{__('Note: Image / Video should not exceed :mb in size.', ['mb' => Elements::config('downloadable_files', 'config.image_size.value') .'mb']) }})</p>
        </div>
        <div class="form-input mb-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" class="bg-w" name="label">
        </div>
        <div class="form-input">
            <label>{{ __('Description') }}</label>
            <textarea name="content[description]" class="bg-w"></textarea>
        </div>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        
        <div class="form-input mb-5">
            <label class="initial">{{ __('Enable Background Image') }}</label>
            <select name="content[price][type]" class="bg-w" data-sandy-select=".select-shift">
                <option value="1">{{ __('Fixed Price') }}</option>
                <option value="0">{{ __('Let customers pay') }}</option>
            </select>
        </div>
        <div class="select-shift">
            <div class="form-input is-link always-active active bg-white hide" data-sandy-open="1">
                <label>{{ __('Price') }}</label>
                <div class="is-link-inner">
                    <div class="side-info">
                        <p>{!! Currency::symbol(ao($user->payments, 'currency')) !!}</p>
                    </div>
                    <input type="text" name="content[price][price]" class="bg-w">
                </div>
            </div>
            <div data-sandy-open="0" class="hide">
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-input is-link always-active active bg-white">
                        <label>{{ __('Min Price') }}</label>
                        <div class="is-link-inner">
                            <div class="side-info">
                                <p>{!! Currency::symbol(ao($user->payments, 'currency')) !!}</p>
                            </div>
                            <input type="text" name="content[price][min_price]" value="1" class="bg-w">
                        </div>
                    </div>
                    <div class="form-input is-link always-active active bg-white">
                        <label>{{ __('Suggest Price') }}</label>
                        <div class="is-link-inner">
                            <div class="side-info">
                                <p>{!! Currency::symbol(ao($user->payments, 'currency')) !!}</p>
                            </div>
                            <input type="text" name="content[price][suggest_price]" value="2" class="bg-w">
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        <div class="block">
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
        </div>
        <p class="text-xs italic mb-7">{{ __('Your visitors will get access to these files after purchase.') }}</p>
        <div class="mt-4">
            <button class="button white-solid">{{ __('Save') }}</button>
        </div>
    </div>
    {!! sandy_upload_modal() !!}
</form>
@endsection