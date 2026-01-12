@extends('index::layouts.master')
@section('title', __t('Preview'))
@section('content')
<div class="c-contain-560 w-full px-5 md:px-0 mt-10">
    
    <div class="inner-page-banner preview flex rounded-xl">
        <div class="thumbnail">
            <div class="thumbnail-inner">
                {!! Elements::icon($element) !!}
            </div>
        </div>
        <div class="content">
            <h4 class="title">{{ Elements::config($element, 'name') }}</h4>
            <p>{{ Elements::config($element, 'description') }}</p>
            @if (Route::has("sandy-app-$element-create") && (new \Elements)->is_in_plan($element, 'status'))
            <a href="{{ route("sandy-app-$element-create") }}" class="button bg-gray-300 text-black mt-5 w-full shadow-none">{{ __('Use') }}</a>
            @endif
            @if (!(new \Elements)->is_in_plan($element, 'status'))
            <p class="mt-5 text-xs">{{ __('Info: This element does not belong to your current plan.') }}</p>
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
</div>
@endsection