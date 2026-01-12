@extends('mix::layouts.master')
@section('content')
<div class="inner-page-banner">
    {!! Elements::icon('tipJar') !!}
    <h1 class="mt-5 text-base">{{ Elements::config('tipJar', 'name') }}</h1>
    <p>{{ Elements::config('tipJar', 'description') }}</p>
    @if (Route::has("sandy-app-$element->element-delete"))
    <form action="{{ route("sandy-app-$element->element-delete", $element->slug) }}" method="post">
        @csrf
        <button data-delete="{{ __('Are you sure you want to delete this element?') }}" class="button mt-4 bg-red-400 text-white w-full">{{ __('Delete') }}</button>
    </form>
    @endif
</div>

<form action="{{ route("sandy-app-tipJar-edit", $element->slug) }}" method="post" enctype="multipart/form-data">
    @csrf
    
    <div class="mix-padding-10">
        <div class="mort-main-bg p-5 rounded-2xl">
            <div class="form-input mb-5">
                <label class="initial">{{ __('Title') }}</label>
                <input type="text" placeholder="{{ __('Leave a Tip') }}" class="bg-w" value="{{ $element->name }}" name="label">
            </div>
            <div class="form-input mb-7">
                <label>{{ __('Description') }}</label>
                <textarea name="content[description]" class="bg-w">{{ ao($element->content, 'description') }}</textarea>
            </div>
            <div class="card-header mb-5 p-5 rounded-2xl bg-white flex justify-between">
                <div>
                    <p class="title mb-0">{{ __('Enable recurring prices.') }}</p>
                    <p class="text-sm font-bold">{{ __('Only available if your current payment method supports recurring.') }}</p>
                </div>
                <label class="sandy-switch">
                    <input type="hidden" name="content[recurring]" value="0">
                    <input class="sandy-switch-input" name="content[recurring]" {{ ao($element->content, 'recurring') ? 'checked' : '' }} value="1" type="checkbox">
                    <span class="sandy-switch-in"><span class="sandy-switch-box"></span></span>
                </label>
            </div>
            <div class="text-gray-400 text-sm mb-5">{{ __('Suggested Amount(s)') }}</div>
            <div data-dynamic-wrapper>

                @if (is_array(ao($element->content, 'amounts')))

                    @foreach (ao($element->content, 'amounts') as $key => $item)
                        <div class="mb-5" data-dynamic-item="" data-items-name="amounts">
                            <div class="flex">
                                <div class="form-input w-full mr-4">
                                    <label class="">{{ __('Amount') }}</label>
                                    <input type="text" class="bg-w" data-item-name="price" value="{{ ao($item, 'price') }}">
                                </div>
                                <a class="ml-auto flex items-center cursor-pointer" data-dynamic-remove=""><i class="flaticon-delete"></i></a>
                            </div>
                        </div>
                    @endforeach
                @endif

                
            </div>
            <a href="#" class="button mt-5 w-full m-0 bg-gray-200" data-dynamic-add>{{ __('Add Amount') }}</a>
        </div>
        <button class="mt-5 button w-full">{{ __('Save') }}</button>
    </div>
</form>
<div data-dynamic-template hidden>
    <div class="mb-5" data-dynamic-item="" data-items-name="amounts">
        <div class="flex">
            
            <div class="form-input w-full mr-4">
                <label class="">{{ __('Amount') }}</label>
                <input type="text" class="bg-w" data-item-name="price">
            </div>
            <a class="ml-auto flex items-center cursor-pointer" data-dynamic-remove><i class="flaticon-delete"></i></a>
        </div>
    </div>
</div>
@endsection