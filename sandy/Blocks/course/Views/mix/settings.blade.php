@extends('mix::layouts.master')
@section('title', __('Course Settings'))
@section('content')
@includeIf('include.back-header', ['route' => route('sandy-blocks-course-mix-dashboard')])
<div class="mix-padding-10">
    <div class="mb-5 rounded-2xl flex justify-between align-end items-center p-8 md:p-14 mort-main-bg">
        <div class="flex align-center">
            <div class="color-primary flex flex-col">
                <span class="font-bold text-lg mb-1">{{ __('Catalog Settings') }}</span>
                <span class="text-xs text-gray-400">{{ __('Setup your course landing by adding your course catalog name & description.') }}</span>
            </div>
        </div>
    </div>
    <form action="{{ route('sandy-blocks-course-mix-settings-post') }}" method="post">
        @csrf
        <div class="mort-main-bg rounded-2xl p-5 mb-5">
            <div class="form-input mb-5">
                <label>{{ __('Catalog Name') }}</label>
                <input type="text" class="bg-w" name="course[name]" value="{{ user('settings.course.name') }}">
            </div>
            <div class="form-input">
                <label>{{ __('Catalog Description') }}</label>
                <textarea name="course[description]" class="bg-w" cols="30" rows="10">{{ user('settings.course.description') }}</textarea>
            </div>
            <button class="text-sticker mt-5">{{ __('Save') }}</button>
        </div>
    </form>
</div>
@endsection