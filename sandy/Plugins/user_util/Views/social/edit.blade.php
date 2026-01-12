@extends('admin::layouts.master')
@section('title', __('Edit Social Field'))
@section('headJS')
<style>
header, footer, .header, .footer, .sidebar{
    display: none !important;
}
</style>
@stop
@section('content')
<div class="mx-auto mix-padding-10">
    
    <div class="step-banner">
        <div class="page__title h2 m-0">{{ __('Edit Social Field') }}</div>
    </div>
    <div>
        
        <form action="{{ route('sandy-plugins-user_util-socials-edit-post', $social) }}" method="POST">
            @csrf
            <div class="form-input mb-5">
                <label>{{ __('Name') }}</label>
                <input type="text" name="name" value="{{ ao($data, 'name') }}">
            </div>
            <div data-checkbox-wrapper="" class="mb-5">
                <div class="grid grid-cols-1 gap-4 mb-5">
                    <label class="sandy-big-checkbox">
                        <input type="radio" name="icon_type" class="sandy-input-inner" data-checkbox-open=".icon-type" checked="">
                        <div class="checkbox-inner">
                            <div class="checkbox-wrap">
                                <div class="content">
                                    <h1>{{ __('Icon') }}</h1>
                                    <p>{{ __('Type in your icon class.') }}</p>
                                </div>
                                <div class="icon">
                                    <div class="active-dot">
                                        <i class="la la-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>
                    <label class="sandy-big-checkbox hidden">
                        <input type="radio" name="icon_type" class="sandy-input-inner" data-checkbox-open=".icon-svg">
                        <div class="checkbox-inner">
                            <div class="checkbox-wrap">
                                <div class="content">
                                    <h1>{{ __('Svg') }}</h1>
                                    <p>{{ __('Type in your svg icon code') }}</p>
                                </div>
                                <div class="icon">
                                    <div class="active-dot">
                                        <i class="la la-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="form-input mb-5 icon-svg hidden" data-checkbox-item>
                    <label>{{ __('Svg') }}</label>
                    <textarea name="svg" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="form-input icon-type" data-checkbox-item>
                    <label>{{ __('Icon') }}</label>
                    <input type="text" name="icon" value="{{ ao($data, 'icon') }}">
                </div>
            </div>
            <div class="form-wrap mb-5" pickr>
                <label>{{ __('Solid Color') }}</label>
                <input pickr-input type="hidden" name="color" value="{{ ao($data, 'color') ?? '#000' }}">
                <div id="solid-background-color" pickr-div></div>
            </div>
            <div class="form-input mb-5">
                <label class="initial">{{ __('Address') }}</label>
                <input type="text" placeholder="{{ __('Ex: %s') }}" value="{{ ao($data, 'address') }}" name="address">
                <p class="mt-4 text-xs italic">{{ __('(Note: example can be "https://twitter.com/%s". "%s" for user social info.)') }}</p>
            </div>
            <button class="button is-loader-submit loader-white">{{ __('Save') }}</button>
        </form>
    </div>
</div>
@endsection