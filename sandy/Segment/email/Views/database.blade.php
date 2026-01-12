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
        <p>{{ __('All Submissions from this email element.') }}</p>

        <div class="flex">
            <a href="{{ route('sandy-app-email-export', $element->slug) }}" app-sandy-prevent="" class="text-sticker mt-5">{{ __('Export To CSV') }}</a>
        </div>
    </div>
    <div class="p-10">

        @if (!$db->isEmpty())
        <div class="flex-table mt-4">
            <!--Table header-->
            <div class="flex-table-header">
                <span class="is-grow">{{ __('Email') }}</span>
                <span>{{ __('First Name') }}</span>
                <span>{{ __('Last Name') }}</span>
            </div>
            
            @foreach ($db as $item)
            <div class="flex-table-item">
                <div class="flex-table-cell is-media is-grow" data-th="">
                    <div>
                        <span class="item-name mb-2">{{ $item->email }}</span>
                        <span class="item-meta italic text-sm">
                            <span>{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
                        </span>
                    </div>
                </div>
                <div class="flex-table-cell" data-th="{{ __('First Name') }}">
                    <span>{{ ao($item->database, 'first_name') }}</span>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Last Name') }}">
                    <span>{{ ao($item->database, 'last_name') }}</span>
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