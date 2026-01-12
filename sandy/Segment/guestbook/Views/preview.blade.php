@extends('mix::layouts.master')
@section('title', __('View'))
@section('namespace', 'user-mix-new-link-section-preview')
@section('content')


<div class="inner-page-banner preview flex">
    <div class="thumbnail">
        <div class="thumbnail-inner">
            <img src="http://wallet.yetti.test/app/img/avatar/26.jpg" alt="">
        </div>
    </div>

    <div class="content">
        <h4 class="title">{{ $config['name'] ?? '' }}</h4>
        <p>{{ $config['description'] ?? '' }}</p>
        @if (Route::has("sandy-app-guestbook-create"))
         <a href="{{ route("sandy-app-guestbook-create") }}" class="use-button">{{ __('Use') }}</a>
        @endif
    </div>
</div>


<div class="my-8 mx-5">
    @if (!empty($about = $config['about']))
        {!! $about !!}
    @endif
</div>

<div class="gallery preview" >
    <div class="gallery-single">
        <div class="gallery-single-inner">
            <img src="http://wallet.yetti.test/app/img/cover/42.jpg" alt="">
        </div>
    </div>
    <div class="gallery-single">
        <div class="gallery-single-inner">
            <img src="http://wallet.yetti.test/app/img/cover/29.jpg" alt="">
        </div>
    </div>
    <div class="gallery-single">
        <div class="gallery-single-inner">
            <img src="http://wallet.yetti.test/app/img/cover/39.jpg" alt="">
        </div>
    </div>
</div>

@endsection