@extends('bio::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
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
    <div class="context-body flex-col m-0 p-6 md:p-10">
        <div>
            <div class="comment">
                <form class="comment-form" action="{{ route('sandy-app-page_review-send', $element->slug) }}" method="post">
                    @csrf
                    <div class="comment-title">{{ $element->name }}</div>
                    <div class="comment-head">
                        <div class="comment-text">{{ ao($element->content, 'caption') }}</div>
                    </div>
                    <div class="grid grid-cols-2 mb-5 mt-5">
                        
                        <div class="form-input">
                            <label class="">{{ __('Your name') }}</label>
                            <input type="text" name="name">
                        </div>
                        @if (ao($element->content, 'enable_rating'))
                        <div class="flex items-center justify-end">
                            <input type="hidden" value="2" name="rating" id="rating-input">
                            
                            <div class="rating js-rating" data-rating="2" data-input-id="#rating-input" data-read="false"></div>
                        </div>
                        @endif
                    </div>
                    <div class="comment-field">
                        <input class="comment-input" type="text" name="review" placeholder="{{ __('Leave a review') }}">
                    </div>
                    <button class="text-sticker mt-4">{{ __('Post') }}</button>
                </form>
                <div class="comment-head">
                    <div class="comment-title">{{ __(':number_of_reviews reviews', ['number_of_reviews' => nr(count($allDB))]) }}</div>
                </div>
                <div class="comment-list">
                    @foreach ($allDB as $item)
                    @php
                    $database = $item->database;
                    @endphp
                        @if (ao($database, 'status'))
                        
                        <div class="comment-item">
                            <div class="comment-details">
                                <div class="comment-top">
                                    <div class="comment-author">{{ ao($database, 'name') }}</div>
                                    @if (ao($element->content, 'enable_rating'))
                                    <div class="rating js-rating" data-rating="{{ !empty(ao($database, 'rating')) ? ao($database, 'rating') : '0' }}" data-read="true"></div>
                                    @endif
                                </div>
                                <div class="comment-content">{{ ao($database, 'review') }}</div>
                                <div class="comment-foot">
                                    <div class="comment-time">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
                                    
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection