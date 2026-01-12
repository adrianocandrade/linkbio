@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-unlock_video-edit", $element->slug) }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner rounded-2xl">
        {!! Elements::icon('unlock_video') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('unlock_video', 'name') }}</h1>
        <p>{{ Elements::config('unlock_video', 'description') }}</p>
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
        
        <div class="form-input mt-3">
            <label class="initial">{{ __('Cover / Background') }}</label>
            <div class="h-avatar h-52 w-full is-upload is-outline-dark text-2xl sandy-upload-modal-open" data-generic-preview="">
                <i class="flaticon-upload-1"></i>
                <input type="file" name="cover">
                {!! videoOrImage(media_or_url($element->thumbnail, 'media/element/thumbnail')) !!}
                
                <div class="file-name"></div>
            </div>
            <p class="mt-3 mb-5 text-xs c-gray">( {{__('Note: Image / Video should not exceed :mb in size.', ['mb' => Elements::config('unlock_video', 'config.image_size.value') .'mb']) }})</p>
        </div>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        <p class="mb-5 text-lg font-bold">{{ __('Price') }}</p>
        
        <div class="form-input mb-5">
            <label class="initial">{{ __('Enable Background Image') }}</label>
            <select name="content[price][type]" class="bg-w" data-sandy-select=".select-shift">
                <option value="fixed" {{ ao($element->content, 'price.type') == 'fixed' ? 'selected' : '' }}>{{ __('Fixed Price') }}</option>
                <option value="customers" {{ ao($element->content, 'price.type') == 'customers' ? 'selected' : '' }}>{{ __('Let customers pay') }}</option>
            </select>
        </div>
        <div class="select-shift">
            <div class="form-input is-link always-active active bg-white hide" data-sandy-open="fixed">
                <label>{{ __('Price') }}</label>
                <div class="is-link-inner">
                    <div class="side-info">
                        <p>{!! Currency::symbol(ao(user('payments', $element->user), 'currency')) !!}</p>
                    </div>
                    <input type="text" name="content[price][price]" value="{{ ao($element->content, 'price.price') }}" class="bg-w">
                </div>
            </div>
            <div data-sandy-open="customers" class="hide">
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
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        <p class="mb-5 text-lg font-bold">{{ __('Video') }}</p>   
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
            @foreach ($video_skel as $key => $value)
            <label class="sandy-big-checkbox">
                <input type="radio" name="content[video][type]" class="sandy-input-inner" data-placeholder-input="#video-link" data-placeholder="{{ ao($value, 'placeholder') }}" {{ $key == 'youtube' ? 'checked' : '' }} value="{{ $key }}" {{ ao($element->content, 'video.type') == $key ? 'checked' : '' }}>
                <div class="checkbox-inner rounded-2xl border-0">
                    <div class="checkbox-wrap">
                        <div class="h-avatar sm is-video" style="background: {{ ao($value, 'color') }}">
                            <i class="{{ ao($value, 'icon') }}"></i>
                            {!! ao($value, 'svg') !!}
                        </div>
                        <div class="content ml-2 flex items-center">
                            <h1>{{ ao($value, 'name') }}</h1>
                        </div>
                        <div class="icon">
                            <div class="active-dot">
                                <i class="la la-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </label>
            @endforeach
        </div>

        <div class="form-input mb-0">
            <label class="initial">{{ __('URL Link') }}</label>
            <input type="text" name="content[video][link]" value="{{ ao($element->content, 'video.link') }}" class="bg-w" id="video-link">
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
@endsection