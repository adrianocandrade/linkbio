@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-skillbar-create") }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner rounded-2xl">
        {!! Elements::icon('skillbar') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('skillbar', 'name') }}</h1>
        <p>{{ Elements::config('skillbar', 'description') }}</p>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        
        <div class="form-input mb-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" class="bg-w" name="label">
        </div>
        <div class="form-input mb-7">
            <label>{{ __('Description') }}</label>
            <textarea name="content[description]" class="bg-w"></textarea>
        </div>
        <div class="mort-main-bg p-0 rounded-2xl">
            <div data-dynamic-wrapper>
                
            </div>
        </div>
        
        <a href="#" class="text-sticker m-0 mt-4" data-dynamic-add>{{ __('Add Skill') }}</a>
        
        <div class="mt-4">
            <button class="button white-solid">{{ __('Save') }}</button>
        </div>
    </div>
</form>
<div data-dynamic-template hidden>
    <div class="mb-5" data-dynamic-item="" data-items-name="skills">
        <div class="flex bg-white rounded-2xl p-5">
            <div class="flex">
                <div class="form-input w-full mr-4">
                    <label class="initial">{{ __('Name') }}</label>
                    <input type="text" data-item-name="name">
                </div>
                <div class="form-input w-full mr-4">
                    <label class="initial">{{ __('Skill Bar') }}</label>
                    <input type="number" data-item-name="skill">
                </div>
            </div>
            <a class="ml-auto flex items-center cursor-pointer" data-dynamic-remove><i class="flaticon-delete"></i></a>
        </div>
    </div>
</div>
@endsection