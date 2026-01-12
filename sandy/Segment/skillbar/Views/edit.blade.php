@extends('mix::layouts.master')
@section('content')
<form action="{{ route("sandy-app-skillbar-edit", $element->slug) }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="inner-page-banner rounded-2xl">
        {!! Elements::icon('skillbar') !!}
        <h1 class="mt-5 text-base">{{ Elements::config('skillbar', 'name') }}</h1>
        <p>{{ Elements::config('skillbar', 'description') }}</p>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5 mb-7">
        
        <div class="form-input mb-5">
            <label class="initial">{{ __('Element Label') }}</label>
            <input type="text" placeholder="{{ __('Label this element') }}" value="{{ $element->name }}" class="bg-w" name="label">
        </div>
        <div class="form-input">
            <label>{{ __('Description') }}</label>
            <textarea name="content[description]" class="bg-w">{{ ao($element->content, 'description') }}</textarea>
        </div>
    </div>
    <div class="mort-main-bg p-0 rounded-2xl p-5">
        <div data-dynamic-wrapper>
            @if (is_array($skills = ao($element->content, 'skills')))
                @php
                    $i = 0;
                @endphp
                @foreach ($skills as $key => $values)
                <div class="mb-5" data-dynamic-item="">
                    <div class="flex bg-white rounded-2xl p-5">
                        <div class="flex">
                            <div class="form-input w-full mr-4">
                                <label class="initial">{{ __('Name') }}</label>
                                <input type="text" value="{{ ao($values, 'name') }}" name="skills[{{ $key }}][name]">
                            </div>
                            <div class="form-input w-full mr-4">
                                <label class="initial">{{ __('Skill Bar') }}</label>
                                <input type="number" value="{{ ao($values, 'skill') }}" name="skills[{{ $key }}][skill]">
                            </div>
                        </div>
                        <a class="ml-auto flex items-center cursor-pointer" data-dynamic-remove=""><i class="flaticon-delete"></i></a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        
        <a href="#" class="text-sticker m-0 mt-4" data-dynamic-add>{{ __('Add Skill') }}</a>
    </div>
    
    <div class="mt-4">
        <button class="button">{{ __('Save') }}</button>
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