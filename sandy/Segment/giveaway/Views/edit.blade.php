@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-giveaway-edit", $element->slug) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner">

        <div class="h-avatar md">
            {!! media_or_url($element->thumbnail, 'media/element/thumbnail', true) !!}
        </div>
        <h1 class="mt-5 text-base">{{ Elements::config('giveaway', 'name') }}</h1>
        <p>{{ Elements::config('giveaway', 'description') }}</p>
        <div class="form-input mt-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" class="bg-w" name="label" value="{{ $element->name }}">
        </div>
        <div class="mt-4">
            <button class="text-sticker">{{ __('Save') }}</button>
        </div>
    </div>
    <div class="p-10">
        <div class="form-input">
            
            <label class="initial">{{ __('Cover / Background') }}</label>
            <div class="h-avatar h-40 w-40 is-upload is-outline-dark text-2xl sandy-upload-modal-open" data-generic-preview="">
                <i class="flaticon-upload-1"></i>

                {!! media_or_url($element->thumbnail, 'media/element/thumbnail', true) !!}
                <div class="file-name"></div>
            </div>

            
            
            <p class="mt-3 mb-5 text-xs c-gray">( {{__('Note: Image / Video should not exceed :mb in size.', ['mb' => Elements::config('giveaway', 'config.cover_size.value') .'mb']) }})</p>
        </div>


      <div class="grid sm:grid-cols-2 md:grid-cols-2 gap-4 mb-10">
        @foreach ($skeleton as $key => $value)
        <label class="sandy-big-checkbox">
          <input type="hidden" name="settings[{{$key}}]" value="0">
          <input type="checkbox" name="settings[{{$key}}]" class="sandy-input-inner" {{ ao($element->content, "$key") ? 'checked' : '' }} value="1">
          <div class="checkbox-inner">
            <div class="checkbox-wrap">
              <div class="content">
                <h1>{{ __(ao($value, 'name')) }}</h1>
                <p>{{ __(ao($value, 'description')) }}</p>
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


        <div class="form-input mb-7">
            <label>{{ __('Description') }}</label>
            <textarea name="caption" rows="7">{{ ao($element->content, 'caption') }}</textarea>
        </div>
    </div>
    {!! sandy_upload_modal($element->thumbnail, 'media/element/thumbnail') !!}
</form>
@endsection