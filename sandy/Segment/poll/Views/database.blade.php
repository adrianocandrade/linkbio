@extends('mix::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'radio-asset.css') }}">
@stop
<div>
    @csrf
    <div class="inner-page-banner">
        
        <div class="heading has-icon">
            <i class="sio database-and-storage-002-server text-3xl mr-2"></i>
            {{ __('Database') }}
        </div>
        <div class="mt-5">{!! Elements::icon($ElemName) !!}</div>
        <h1 class="mt-5 text-base">{{ Elements::config($ElemName, 'name') }}</h1>
        <p class="mt-0 text-sm">{{ __('Check results from your poll') }}</p>
    </div>
    <div class="p-10">
        
        @if (is_array($choices = ao($element->content, 'choices')))
        <p class="mb-5 text-xs">{{ nr($overall_choices_total) }} {{ __('Votes') }}</p>
        <div class="vote-wrapper rounded-2xl">
            @csrf
            @foreach ($choices as $key => $value)
            @php
            $result = @round((ao($value, 'result')/$overall_choices_total)*100);
            @endphp
            <label class="sandy-big-checkbox is-vote show-result mb-5">
                <div class="checkbox-inner">
                    <div class="content">
                        <div class="result-first-half" style="width: calc(-4px + max(70px, {{ $result . '%' }}));"></div>
                        <div class="result-end">{{ $result . '%' }}</div>
                        <h1>{{ ao($value, 'name') }}</h1>
                    </div>
                </div>
            </label>
            @endforeach
        </div>
        @else

        @include('include.is-empty')
        @endif
    </div>
</div>
@endsection