@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-embed_links-create") }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner rounded-2xl">
        {!! Elements::icon('embed_links') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('embed_links', 'name') }}</h1>
        <p>{{ Elements::config('embed_links', 'description') }}</p>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
            @foreach ($skeleton as $key => $value)
            <label class="sandy-big-checkbox">
                <input type="radio" name="content[type]" class="sandy-input-inner" data-placeholder-input="#video-link" data-placeholder="{{ ao($value, 'placeholder') }}" {{ $key == 'youtube' ? 'checked' : '' }} value="{{ $key }}">
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
        <div class="form-input mb-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" class="bg-w" name="label">
        </div>
        <div class="form-input mb-2">
            <label class="initial">{{ __('URL Link') }}</label>
            <input type="text" name="content[link]" class="bg-w" id="video-link">
        </div>
        <p class="text-xs italic">{{ __('(Note: this link will be shown in an iframe. Not all url are supported.)') }}</p>
        <div class="mt-4">
            <button class="button">{{ __('Save') }}</button>
        </div>
    </div>
</form>
@endsection