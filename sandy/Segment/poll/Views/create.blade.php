@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-poll-create") }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner rounded-2xl">
        {!! Elements::icon('poll') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('poll', 'name') }}</h1>
        <p>{{ Elements::config('poll', 'description') }}</p>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        
        <div class="form-input mb-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" class="bg-w" name="label">
        </div>
        <div class="form-input mb-7">
            <label>{{ __('Question') }}</label>
            <textarea name="content[question]" class="bg-w"></textarea>
        </div>
        <div class="bg-white p-5 rounded-2xl">
            <div data-dynamic-wrapper>
                
            </div>
            <a href="#" class="text-sticker m-0" data-dynamic-add>{{ __('Add Choices') }}</a>
        </div>
        
        <div class="mt-4">
            <button class="button white-solid">{{ __('Save') }}</button>
        </div>
    </div>
</form>
<div data-dynamic-template hidden>
    <div class="mb-5" data-dynamic-item="" data-items-name="choices">
        <div class="flex">
            
            <div class="form-input w-full mr-4">
                <label class="">{{ __('Choice') }}</label>
                <input type="text" data-item-name="choice">
            </div>
            <a class="ml-auto flex items-center cursor-pointer" data-dynamic-remove><i class="flaticon-delete"></i></a>
        </div>
    </div>
</div>
@endsection