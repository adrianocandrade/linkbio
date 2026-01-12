@extends('mix::layouts.master')
@section('content')
<div>
    @csrf
    <div class="inner-page-banner">
        
        <div class="heading has-icon">
            <i class="sio database-and-storage-002-server text-3xl mr-2"></i>
            {{ __('Database') }}
        </div>

        <div class="mt-5">{!! Elements::icon('tipJar') !!}</div>
        <h1 class="mt-5 text-base">{{ Elements::config('tipJar', 'name') }}</h1>
    </div>
    <div class="p-10">

        @if (!$db->isEmpty())
        <div class="flex-table mt-4">
            <!--Table header-->
            <div class="flex-table-header">
                <span class="is-grow">{{ __('Email') }}</span>
                <span>{{ __('Amount') }}</span>
                <span>{{ __('Currency') }}</span>
                <span>{{ __('Status') }}</span>
                <span>{{ __('Note') }}</span>
            </div>
            
            @foreach ($db as $item)
            <div class="flex-table-item">
                <div class="flex-table-cell is-media is-grow" data-th="">
                    <div>
                        <span class="item-name dark-inverted is-font-alt is-weight-600 mb-2">{{ $item->email }}</span>
                        <span class="item-meta italic text-sm">
                            <span>{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
                        </span>
                    </div>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Amount') }}">
                    <span class="light-text">{{ nr(ao($item->database, 'amount')) }}</span>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Currency') }}">
                    <span class="dark-inverted is-weight-600">{{ ao($item->database, 'currency') }}</span>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Status') }}">
                    <span class="tag is-green is-rounded">{{ ao($item->database, 'status') ? __("Paid") : __('Unpaid') }}</span>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Note') }}">
                    @if (!empty(ao($item->database, 'note')))
                        <div class="ml-auto" data-hover="{{ ao($item->database, 'note') }}">
                          <i class="sio office-031-notepad text-3xl m-0"></i>
                        </div>
                    @endif
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