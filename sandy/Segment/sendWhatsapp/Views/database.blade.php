@extends('mix::layouts.master')
@section('content')
<div>
    @csrf
    <div class="inner-page-banner">
        
        <div class="heading has-icon">
            <i class="sio database-and-storage-002-server text-3xl mr-2"></i>
            {{ __('Database') }}
        </div>

        <div class="mt-5">{!! Elements::icon('sendWhatsapp') !!}</div>
        <h1 class="mt-5 text-base">{{ Elements::config('sendWhatsapp', 'name') }}</h1>
    </div>
    <div class="p-10">

        @if (!$db->isEmpty())
        <div class="flex-table mt-4">
            <!--Table header-->
            <div class="flex-table-header">
                <span class="is-grow">{{ __('Email') }}</span>
                <span>{{ __('Text') }}</span>
            </div>
            
            @foreach ($db as $item)
            <div class="flex-table-item">
                <div class="flex-table-cell is-media is-grow" data-th="">
                    <div>
                        <span class="item-meta italic text-sm">
                            <span>{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
                        </span>
                    </div>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Text') }}">
                    <span>{{ ao($item->database, 'text') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        @else
        @include('include.is-empty')
        @endif
    </div>
</div>
@endsection