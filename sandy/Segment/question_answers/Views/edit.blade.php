@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-question_answers-edit", $element->slug) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner">
        {!! Elements::icon('question_answers') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('question_answers', 'name') }}</h1>
        <p>{{ Elements::config('question_answers', 'description') }}</p>
    </div>
    <div class="p-10">
        <div class="mt-5 mort-main-bg rounded-2xl p-5">
            <div class="sandy-upload-v2 mb-5 border-white sandy-upload-modal-open cursor-pointer" data-generic-preview="">
                <div class="image-con">
                    <div class="image"></div>
                    <div class="file-name"></div>
                </div>
                <div class="info">
                    {{ __('Photo Or Video') }} | {{ Elements::config('question_answers', 'config.cover_size.value') .'mb' }}
                </div>
                <div class="add-button">
                    {{ __('Change') }}
                </div>
            </div>
            <div class="form-input mb-5">
                <label class="initial">{{ __('Element Label') }}</label>
                <input type="text" placeholder="{{ __('Label this element') }}" value="{{ $element->name }}" class="bg-w" name="label">
            </div>
            <div class="form-input mb-5">
                <label>{{ __('Description') }}</label>
                <textarea name="content[description]" class="bg-w">{{ ao($element->content, 'description') }}</textarea>
            </div>
            
            <div class="flex justify-between">
                <div>
                    {{ __('Show Unanswered Questions') }}
                </div>
                
                <label class="sandy-switch">
                    <input type="hidden" name="content[show_unanswered]" value="0">
                    <input class="sandy-switch-input" name="content[show_unanswered]" {{ ao($element->content, 'show_unanswered') ? 'checked' : '' }} value="1" type="checkbox">
                    <span class="sandy-switch-in"><span class="sandy-switch-box is-white"></span></span>
                </label>
            </div>
        </div>
        
        <div class="mt-5 mort-main-bg rounded-2xl p-5">
            <p class="mb-5 text-lg font-bold">{{ __('Price') }}</p>
            <div class="form-input">
                <label class="initial">{{ __('Enable Price') }}</label>
                <select name="content[price][enable]" class="bg-w" data-sandy-select=".select-shift">
                    <option value="enable" {{ ao($element->content, 'price.enable') == 'enable' ? 'selected' : '' }}>{{ __('Enable') }}</option>
                    <option value="disable" {{ ao($element->content, 'price.enable') == 'disable' ? 'selected' : '' }}>{{ __('Disable / Free') }}</option>
                </select>
            </div>
            <div class="select-shift">
                <div class="hide" data-sandy-open="enable">
                    <div class="grid grid-cols-1 gap-4 mt-5">
                        <div class="form-input is-link always-active active bg-white">
                            <label>{{ __('Price') }}</label>
                            <div class="is-link-inner">
                                <div class="side-info">
                                    <p>{!! Currency::symbol(ao($bio->payments, 'currency')) !!}</p>
                                </div>
                                <input type="number" name="content[price][price]" value="{{ ao($element->content, 'price.price') }}" class="bg-w">
                            </div>
                        </div>
                    </div>
                </div>
                <div data-sandy-open="disable" class="hide">
                </div>
            </div>
        </div>
        <button class="button mt-5">{{ __('Save') }}</button>
    </div>


    @php
    $thumbnail = $element->thumbnail;
    $thumbnail['upload'] = gs('media/element/thumbnail', ao($element->thumbnail, 'upload'));
    @endphp
    {!! sandy_upload_modal($thumbnail) !!}
</form>
@endsection