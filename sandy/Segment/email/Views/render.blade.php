@extends('bio::layouts.master')
@section('content')
@section('head')
    <style>
        .title{
            padding: 20px 32px;
            background: #fff;
            color: #000;
            border-radius: 10px;
        }

        body.is-dark .title{
            background: #222;
            color: #fff;
        }

        .title h1{
            font-size: 18px;
            font-style: normal;
            font-weight: bold;
            margin-bottom: 4px;
            color: inherit;
        }

        .title p{
            font-size: 15px;
            font-weight: normal;
            font-style: normal;
            line-height: 21px;
            letter-spacing: -0.32px;
        }
        .form-input textarea, .form-input input{
            border-radius: 20px;
            resize: none;
        }

        .context-body .main-email{
            padding: 20px 20px;
            border-radius: 15px;
            display: block;
            bottom: 0;
            width: 100%;
            margin: auto;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .context-body{
            position: relative;
            display: flex;
            height: initial;
            border-radius: 20px !important;
            padding-top: 0 !important;
        }

    </style>
@stop

@section('is_element', true)
<div class="context bio h-screen {!! radius_and_align_class($bio->id, 'align') !!} is-element flex flex-col">
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
    <div class="context-body my-auto">
        <div class="main-email">
            <div class="mb-10 title rounded-2xl w-full">
                <h1 class="title p-0">{{ ao($element->content, 'title') }}</h1>
                <p>{{ ao($element->content, 'description') }}</p>
            </div>
            <form action="{{ route('sandy-app-email-post-submission', $element->slug) }}" method="post" class="rounded-2xl w-full">
                @csrf
                <div class="form-input mb-5">
                    <label>{{ __('Email') }}</label>
                    <input type="email" name="email">
                </div>
                @if (ao($element->content, 'require_name'))
                <div class="md:grid md:grid-cols-2 gap-4">
                    
                    <div class="form-input mb-5">
                        <label>{{ __('First Name') }}</label>
                        <input type="text" name="first_name">
                    </div>
                    <div class="form-input mb-5">
                        <label>{{ __('Last Name') }}</label>
                        <input type="text" name="last_name">
                    </div>
                </div>
                @endif
                <button class="button sandy-quality-button is-loader-submit loader-white mt-5">{{ __('Sign up') }}</button>
                @if (!empty(ao($element->content, 'disclaimer')))
                <div class="mt-5 text-xs">{{ ao($element->content, 'disclaimer') }}</div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection