@extends('mix::layouts.master')
@section('content')
<div>
    @csrf
    <div class="inner-page-banner">
        
        <div class="heading has-icon">
            <i class="sio database-and-storage-002-server text-3xl mr-2"></i>
            {{ __('Database') }}
        </div>
        <div class="mt-5">{!! Elements::icon($ElemName) !!}</div>
        <h1 class="mt-5 text-base">{{ Elements::config($ElemName, 'name') }}</h1>
    </div>
    <div class="p-10">
        @if (!$db->isEmpty())
            @foreach ($db as $item)
            <div class="justify-between mort-main-bg p-7 rounded-xl mb-10">
                <span class="item-meta italic text-sm c-gray">
                    <span>{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
                </span>
                
                <div class="text-xs mt-4" data-th="{{ __('Email') }}">
                    <span>{{ ao($item->database, 'email') }}</span>
                </div>
                
                <div class="text-base mt-4" data-th="{{ __('Subject') }}">
                    <span>{{ ao($item->database, 'subject') }}</span>
                </div>
                
                <div class="text-xs mt-4" data-th="{{ __('Message') }}">
                    <span class="font-bold">{{ ao($item->database, 'message') }}</span>
                </div>
            </div>
            @endforeach
        @else
            @include('include.is-empty')
        @endif
    </div>
</div>
@endsection