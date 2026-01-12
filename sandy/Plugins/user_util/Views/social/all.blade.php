@extends('admin::layouts.master')
@section('title', __('Social fields'))
@section('footerJS')
   <script>
      app.utils.dialogClose = function(){
         jQuery('[data-iframe-modal]').on('dialog:close', function(e, $elem){
            location.reload();
         });
      };
      app.utils.dialogClose();
   </script>
@stop
@section('content')
<div class="sandy-page-row justify-center">
    <div class="sandy-page-col pl-0">
        <div class="page__head">
            <div class="step-banner remove-shadow">
                <div class="section-header block md:flex">
                    <div class="section-header-info">
                        <p class="section-pretitle">{{ __('Add New Social Fields') }}</p>
                        <h2 class="section-title">{{ __('Social Fields') }}</h2>
                    </div>
                    <div class="section-header-actions md:w-1/4 md:justify-end mt-5 md:mt-0 mb-0">
                        <div class="notifications__tags m-0">
                            <a class="notifications__link active new-social-open cursor-pointer">{{ __('Add Social Field') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-trans rounded-2xl">
            <div class="mt-5">
                @include('Plugin-user_util::social.social-include')
            </div>
        </div>
    </div>
</div>


<div data-iframe-modal="" class="sandy-bio-element-dialog">
    <div class="iframe-header">
        <div class="icon iframe-trigger-close">
            <i class="flaticon2-cross"></i>
        </div>
        <a class="out" href="#" target="_blank" data-open-popup>
            <i class="la la-external-link-alt"></i>
        </a>
    </div>
    <div class="sandy-dialog-body"></div>
</div>


<div data-popup=".new-social">
    <form action="{{ route('sandy-plugins-user_util-socials-post') }}" method="POST">
        @csrf
        <div class="form-input mb-5">
            <label>{{ __('Name') }}</label>
            <input type="text" name="name">
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
                <input type="text" name="icon">
            </div>
        </div>
        <div class="form-wrap mb-5" pickr>
            <label>{{ __('Solid Color') }}</label>
            <input pickr-input type="hidden" name="color" value="{{ '#000' }}">
            <div id="solid-background-color" pickr-div></div>
        </div>
        <div class="form-input mb-5">
            <label class="initial">{{ __('Address') }}</label>
            <input type="text" placeholder="{{ __('Ex: %s') }}" name="address">

            <p class="mt-4 text-xs italic">{{ __('(Note: example can be "https://twitter.com/%s". "%s" for user social info.)') }}</p>
        </div>
        <button class="button is-loader-submit loader-white">{{ __('Save') }}</button>
    </form>
</div>
@endsection