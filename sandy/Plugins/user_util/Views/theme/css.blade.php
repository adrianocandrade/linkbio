@extends('admin::layouts.master')
@section('title', __('Edit Theme'))
@section('content')
<div class="sandy-page-row">
    <div class="sandy-page-col pl-0">
        <div class="page__head">
            <div class="step-banner remove-shadow">
                <div class="section-header">
                    <div class="section-header-info">
                        <p class="section-pretitle">{{ __('Theme') }}</p>
                        <h2 class="section-title">{{ __('Edit Css File') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5 page-trans rounded-2xl">

            <form action="{{ route('sandy-plugins-user_util-themes-edit-css-post', ['theme' => $theme, 'css' => $css]) }}" method="POST">
                @csrf
                <div class="prism-wrap h-screen rounded-2xl">
                    <textarea spellcheck="false" name="css" oninput="app.sandyPrism.update(this.value); app.sandyPrism.sync_scroll(this);" onscroll="app.sandyPrism.sync_scroll(this);" onkeydown="app.sandyPrism.check_tab(this, event);">{!! $cssFile !!}</textarea>

                    <pre id="highlighting">
                        <code class="language-css" id="highlighting-content"></code>
                    </pre>
                </div>
                <button class="text-sticker is-submit is-loader-submit loader-white flex items-center mt-10">{{ __('Save') }}</button>
            </form>
        </div>
    </div>
    <div class="sandy-page-col sandy-page-col_pt100">
        <div class="card card_widget">
            <div class="card-header mb-5">
                <p class="text-sm uppercase flex items-center"><i class="sio design-and-development-033-laptop mr-2 text-2xl"></i> {{ __('Css') }}</p>
                <p class="subtitle text-xs">{{ __('Css files to be included when theme is in use.') }}</p>
                <p class="mt-5 italic text-xs">{{ __('(Note: shortcodes can be used in css files.)') }}</p>
                <p class="mt-3 text-xs">{{ __('Shortcodes: {button_background} for button background color. {button_text_color} for user button text color.') }}</p>
                <p class="mt-5 italic text-xs">{{ __('(Note: You can click on the below css file to edit them.)') }}</p>
            </div>
            @foreach (BioStyle::getCssName($theme) as $key => $value)
            <div class="text-sticker rounded mb-3 w-full justify-between items-center">
                <a href="{{ route('sandy-plugins-user_util-themes-edit-css', ['theme' => $theme, 'css' => basename($value, '.css')]) }}" class="is-link">{{ $value }}</a>
                <form action="{{ route('sandy-plugins-user_util-themes-css-delete', ['theme' => $theme, 'css' => basename($value, '.css')]) }}" method="POST">
                    @csrf
                    <button data-delete="{{ __('Remove this css file?') }}" class="c-red text-xs m-0">{{ __('remove') }}</button>
                </form>
            </div>
            @endforeach
            
            <form action="{{ route('sandy-plugins-user_util-themes-css-upload', $theme) }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div data-generic-preview="">
                    <div class="h-avatar h-32 w-full is-upload is-outline-dark">
                        <i class="flaticon-upload-1"></i>
                        <input type="file" name="css">
                        <div class="file-name"></div>
                    </div>
                </div>
                <p class="mt-5 italic text-xs">{{ __('(Note: Only .css can be uploaded.)') }}</p>
                <button class="text-sticker mt-5 is-loader-submit flex items-center justify-center">{{ __('Upload') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection