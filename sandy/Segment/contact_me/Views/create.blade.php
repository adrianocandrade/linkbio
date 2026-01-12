@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-contact_me-create") }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner rounded-2xl">
        {!! Elements::icon('contact_me') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('contact_me', 'name') }}</h1>
        <p>{{ Elements::config('contact_me', 'description') }}</p>
        <div class="form-input mt-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" class="bg-w" name="label">
        </div>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        <div class="form-input">
            <label>{{ __('Description') }}</label>
            <textarea name="content[description]" class="bg-w"></textarea>
        </div>
        <div class="mt-4">
            <button class="button white-solid">{{ __('Save') }}</button>
        </div>
    </div>
</form>
@endsection