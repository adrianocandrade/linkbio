@extends('bio::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
@stop
@section('is_element', true)
<div class="context bio h-screen p-0 is-element flex flex-col">
    <div class="element-context-body p-5 flex-col bg-white h-full">
        <div class="my-auto">
            <div class="text-lg mb-4 font-bold">{{ __('Your files are ready.') }}</div>
            
            @if (is_array($downloadables = ao($element->content, 'downloadables')))
                @foreach ($downloadables as $key => $values)
                    <div class="mort-main-bg p-3 rounded-2xl flex items-center mb-5">
                        <div class="text-sticker h-full m-0 break-all mr-auto">{{ $values }}</div>

                        <a href="{{ gs('media/element/others', $values) }}" download="{{ $values }}" class="ml-2 text-sticker flex items-center justify-center m-0 bg-gray-200 text-black">{{ __('Download') }}</a>
                    </div>
                @endforeach
            @endif
            <div class="flex gap-4 mt-5">
                <a class="text-sticker rounded-xl" href="{{ route('sandy-app-downloadable_files-render', $element->slug) }}">{{ __('Go back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection