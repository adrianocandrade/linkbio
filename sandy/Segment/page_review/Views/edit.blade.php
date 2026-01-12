@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-page_review-edit", $element->slug) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner">
        {!! Elements::icon('page_review') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('page_review', 'name') }}</h1>
        <p>{{ Elements::config('page_review', 'description') }}</p>
        <div class="form-input mt-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" value="{{ $element->name }}" class="bg-w" name="label">
        </div>
    </div>
    <div class="p-10">
        <div class="mort-main-bg mix-padding-10 rounded-2xl">
            
            <div class="form-input mb-5">
                <label class="initial">{{ __('Auto accept reviews') }}</label>
                <select name="content[auto_accept]" class="bg-w">
                    <option value="1" {{ ao($element->content, 'auto_accept') ? 'selected' : '' }}>{{ __('Yes') }}</option>
                    <option value="0" {{ !ao($element->content, 'auto_accept') ? 'selected' : '' }}>{{ __('No') }}</option>
                </select>
            </div>
            
            <div class="form-input mb-5">
                <label class="initial">{{ __('Enable rating') }}</label>
                <select name="content[enable_rating]" class="bg-w">
                    <option value="1" {{ ao($element->content, 'enable_rating') ? 'selected' : '' }}>{{ __('Yes') }}</option>
                    <option value="0" {{ !ao($element->content, 'enable_rating') ? 'selected' : '' }}>{{ __('No') }}</option>
                </select>
            </div>
            
            <div class="form-input mb-7">
                <label>{{ __('Caption') }}</label>
                <textarea name="content[caption]" class="bg-w">{{ ao($element->content, 'caption') }}</textarea>
            </div>
            <div class="mt-4">
                <button class="button is-loader-submit black flex items-center">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</form>
@endsection