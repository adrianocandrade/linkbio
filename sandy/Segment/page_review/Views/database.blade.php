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
                    <span>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                </span>
                
                <div class="text-xs mt-4" data-th="{{ __('Name') }}">
                    <span>{{ ao($item->database, 'name') }}</span>
                </div>
                <div class="text-xs mt-4" data-th="{{ __('Text') }}">
                    <span>{{ ao($item->database, 'review') }}</span>
                </div>


                @if (!ao($item->database, 'status'))
                    <a href="{{ route('sandy-app-page_review-accept-review', ['slug' => $element->slug, 'id' => $item->id]) }}" class="text-sticker mt-3">{{ __('Accept') }}</a>
                @endif
            </div>
            @endforeach
        @else
            @include('include.is-empty')
        @endif
    </div>
</div>
@endsection