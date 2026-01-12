@extends('mix::layouts.master')
@section('title', __('Analytics'))
@section('content')

<div class="mix-padding-10">
    
<div class="dashboard-header-banner relative mb-5">
    <div class="card-container">
        
        <div class="text-lg font-bold">{{ __('Analytics') }}</div>
        <div class="side-cta">
            <img src="{{ gs('assets/image/emoji/Yellow-1/Nerdy.png') }}" alt="">
        </div>
    </div>
</div>
<div class="inner-page-banner hidden">
    <h1 class="font-bold">{{ __('Analytics') }}</h1>
    <p class="text-gray-400 text-xs">{{ __('Get a better understanding of your audience through clear analytics of the total number of clicks, page views, and other insights. ') }}</p>
</div>
<div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
        <div class="insight-card shadow-none">
            <div class="icon">
                <i class="sni sni-moon"></i>
            </div>
            <h2>{{ \App\Models\MySession::activity(10)->hasBio($user->id)->count() }}</h2>
            <h5>{{ __('Live Visits') }}</h5>
            <a href="{{ route('user-mix-analytics-live') }}" class="view href-link-button">{{ __('View Insight') }}</a>
        </div>
        <div class="insight-card shadow-none">
            <div class="icon">
                <i class="sni sni-bar-c"></i>
            </div>
            <h2>{{ ao($linksVisit, 'visits') }}</h2>
            <h5>{{ __('Clicks') }}</h5>
            <a href="{{ route('user-mix-analytics-links') }}" class="view href-link-button">{{ __('View Insight') }}</a>
        </div>
        <div class="insight-card col-span-2 md:col-span-1 shadow-none">
            <div class="icon">
                <i class="sni sni-eye"></i>
            </div>
            <h2>{{ ao($visitors, 'getviews.visits') }}</h2>
            <h5>{{ __('Views') }}</h5>
            <a href="{{ route('user-mix-analytics-views') }}" class="view href-link-button">{{ __('View Insight') }}</a>
        </div>
    </div>
    <div class="p-5 mort-main-bg mt-10 rounded-2xl {{ count($live) > 0 ? '' : 'hidden' }}">
        <div class="bg-white p-3 flex justify-between items-center mb-5 rounded-xl">
            <p class="title m-0 text-sm">{{ __('Live Visitors') }}</p>
            <a class="subtitle text-xs href-link-button auth-link" href="{{ route('user-mix-analytics-live') }}">
                {{ __('View ->') }}
            </a>
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
                        <img src="{{ Country::icon(strtoupper(ao($item->tracking, 'country.iso'))) }}" class="w-full h-full" alt=" ">
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
    <div class="p-5 mort-main-bg mt-10 rounded-2xl">
        <div class="bg-white p-3 flex justify-between items-center mb-5 rounded-xl">
            <p class="title text-sm m-0">{{ __('Top Clicks') }}</p>
            <a class="subtitle text-lg" href="{{ route('user-mix-analytics-links') }}"><i class="sni sni-eye"></i></a>
        </div>
        <div class="flex-table is-insight">
            <!--Table header-->
            <div class="flex-table-header">
                <span class="is-grow">{{ __('Link') }}</span>
                <span>{{ __('Views') }}</span>
                <span></span>
            </div>
            <!--Table item-->

            @foreach ($topLinks as $key => $value)
            <div class="flex-table-item rounded-xl">
                <div class="flex-table-cell is-media is-grow" data-th="">
                    <div>
                        <span class="item-meta text-xs">{{ $key }}</span>
                        <span class="item-meta text-xs break-all">{{ ao($value, 'link') }}</span>
                    </div>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Views') }}">
                    <span class="light-text">{{ ao($value, 'visits') }}</span>
                </div>
                <div class="flex-table-cell text-xs" data-th="{{ __('Action') }}">
                    <a class="text-sticker ml-auto text-xs m-0 flex items-center" href="{{ route('user-mix-analytics-link', $key) }}">{{ __('View insight') }}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</div>
@endsection