@extends('mix::layouts.master')
@section('title', __('View'))
@section('namespace', 'user-mix-element-preview')
@section('content')

<div class="inner-page-banner preview flex rounded-xl">
    <div class="thumbnail">
        <div class="thumbnail-inner">
            {!! Elements::icon($element) !!}
        </div>
    </div>

    <div class="content">
        <h4 class="title">{{ Elements::config($element, 'name') }}</h4>
        <p>{{ Elements::config($element, 'description') }}</p>

        @if (Route::has("sandy-app-$element-create"))
            <a href="{{ route("sandy-app-$element-create") }}" class="use-button">{{ __('Use') }}</a>
        @endif
    </div>
</div>



<div class="my-8 mx-5 tiny-content-init">
    @if (!empty($about = Elements::config($element, 'about')))
        {!! $about !!}
    @endif
</div>

<div class="gallery preview" >
    @if (is_array($gallery = $config('gallery')))
        @foreach ($gallery as $key => $value)
            <div class="gallery-single">
                <div class="gallery-single-inner">
                    <img src="{{ Elements::galleryImage($element, $value) }}" alt="">
                </div>
            </div>
        @endforeach
    @endif
</div>

@endsection