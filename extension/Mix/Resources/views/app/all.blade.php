@extends('mix::layouts.master')
@section('title', __('Apps'))
@section('namespace', 'user-mix-apps')
@section('content')
    
<div class="mix-padding-10">
    
    <div class="dashboard-header-banner relative mt-0 mb-5">
        <div class="card-container">

            <div class="text-lg font-bold">{{ __('Available Elements') }} ({{ count($apps) }})</div>

            <div class="side-cta top-8">
                {!! orion('thunder-1', 'h-20') !!}
            </div>
        </div>
    </div>
    <div class="inner-page-banner hidden">
        <div class="flex items-center mb-3">
            <div class="mr-3">
                <i class="sni sni-spark c-black"></i>
            </div>
            <h1 class="mb-0 title text-lg">{{ __('Available Elements') }} ({{ count($apps) }})</h1>
        </div>
        <form>
            <div class="search__form shadow-none w-full">
                <input class="search__input" type="text" name="query" value="{{ request()->get('query') }}" placeholder="{{ __('Type your search word') }}">
                <button class="search__btn text-2xl">
                <i class="sio maps-and-navigation-047-global-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="p-0 mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach ($apps as $key => $value)
        
        <div class="card p-5 rounded-2xl mb-7 block has-sweet-container border-4 border-solid hidden">
            <div class="card-container bg-repeat-right">


                <div class="icon ">
                    {!! Elements::icon($key) !!}
                </div>
                <div class="mt-5 text-2xl font-bold">{{ __(ao($value, 'name')) }}</div>
                <div class="my-2 text-xs is-info w-44">{{ __(ao($value, 'description')) }}</div>

                <a app-sandy-prevent="" href="{{ Route::has("sandy-app-$key-preview") ? route("sandy-app-$key-preview") : route("user-mix-element-preview", $key) }}" class="sandy-expandable-btn px-10"><span>{{ __('View') }}</span></a>
            </div>
        </div>
        <div class="app-tile">
            <div class="app-tile-box rounded-2xl" style="--elem-color: {{ ao($value, 'thumbnail.background') }};">
                @if (ao($value, 'thumbnail.type') == 'icon')
                <div class="thumbnail h-avatar is-elem md is-video" style="background: {{ ao($value, 'thumbnail.background') }}; color: {{ ao($value, 'thumbnail.i-color') }}">
                    <i class="{{ ao($value, 'thumbnail.thumbnail') }}"></i>
                </div>
                @endif
                <div class="content z-50 relative">
                    <div>
                        <span class="name">
                            {{ $value['name'] ?? '' }}
                        </span>
                        <span class="description">
                            {{ $value['description'] ?? '' }}
                        </span>
                        <div class="flex">
                            <a href="{{ Route::has("sandy-app-$key-preview") ? route("sandy-app-$key-preview") : route("user-mix-element-preview", $key) }}" class="action-a ml-0 md:ml-auto text-sticker flex items-center shadow-none">
                                {{ __('View') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection