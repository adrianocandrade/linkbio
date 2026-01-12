@extends('bio::layouts.master')
@section('content')
@section('head')
    <style>
        .titles{
            padding: 20px 32px;
            background: #f5f7fc;
            border-radius: 10px;
        }
        body.is-dark .titles{
            background: #222;
            color: #fff;
        }

        .titles h1{
            font-size: 22px;
            font-style: normal;
            font-weight: bold;
            margin-bottom: 4px;
            color: inherit;
        }
    </style>
@stop
@section('is_element', true)
<div class="context bio {!! radius_and_align_class($bio->id, 'align') !!} is-element">
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
    <div class="context-body mt-10 px-5 pb-5 rounded-none">
        <div class="mb-10 titles">
            <h1 class="title">{{ $element->name }}</h1>
        </div>

        <div class="blog-content tiny-content-init">
            {!! clean(ao($element->content, 'textarea')) !!}
        </div>
    </div>
</div>
@endsection