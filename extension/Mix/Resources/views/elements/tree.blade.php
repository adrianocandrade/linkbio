@extends('mix::layouts.master')
@section('title', __('View'))
@section('namespace', 'user-mix-element-preview')
@section('content')
<div class="mix-padding-10">
    
    <div class="dashboard-header-banner relative mt-0 mb-5">
        <div class="card-container">

            <div class="inner-page-banner preview flex p-0 bg-transparent min-h-full">
                <div class="thumbnail">
                    <div class="thumbnail-inner">
                        {!! Elements::icon($element) !!}
                    </div>
                </div>
                <div class="content">
                    <h4 class="title">{{ Elements::config($element, 'name') }}</h4>
                    <p>{{ Elements::config($element, 'description') }}</p>
                </div>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <div class="dashboard-header-banner relative mt-0 mb-0">
            <div class="card-container pb-4">

                <div class="text-lg font-bold uppercase">{{ __('Edit Element') }}</div>
                
                <p class="text-xs mb-4">{{ __('Edit this element and make changes.') }}</p>
                
                @if (Route::has("sandy-app-$element-edit"))
                <a href="{{ route("sandy-app-$element-edit", $item->slug) }}" app-sandy-prevent="" class="sandy-expandable-btn px-8 bg-white m-0"><span>{{ __('Edit') }}</span></a>
                @endif
                
                <div class="side-cta top-24">
                    {!! orion('pencil-1', 'h-16') !!}
                </div>
            </div>
        </div>
        <div class="dashboard-header-banner relative mt-0 mb-0">
            <div class="card-container pb-4">

                <div class="text-lg font-bold uppercase">{{ __('Database') }}</div>
                
                <p class="text-xs mb-4">{{ __('Check the database of this element be it submissions, entries, etc.') }}</p>
                
                @if (Route::has("sandy-app-$element-database"))
                <a href="{{ route("sandy-app-$element-database", $item->slug) }}" app-sandy-prevent="" class="sandy-expandable-btn px-8 bg-white m-0"><span>{{ __('View') }}</span></a>
                @endif
                
                <div class="side-cta top-24">
                    {!! orion('server-1', 'h-16') !!}
                </div>
            </div>
        </div>
        <div class="dashboard-header-banner relative mt-0 mb-0">
            <div class="card-container pb-4">

                <div class="text-lg font-bold uppercase">{{ __('Preview') }}</div>
                
                <p class="text-xs mb-4">{{ __('Get & Preview the public link for this element.') }}</p>
                
                @if (Route::has("sandy-app-$element-render"))
                <a href="{{ route("sandy-app-$element-render", $item->slug) }}" iframe-trigger="" app-sandy-prevent="" class="sandy-expandable-btn px-8 bg-white m-0"><span>{{ __('View') }}</span></a>
                @endif

                <div class="side-cta top-24">
                    {!! orion('eye-1', 'h-16') !!}
                </div>
            </div>
        </div>
        <div class="dashboard-header-banner relative mt-0 mb-0">
            <div class="card-container pb-4">

                <div class="text-lg font-bold uppercase">{{ __('Delete') }}</div>
                
                <p class="text-xs mb-4">{{ __('Element will be completely removed from the server with it\'s database.') }}</p>
                
                @if (Route::has("sandy-app-$element-delete"))

                    <form action="{{ route("sandy-app-$element-delete", $item->slug) }}" method="post">
                        @csrf
                        <button data-delete="{{ __('Are you sure you want to delete this element?') }}" class="sandy-expandable-btn px-8 m-0 bg-red-500 text-white"><span>{{ __('Delete') }}</span></button>
                    </form>
                @endif
                <div class="side-cta top-24">
                    {!! orion('bin-1', 'h-16') !!}
                </div>
            </div>
        </div>
    </div>

</div>
<div class="mix-padding-10 hidden">
    
    <div class="my-5">
        <div class="mort-main-bg insight-split-card rounded-2xl border-b-0 is-not">
            <div class="split-card">
                <div class="heading has-icon">
                    <i class="sio internet-052-pencil"></i>
                    {{ __('Edit Element') }}
                </div>
                <div class="sub-heading my-4">
                    {{ __('Edit this element and make changes.') }}
                </div>
                @if (Route::has("sandy-app-$element-edit"))
                <a href="{{ route("sandy-app-$element-edit", $item->slug) }}" app-sandy-prevent="" class="text-sticker">{{ __('Edit') }}</a>
                @endif
            </div>
            <div class="split-card">
                <div class="heading has-icon">
                    <i class="sio database-and-storage-002-server"></i>
                    {{ __('Database') }}
                </div>
                <div class="sub-heading my-4">
                    {{ __('Check the database of this element be it submissions, entries, etc.') }}
                </div>
                @if (Route::has("sandy-app-$element-database"))
                <a href="{{ route("sandy-app-$element-database", $item->slug) }}" app-sandy-prevent="" class="text-sticker">{{ __('View') }}</a>
                @endif
            </div>
            <div class="split-card">
                <div class="heading has-icon">{{ __('Preview') }}</div>
                <div class="sub-heading my-4">
                    {{ __('Check the database of this element be it submissions, entries, etc.') }}
                </div>
                @if (Route::has("sandy-app-$element-render"))
                <a href="{{ route("sandy-app-$element-render", $item->slug) }}" iframe-trigger="" app-sandy-prevent="" class="text-sticker">{{ __('View') }}</a>
                @endif
            </div>
            <div class="split-card border-b-0 border-r-0">
                <div class="heading has-icon">
                    <i class="sio internet-085-dustbin"></i>
                    {{ __('Delete') }}
                </div>
                <div class="sub-heading italic my-4 text-sm">
                    {{ __("(Note: Delete this element will completely remove it from the server with it's database.')") }}
                </div>
                @if (Route::has("sandy-app-$element-delete"))

                    <form action="{{ route("sandy-app-$element-delete", $item->slug) }}" method="post">
                        @csrf
                        <button data-delete="{{ __('Are you sure you want to delete this element?') }}" class="text-sticker mt-4 bg-red-500 text-white">{{ __('Delete') }}</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection