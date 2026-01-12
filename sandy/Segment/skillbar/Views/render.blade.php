@extends('bio::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
@stop
@section('is_element', true)
<div class="context bio h-screen p-0 {!! radius_and_align_class($bio->id, 'align') !!} is-element flex flex-col">
    <div class="context-head pt-10">
        <div class="avatar-thumb relative z-10 mb-5">
            <div class="avatar-container">
                <a href="/<?= e(config('app.bio_prefix')) ?><?= $bio->username ?>">
                    <div class="thumb" style="background: {{ao($bio->settings, 'avatar_color')}}">
                        {!! avatar($bio->id, true) !!}
                    </div>
                </a>
            </div>
            <div class="bio-info-container">
                <div class="bio-name-text theme-text-color flex">
                    {{ $bio->name }}
                    {!! user_verified($bio->id) !!}
                </div>
                <div class="bio-username-text theme-text-color">
                    {{ '@' . $bio->username }}
                </div>
            </div>
        </div>
    </div>
    <div class="context-body pb-0 pt-0 remove-before px-5 bg-transparent mt-10 md:px-0 relative">
        <div class="message">
            <div class="title-container mb-5">
                <h1 class="title text-xl font-bold mb-0">{{ $element->name }}</h1>
                <h1 class="title">{{ ao($element->content, 'description') }}</h1>
            </div>
            <div class="skill-bars">

                @if (is_array($skills = ao($element->content, 'skills')))
                    @foreach ($skills as $key => $values)
                        <div class="bar">
                            <div class="info">
                                <span>{{ ao($values, 'name') }}</span>
                            </div>
                            <div class="progress-line html">
                                <span style="width: {{ ao($values, 'skill') }}%">
                                </span>
                                    <p class="text">{{ ao($values, 'skill') }}%</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection