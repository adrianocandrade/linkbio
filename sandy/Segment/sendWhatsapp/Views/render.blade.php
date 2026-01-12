@extends('bio::layouts.master')
@section('content')
@section('head')
<style>
.message .title{
    font-size: 14px;
    color: #000;
    font-style: normal;
    font-weight: normal;
}
.form-input textarea, .form-input input{
    border-radius: 20px;
    background: #f5f7fc;
    resize: none;
}
.context-body{
    border-radius: 20px !important;
    position: relative;
    display: flex;
}
.context-body .message{
    padding: 20px 32px;
    border-radius: 10px;
    display: block;
    bottom: 0;
    width: 100%;
    background: #fff;
    margin: auto;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

body.is-dark .message {
    background: #404040;
}
.title-container{
    background: #f5f7fc;
    padding: 15px;
    border-radius: 20px;
    width: 100%;
    display: flex;
    align-items: center;
}
.title-container i{
    margin-right: auto;
}
.title-container i{
    font-size: 30px;
}
.context-body{
    height: initial;
    border-radius: 20px;
}
#app-sandy-mix #content, #app-sandy-mix.is-bio{
    overflow: initial !important;
}
</style>
@stop
@section('is_element', true)
<div class="context bio h-screen p-5 {!! radius_and_align_class($bio->id, 'align') !!} is-element">
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
    <div class="context-body remove-before my-auto p-0">
        <form class="message" method="post" action="{{ route('sandy-app-sendWhatsapp-send', $element->slug) }}">
            @csrf
            
            <div class="title-container mb-10">
                <i class="sni sni-whatsapp"></i>
                <h1 class="title">{{ ao($element->content, 'caption') }}</h1>
            </div>

            <div class="form-input w-full">
                <label>{{ __('Message') }}</label>
                <textarea name="text" cols="30" rows="10"></textarea>
            </div>

            <button class="button sandy-quality-button is-loader-submit loader-white">{{ __('Send Message') }}</button>
        </form>
    </div>
</div>
@endsection