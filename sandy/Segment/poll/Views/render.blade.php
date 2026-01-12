@extends('bio::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'radio-asset.css') }}">
@stop
@section('footerJS')
<script>
</script>
@stop
@section('is_element', true)
<div class="context bio p-0 {!! radius_and_align_class($bio->id, 'align') !!} is-element flex flex-col px-5">
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
    <div class="context-body w-full mt-10 pb-0 relative">
        <div class="message">
            <div class="block pl-0 mb-5">
                <h1 class="title mb-3 font-bold text-xl">{{ $element->name }}</h1>
                <h1 class="title">{{ ao($element->content, 'question') }}</h1>
            </div>
            @if (is_array($choices = ao($element->content, 'choices')))

            <p class="mb-5 text-xs">{{ nr($overall_choices_total) }} {{ __('Votes') }}</p>
            <form action="{{ route('sandy-app-poll-vote', $element->slug) }}" method="POST" class="vote-wrapper">
                @csrf
                @foreach ($choices as $key => $value)
                @php
                    $result = @round((ao($value, 'result')/$overall_choices_total)*100);
                @endphp
                <label class="sandy-big-checkbox is-vote {{ $has_vote ? 'show-result' : '' }} {{ session()->get($session_key) == $key ? 'has-voted' : '' }} mb-5">
                    <input type="radio" name="vote" class="sandy-input-inner" value="{{ $key }}">
                    <div class="checkbox-inner">
                        <div class="content">
                            @if ($has_vote)
                                <div class="result-first-half" style="width: calc(-4px + max(70px, {{ $result . '%' }}));"></div>
                                <div class="result-end">{{ $result . '%' }}</div>
                            @endif

                            <h1>{{ ao($value, 'name') }}</h1>
                        </div>
                    </div>
                </label>
                @endforeach

                @if (!$has_vote)
                    <button class="mt-4 text-sticker">{{ __('Vote') }}</button>
                @endif
            </form>
            @endif
        </div>
    </div>
</div>
@endsection