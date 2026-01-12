@extends('mix::layouts.master')
@section('title', __('Live Insight'))
@section('namespace', 'user-mix-analytics-live')
@section('content')
<div class="mix-padding-10">
    
<div class="card customize mb-5">
    <div class="card-header">
        <div class="flex items-center">
            <div class="h-avatar sm is-video bg-white mr-2">
                <i class="flaticon-analytics c-black"></i>
            </div>
            <p class="title m-0">{{ __('Live Visitors') }}</p>
        </div>
    </div>
</div>


<div class="mb-5">
    <div class="p-5 mort-main-bg {{ count($live) > 0 ? '' : 'hidden' }} rounded-2xl">
        <div class="bg-white p-3 flex justify-between items-center mb-5 rounded-xl">
            <p class="title m-0 text-sm">{{ __('Live Visitors') }}</p>
        </div>
        <div class="flex-table is-insight">
            <!--Table header-->
            <div class="flex-table-header">
                <span class="is-grow">{{ __('Location') }}</span>
                <span>{{ __('Os') }}</span>
                <span>{{ __('Browser') }}</span>
            </div>
            <!--Table item-->
            @foreach ($live as $item)
            <div class="flex-table-item rounded-xl">
                <div class="flex-table-cell is-media is-grow" data-th="">
                    <div class="h-avatar sm is-trans">
                        <img src="{{ Country::icon(strtolower(ao($item->tracking, 'country.iso'))) }}" class="w-full h-full" alt=" ">
                    </div>
                    <div>
                        <span class="item-name text-xs">{{ ao($item->tracking, 'country.name') }}</span>
                        <span class="item-meta text-xs">{{ ao($item->tracking, 'country.city') }}</span>
                    </div>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Os') }}">
                    <span class="light-text">{{ ao($item->tracking, 'agent.os') }}</span>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Browser') }}">
                    <span class="tag is-success is-rounded">{{ ao($item->tracking, 'agent.browser') }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


<div class="mort-main-bg mb-10 grid grid-cols-2 gap-4 rounded-2xl p-5">
    <div class="">
        <div class="card customize mb-10">
            <div class="card-header">
                <div class="flex items-center mb-3">
                    <div class="h-avatar sm is-video bg-white mr-2 hidden md:flex">
                        <i class="la la-phone c-black"></i>
                    </div>
                    <p class="title m-0">{{ __('Devices') }} ({{count(ao($visitors, 'devices'))}})</p>
                </div>
                <p class="subtitle">{{ __('Get to know the device os your visitors use.') }}</p>
            </div>
        </div>
        <div>
            @foreach (ao($visitors, 'devices') as $key => $item)
            <div class="flex justify-between items-center bg-white p-5 mb-4 rounded-xl">
                <span class="item-name text-xs">{{ ao($item, 'name') }}</span>
                <span class="tag is-success is-rounded">{{ nr(ao($item, 'unique')) }}</span>
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
                    <p class="title m-0">{{ __('Browsers') }} ({{count(ao($visitors, 'browsers'))}})</p>
                </div>
                <p class="subtitle">{{ __('Get to know the browsers your visitors use.') }}</p>
            </div>
        </div>
        <div>
            @foreach (ao($visitors, 'browsers') as $key => $item)
            <div class="flex justify-between items-center bg-white p-5 mb-4 rounded-xl">
                <span class="item-name text-xs">{{ ao($item, 'name') }}</span>
                <span class="tag is-success is-rounded">{{ nr(ao($item, 'unique')) }}</span>
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
                    <p class="title m-0">{{ __('Countries') }} ({{count(ao($visitors, 'countries'))}})</p>
                </div>
                <p class="subtitle">{{ __('Get to know which country your visitors come from.') }}</p>
            </div>
        </div>
        <div>
            <div class="flex-table is-insight">
                @foreach (ao($visitors, 'countries') as $key => $item)
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
                        <span class="tag is-success is-rounded">{{ nr(ao($item, 'unique')) }}</span>
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
                    <p class="title m-0">{{ __('Cities') }} ({{count(ao($visitors, 'cities'))}})</p>
                </div>
                <p class="subtitle">{{ __('Get to know which city your visitors come from.') }}</p>
            </div>
        </div>
        
        <div>
            <div class="flex-table is-insight">
                @foreach (ao($visitors, 'cities') as $key => $item)
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
                        <span class="tag is-success is-rounded">{{ nr(ao($item, 'unique')) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>
@endsection