@extends('bio::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
@stop
@section('is_element', true)
<div class="context bio p-0 {!! radius_and_align_class($bio->id, 'align') !!} is-element flex flex-col">
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
    <div class="element-context-body my-auto p-5 flex-col bg-white">
        <div class="px-5 text-center">
            
            <p class="text-sm mb-2">{{ __('Here is your link:') }}</p>

            <div class="the-link mt-4">
                {{ ao($element->content, 'link') }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-5">
            <a class="button outline-dark rounded-xl" data-copy="{{ ao($element->content, 'link') }}" data-after-copy="{{ __('Copied') }}">{{ __('Copy') }}</a>
            <a class="button rounded-xl" href="{{ ao($element->content, 'link') }}" target="_blank">{{ __('Open') }}</a>
        </div>
    </div>
</div>
@endsection