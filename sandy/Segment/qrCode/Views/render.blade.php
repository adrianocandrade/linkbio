@extends('bio::layouts.master')
@section('content')
@section('head')
<style>
.qrCode .qr-title{
    font-size: 16px;
    color: #000;
    font-style: normal;
    font-weight: bold;
    margin-bottom: 4px;
}
body.is-dark .qrCode .qr-title{
    color: #fff;
}
.context-body{
    border-radius: 0 !important;
    background: transparent !important;
    position: relative;
    display: flex;
    border: 0 !important;
}
.context-body .qrCode{
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
body.is-dark .context-body .qrCode{
    background: #222;
}
.context-body .qrCode .qr{
    width: 55%;
    margin-top: 20px;
}
.context-body{
    height: initial;
    border-radius: 20px;
}
#app-sandy-mix #content, #app-sandy-mix.is-bio{
    overflow: initial !important;
}
@@supports ((-webkit-backdrop-filter: none) or (backdrop-filter: none)) {
    .context-body .qrCode {
        -webkit-backdrop-filter: blur(4px);
        backdrop-filter: blur(4px);
        background: #ffffffd1;
    }
}
</style>
@stop
@section('is_element', true)
<div class="context bio {!! radius_and_align_class($bio->id, 'align') !!} p-5 is-element">
    <div class="bio-background">
        {!! videoOrImage(media_or_url($element->thumbnail, 'media/element/thumbnail')) !!}
    </div>
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
    <div class="context-body remove-before mt-10 p-0">
        <div class="qrCode">
            <h1 class="qr-title mb-5">{{ ao($element->content, 'caption') }}</h1>

            <img src="data:image/png;base64, {!! $qrCode !!}" class="qr">


            <a href="data:image/png;base64, {!! $qrCode !!}" download="qr-download-{{ \Str::random(3) }}" class="mt-5 text-sticker mr-auto">{{ __('Download') }}</a>
        </div>
    </div>
</div>
@endsection