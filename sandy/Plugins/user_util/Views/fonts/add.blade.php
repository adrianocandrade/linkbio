@extends('admin::layouts.master')
@section('title', __('User Fonts'))
@section('content')
@section('headJS')
    <style>
        header, footer, .header, .footer, .sidebar{
            display: none !important;
        }
    </style>
    @php
        $html = '';
        $styles = '';
        foreach ($allFonts as $key => $value){
            $variants = ao($value, 'variants');
            $url = "https://fonts.googleapis.com/css?family=$key:$variants";
                
            $html .= "<link href='$url' rel='stylesheet' type='text/css'>";

            $styles .= '.'.slugify($key).'-font-preview {font-family: "'.$key.'"}';
        }

        $html .= "<style> $styles </style>";

        echo $html;
    @endphp
@stop
    <form class="sandy-dialog-body" action="{{ route('sandy-plugins-user_util-fonts-post') }}" method="POST">
        @csrf
        <div class="inner-page-banner rounded-2xl h-32 mb-10">
            <h1 class="text-base"><i class="sio office-082-text-document text-lg mr-3"></i>{{ __('Our 1,000 Google Font Collection') }}</h1>
            <p>{{ __('Choose the font you need to add them to the avilable user fonts.') }}</p>

            <p class="text-xs italic mt-5">{{ __('(Note: This page is very heavy due to the amounts of fonts being loaded from google servers.)') }}</p>
        </div>

        <button class="text-sticker is-submit is-loader-submit loader-white flex items-center my-10">{{ __('Save') }}</button>
        
        <div class="grid mt-5 grid-cols-2 gap-4">
            @foreach ($allFonts as $key => $value)
            <label class="sandy-big-radio">
                <input type="checkbox" name="font[]" value="{{ $key }}" class="custom-control-input">
                <div class="radio-select-inner font rounded-2xl">
                    <div class="active-dot"></div>
                    <h1 class="{{ slugify($key) }}-font-preview">{{ $key }}</h1>
                    <p class="font-preview {{ slugify($key) }}-font-preview">{{ __($value['text'] ?? 'The quick brown fox') }}</p>
                </div>
            </label>
            @endforeach
        </div>
    </form>
@endsection