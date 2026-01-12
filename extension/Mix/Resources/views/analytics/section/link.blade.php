@extends('mix::layouts.master')
@section('title', __('Link Insight'))
@section('namespace', 'user-mix-analytics-link')
@section('content')
<div class="mix-padding-10">
    <div class="card customize">
        <div class="card-header">
            <div class="flex items-center">
                <div class="h-avatar sm is-video bg-white mr-2">
                    <i class="flaticon-analytics c-black"></i>
                </div>
                <p class="title m-0">{{ __('Link Insight') }}</p>
            </div>
        </div>
    </div>
    <div class="my-5">
        <div class="mort-main-bg insight-split-card rounded-2xl">
            <div class="split-card">
                <div class="heading">{{ __('Unique Views') }}</div>
                <div class="bold-stats">{{ ao($link, 'getviews.unique') }}</div>
                <div class="sub-heading">
                    {{ __('All Time') }}
                </div>
            </div>
            <div class="split-card">
                <div class="heading">{{ __('Views') }}</div>
                <div class="bold-stats">{{ ao($link, 'getviews.visits') }}</div>
                <div class="sub-heading">
                    {{ __('All Time') }}
                </div>
            </div>
        </div>
    </div>
    <div class="rounded-2xl p-5 mort-main-bg mb-10 grid grid-cols-2 gap-4">
        <div class="">
            <div class="card customize mb-10">
                <div class="card-header">
                    <div class="flex items-center mb-3">
                        <div class="h-avatar sm is-video bg-white mr-2 hidden md:flex">
                            <i class="la la-phone c-black"></i>
                        </div>
                        <p class="title m-0">{{ __('Devices') }} ({{count(ao($link, 'devices'))}})</p>
                    </div>
                    <p class="subtitle">{{ __('Get to know the device os your visitors use.') }}</p>
                </div>
            </div>
            <div>
                @foreach (ao($link, 'devices') as $key => $item)
                <div class="flex justify-between items-center rounded-xl bg-white p-5 mb-4">
                    <span class="item-name text-xs">{{ ao($item, 'name') }}</span>
                    <span class="tag is-success is-rounded">{{ nr(ao($item, 'visits')) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="">
            <div class="card customize mb-10">
                <div class="card-header">
                    <div class="flex items-center mb-3">
                        <div class="h-avatar sm is-video bg-white mr-2 hidden md:flex">
                            <i class="sni sni-browser c-black"></i>
                        </div>
                        <p class="title m-0">{{ __('Browsers') }} ({{count(ao($link, 'browsers'))}})</p>
                    </div>
                    <p class="subtitle">{{ __('Get to know the browsers your visitors use.') }}</p>
                </div>
            </div>
            <div>
                @foreach (ao($link, 'browsers') as $key => $item)
                <div class="flex justify-between items-center rounded-xl bg-white p-5 mb-4">
                    <span class="item-name text-xs">{{ ao($item, 'name') }}</span>
                    <span class="tag is-success is-rounded">{{ nr(ao($item, 'visits')) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-span-1">
            
            <div class="card customize mb-10">
                <div class="card-header">
                    <div class="flex items-center mb-3">
                        <div class="h-avatar sm is-video bg-white mr-2 hidden md:flex">
                            <i class="sni sni-flag c-black"></i>
                        </div>
                        <p class="title m-0">{{ __('Countries') }} ({{count(ao($link, 'countries'))}})</p>
                    </div>
                    <p class="subtitle">{{ __('Get to know which country your visitors come from.') }}</p>
                </div>
            </div>
            <div>
                <div class="flex-table is-insight">
                    @foreach (ao($link, 'countries') as $key => $item)
                    <div class="flex-table-item no-shadow bg-white rounded-xl">
                        <div class="flex-table-cell is-media is-grow" data-th="">
                            <div class="h-avatar sm is-trans">
                                <img src="{{ Country::icon($key) }}" class="w-full h-full" alt=" ">
                            </div>
                            <div>
                                <span class="item-name text-xs">{{ ao($item, 'name') }}</span>
                                <span class="item-meta text-xs">{{ $key }}</span>
                            </div>
                        </div>
                        <div class="flex-table-cell p-0 justify-end" data-th="{{ __('Views') }}">
                            <span class="tag is-success is-rounded">{{ nr(ao($item, 'visits')) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-span-1">
            <div class="card customize mb-10">
                <div class="card-header">
                    <div class="flex items-center mb-3">
                        <div class="h-avatar sm is-video bg-white mr-2 hidden md:flex">
                            <i class="sni sni-flag c-black"></i>
                        </div>
                        <p class="title m-0">{{ __('Cities') }} ({{count(ao($link, 'cities'))}})</p>
                    </div>
                    <p class="subtitle">{{ __('Get to know which city your visitors come from.') }}</p>
                </div>
            </div>
            
            <div>
                <div class="flex-table is-insight">
                    @foreach (ao($link, 'cities') as $key => $item)
                    <div class="flex-table-item no-shadow bg-white rounded-xl">
                        <div class="flex-table-cell is-media is-grow" data-th="">
                            <div class="h-avatar sm is-trans">
                                <img src="{{ Country::icon(ao($item, 'iso')) }}" class="w-full h-full" alt=" ">
                            </div>
                            <div>
                                <span class="item-name text-xs">{{ $key }}</span>
                                <span class="item-meta text-xs">{{ ao($item, 'iso') }}</span>
                            </div>
                        </div>
                        <div class="flex-table-cell p-0 justify-end" data-th="{{ __('Views') }}">
                            <span class="tag is-success is-rounded">{{ nr(ao($item, 'visits')) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection