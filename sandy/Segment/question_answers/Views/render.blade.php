@extends('bio::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'response-asset.css') }}">
@stop
@section('is_element', true)
<div class="context bio p-5 {!! radius_and_align_class($bio->id, 'align') !!} is-element">
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
    <div class="questions-header mt-10">
        <div class="context-body w-full mt-10 pb-0 relative">
            <div class="questions-header-desc pt-0">
                <p>{{ ao($element->content, 'description') }}</p>
                @if (ao($element->content, 'price.enable') == 'disable')
                <a class="button mt-0 w-full is-loader-submit loader-white shadow-none submit-question-open">{{ __('Submit Question') }}</a>
                @else
                <a class="button mt-0 w-full is-loader-submit loader-white shadow-none submit-question-open">{!! __('Submit Question for :price', ['price' => Currency::symbol(ao($bio->payments, 'currency')) . ao($element->content, 'price.price')]) !!}</a>
                @endif
                <p class="text-xs mt-5 p-0 mb-0">{{ __('Write a message with your question.') }}</p>
            </div>
        </div>
    </div>
    <div class="responses">
        <div class="my-10 text-center text-lg font-bold">
            {{ __('Question(s) & Response') }}
        </div>
        
        @foreach ($allDB as $item)

            @php
                $show_item = true;
                if(!ao($element->content, 'show_unanswered') && empty(ao($item->database, 'response'))){
                    $show_item = false;
                }

                if(!empty(ao($item->database, 'response'))){
                    $show_item = true;
                }
            @endphp
            @if ($show_item)
                <div>
                    <div class="response mb-5">
                        <div class="response-text">
                            {{ ao($item->database, 'question') }}
                        </div>
                        <span class="name-time">{{ ao($item->database, 'name') }} · <time>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</time></span>
                        <div class="response-answer">
                            <div class="response-heading">{{ __('Response') }}</div>

                            <div class="response-text mt-3 mb-0">
                                {{ ao($item->database, 'response') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
<div class="p-10 rounded-3xl" data-popup=".submit-question">
    @if (ao($element->content, 'price.enable') == 'disable')
    <form method="post" action="{{ route('sandy-app-question_answers-ask', $element->slug) }}">
        @csrf
        <div class="text-center">
            <div class="form-input mb-5">
                <label>{{ __('Question') }}</label>
                <textarea name="question" cols="30" rows="10"></textarea>
            </div>
            <div class="form-input">
                <label>{{ __('Name') }}</label>
                <input type="text" name="name">
            </div>
            <button class="button mt-5 w-full">{{ __('Post') }}</button>
        </div>
    </form>
    @else
    
    <form method="post" action="{{ route('sandy-app-question_answers-pay', $element->slug) }}">
        @csrf
        <div class="text-center">
            <div>
                <div class="text-2xl font-bold mb-5 mt-5">{{ __('Pay before you continue') }}</div>
                <div class="mb-7 text-sm">{{ __('We would need your email for us to process your payment.') }}</div>
            </div>
            <div class="form-input">
                <label>{{ __('Email') }}</label>
                <input type="text" name="email">
            </div>
            <button class="button mt-5 w-full">{{ __('continue') }}</button>
        </div>
    </form>
    @endif
</div>
@endsection