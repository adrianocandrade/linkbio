@extends('mix::layouts.master')
@section('title', __('New Block'))
@section('content')
<div class="inner-page-banner">
    <h1>{{ __('Blocks') }}</h1>
    <p>{{ __('Select an element to create a new section on your page. Add your content heading, text, images, videos and links then save when you’re done.') }}</p>
    
    @if (search_docs($query = 'Blocks'))
    <a href="{{ search_docs($query) }}" target="_blank" app-sandy-prevent class="mt-10 text-xs c-black font-bold href-link-button">{{ __('Need Help?') }}</a>
    @endif
</div>
<div class="grid grid-cols-2 gap-4 mix-padding-10">
    @foreach (config('blocks') as $key => $value)
    <a class="card-block card card_widget remove-before shadow-bg shadow-bg-l card-inherit mt-0 flex flex-col has-sweet-container" app-sandy-prevent="" href="{{ \Blocks::block_create_route($key) }}">
        <div class="card-container">
            <div class="side-cta">
                @if (ao($value, 'orion'))
                    {!! orion(ao($value, 'orion')) !!}
                @endif
            </div>
            
            <div class="card-title">
                <h3 class="mb-2 font-bold">{{ __(ao($value, "name")) }}</h3>
                <p class="mb-0 text-xs is-info">{{ __(ao($value, "desc")) }}</p>
            </div>
        </div>
    </a>
    @endforeach
    <a class="card-block card card_widget remove-before shadow-bg shadow-bg-l card-inherit mt-0 flex flex-col has-sweet-container" app-sandy-prevent="" href="{{ route('user-mix-shorten') }}">
        <div class="card-container">
            <div class="side-cta">
                {!! orion('security-shield-1') !!}
            </div>
            
            <div class="card-title">
                <h3 class="mb-2 font-bold">{{ __('Shorten Link') }}</h3>
                <p class="mb-0 text-xs is-info">{{ __('Shorten any link & track views with detailed insight.') }}</p>
            </div>
        </div>
    </a>
</div>

<div class="flex justify-between align-end items-center p-8 md:p-14 mt-5 mort-main-bg" id="accelerated-pages">
    <div class="flex align-center">
        <div class="color-primary flex flex-col">
            <span class="font-bold text-lg mb-1">{{ __('Accelerated Pages') }}</span>
            <span class="text-xs text-gray-400">{{ __('Select an element to create a new section on your page. Add your content heading, text, images, videos and links then save when you’re done.') }}</span>
        </div>
    </div>
</div>
<div class="grid grid-cols-2 gap-4 mix-padding-10 relative z-10">
    @foreach (getAllBioApps() as $key => $value)

    <a class="card-block card card_widget remove-before card-inherit p-5 mort-main-bg mt-0 flex flex-col shadow-bg shadow-bg-l" app-sandy-prevent="" href="{{ Route::has("sandy-app-$key-preview") ? route("sandy-app-$key-preview") : route("user-mix-element-preview", $key) }}">
        <div class="mb-3">
            {!! Elements::icon($key) !!}
        </div>
        {!! ao($value, 'extra.html') !!}
        <div class="card-title">
            <h3 class="mb-2 font-bold">{{ ao($value, 'name') }}</h3>
            <p class="mb-0 text-xs">{{ ao($value, 'description') }}</p>
        </div>
    </a>
    @endforeach
</div>
@endsection