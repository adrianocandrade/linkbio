@extends('admin::layouts.master')
@section('title', __('User Customization'))
@section('content')
<div class="sandy-page-col pl-0 pb-0">
    <div class="page__head">
        <div class="step-banner remove-shadow">
            <div class="section-header">
                <div class="section-header-info">
                    <div class="page__title h2 m-0">{{ __('Customize') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="grid md:grid-cols-3 sm:grid-cols-2 gap-4">
    <div>
        <div class="card card_widget mb-7 sm:mb-0 block has-sweet-container">
            <div class="card-container">
                
                <div class="side-cta is-small">
                    <img src="{{ gs('assets/image/others/Asset-555.png') }}" alt="">
                </div>
                <div class="icon ">
                    <i class="sio design-and-development-017-blog-template text-5xl"></i>
                </div>
                <div class="mt-5 text-2xl">{{ __('Themes') }}</div>
                <div class="my-2 text-xs is-info">{{ __('Setup, select, manage and add new themes for your users.') }}</div>
                <a href="{{ route('sandy-plugins-user_util-themes-index') }}" class="text-sticker"><i class="sio office-087-highlighter text-xl mr-4"></i> {{ __('Configure') }}</a>
            </div>
        </div>
    </div>
    <div>
        <div class="card card_widget mb-7 sm:mb-0 block has-sweet-container">
            <div class="card-container">
                <div class="side-cta is-small">
                    <img src="{{ gs('assets/image/others/Asset-555.png') }}" alt="">
                </div>
                <div class="icon ">
                    <i class="sio office-082-text-document text-5xl"></i>
                </div>
                <div class="mt-5 text-2xl">{{ __('Fonts') }}</div>
                <div class="my-2 text-xs is-info">{{ __('Lots of Google fonts to add, rearrange for your users.') }}</div>
                <a href="{{ route('sandy-plugins-user_util-fonts-index') }}" class="text-sticker"><i class="sio office-087-highlighter text-xl mr-4"></i> {{ __('Configure') }}</a>
            </div>
        </div>
    </div>
    <div>
        <div class="card card_widget mb-7 sm:mb-0 block has-sweet-container">
            <div class="card-container">
                <div class="side-cta is-small">
                    <img src="{{ gs('assets/image/others/Asset-555.png') }}" alt="">
                </div>
                <div class="icon ">
                    <i class="sio media-icon-047-social-network text-5xl"></i>
                </div>
                <div class="mt-5 text-2xl">{{ __('Social') }}</div>
                <div class="my-2 text-xs is-info">{{ __('Add, edit and remove social media fields for your users.') }}</div>
                <a href="{{ route('sandy-plugins-user_util-socials-index') }}" class="text-sticker"><i class="sio office-087-highlighter text-xl mr-4"></i> {{ __('Configure') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection