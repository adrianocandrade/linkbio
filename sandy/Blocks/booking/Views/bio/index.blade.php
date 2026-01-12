@extends('bio::layouts.master')
@section('content')
@section('head')

<style>
    .bio-menu{
        display: none !important;
    }
    #zuck-modal #zuck-modal-content .story-viewer .slides .item > .media{
        object-fit: contain !important;
    }

    #zuck-modal #zuck-modal-content .story-viewer .head .left .time{
        display: none !important;
    }
</style>
@stop

@php

    $timeClass = (new \Sandy\Blocks\booking\Helper\Time($bio->id));
    $date = \Carbon\Carbon::now();
    $day_id = (new \Sandy\Blocks\booking\Helper\Time)->get_day_id(date('l', strtotime($date->format('Y-m-d'))));


    $start_time = $timeClass->format_minutes(ao($bio->booking, "workhours.$day_id.from"));
    $end_time = $timeClass->format_minutes(ao($bio->booking, "workhours.$day_id.to"));

    $timevalue = implode('-', [$start_time, $end_time]);
@endphp
<div class="w-700 max-w-full m-auto">


    <div class="inner-pages-header mb-10">
        <div class="inner-pages-header-container">
            <a class="previous-page" app-sandy-prevent="" href="{{ bio_url($bio->id) }}">
                <p class="back-button"><i class="la la-arrow-left"></i></p>
                <h1 class="inner-pages-title ml-3">{{ __('Home') }}</h1>
            </a>
        </div>
    </div>

    
    @if (Auth::check())
        
    <a class="dashboard-header-banner relative mt-0 mb-5 mx-5 md:mx-0 block" href="{{ $sandy->route('sandy-blocks-booking-bookings') }}">
        <div class="card-container">

            <div class="text-lg font-bold">{{ __('View Past Bookings') }}</div>
            <div class="md:w-32 w-full md:relative" for="month-selector">
                <p class="text-lg font-bold auth-link underline">{{ __('View') }}
                </p>
            </div>

            <div class="side-cta top-14">
                {!! orion('hour-1', 'h-20') !!}
            </div>
        </div>
    </a>
    @endif


    <div class="context-head px-5 md:px-10 pt-10 pb-0 mt-0">

    <div class="text-user-creator px-0">
        <div class="flex items-center gap-3">
            <div class="user-img">
                {!! avatar($bio->id, true) !!}
            </div>
            <div class="text">
                <h3>{{ $bio->name }}</h3>
                <p>{{ ao($bio->booking, 'title') }}</p>
            </div>
        </div>
        
    </div>
    <div class="title-card-text flex items-center justify-between px-0">
        <div class="text flex items-center">
            <h1 class="m-0">{{ __('Get In Touch') }}</h1>
        </div>
        <a class="sandy-btn-pill text-white social-modal-open">{{ __('Contact Me') }}</a>
    </div>
    <div class="txt-price-coundown flex justify-between px-0">
        <div class="text">
            <h2>{{ __('Total Bookings') }}</h2>
            <p>{{ nr($total_booking) }}</p>
        </div>
        @if ($timeClass->check_workday(date('l', strtotime($date->format('Y-m-d'))), $bio->id))
        <div class="ctd">
            <h3>{{ __('Availabilty') }}</h3>
            <p>{{ $timevalue }}</p>
        </div>
        @endif
    </div>

    <div class="description text-base mt-5">{{ ao($bio->booking, 'description') }}</div>
    
    <section class="stories-section booking-story">
        <div class="display-stories">
            <div class="swiper myStories">
                <div class="swiper-wrapper wrapper-stories flex overflow-x-auto py-4" id="storiesBox">
                    
                </div>
            </div>
        </div>
    </section>
    <p class="text-sm font-bold text-gray-400 italic my-5">{{ __('Book Now!') }}</p>


    @php
        // Obter workspace_id com múltiplos fallbacks para garantir contexto correto
        $workspaceId = null;
        
        // 1. Via variável compartilhada (se disponível)
        if (isset($workspace) && $workspace) {
            $workspaceId = $workspace->id;
        }
        
        // 2. Via request attributes (setado pelo middleware/trait)
        if (!$workspaceId && request()->attributes->has('workspace')) {
            $workspaceAttr = request()->attributes->get('workspace');
            $workspaceId = $workspaceAttr->id ?? null;
        }
        
        // 3. Via bio (default workspace do usuário)
        if (!$workspaceId) {
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $bio->id)
                ->where('is_default', 1)
                ->where('status', 1)
                ->first();
            $workspaceId = $defaultWorkspace->id ?? null;
        }
        
        // Log para debugging (remover em produção se necessário)
        if (!$workspaceId) {
            \Log::warning('Booking: workspace_id not found for bio', ['bio_id' => $bio->id]);
        }
    @endphp
    <livewire:booking-block-bio-booking :user_id="$bio->id" :workspace_id="$workspaceId" :wire:key="'booking-' . $bio->id . '-' . ($workspaceId ?? 'default')" />







        <div class="avatar-thumb mb-5 hidden">
            <div class="avatar-container">
                <div class="thumb" style="background: {{ao($bio->settings, 'avatar_color')}}">
                    {!! avatar($bio->id, true) !!}
                </div>
            </div>
        </div>
        <div class="shop-name-text text-2xl theme-text-color flex">{{ user('settings.store.shop_name', $bio->id) }}</div>
        <div class="bio-des mt-5 text-sm mb-7 theme-text-color">{{ user('settings.store.shop_description', $bio->id) }}</div>
    </div>
    
</div>
<div class="pb-20"></div>


@section('footerJS')

<script>
    var stories = new Zuck('storiesBox', {
        autoFullScreen: true,
        skin: 'Snapssenger',
        avatars: false,
        list: false,
        openEffect: true,
        cubeEffect: true,
        backButton: false,
        backNative: false,
        localStorage: false,
        paginationArrows: true,
        stories: {!! json_encode($gallery) !!},
    });
</script>
@stop
@endsection