@extends('admin::layouts.master')
@section('title', __('User Fonts'))
@section('content')
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
@section('headJS')

{!! fonts('html') !!}
@stop
<div class="sandy-page-row justify-center">
    <div class="sandy-page-col pl-0">
        <div class="page__head">
            <div class="step-banner remove-shadow">
                <div class="section-header block md:flex">
                    <div class="section-header-info">
                        <p class="section-pretitle">{{ __('Add up to 1k Google Fonts') }}</p>
                        <h2 class="section-title">{{ __('Fonts') }}</h2>
                        <p class="text-xs italic">{{ __('(Note: This page is very heavy due to the amounts of fonts being loaded from google servers.)') }}</p>
                    </div>
                    <div class="section-header-actions md:w-1/4 md:justify-end mt-5 md:mt-0 mb-0">
                        <div class="notifications__tags m-0">
                            <a class="notifications__link active" app-sandy-prevent="" iframe-trigger="" href="{{ route('sandy-plugins-user_util-fonts-new') }}">{{ __('Add Fonts') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-trans rounded-2xl">
            <p class="text-xs italic">{{ __('(Note: Reorder fonts by dragging each font card.)') }}</p>

            <div class="grid mt-5 sm:grid-cols-2 lg:grid-cols-3 gap-4 sortable" data-route="{{ route('sandy-plugins-user_util-fonts-sort') }}">
                @foreach (fonts() as $key => $value)
                <label class="sandy-big-radio sortable-item" data-id="{{ $key }}">
                    <div class="radio-select-inner font rounded-2xl">
                        <h1 class="{{ slugify($key) }}-font-preview text-sm">{{ $key }}</h1>
                        <p class="font-preview {{ slugify($key) }}-font-preview">{{ __($value['text'] ?? 'The quick brown fox') }}</p>
                        <div class="flex">
                            
                            <form action="{{ route('sandy-plugins-user_util-fonts-delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="font" value="{{ $key }}">

                                <button class="text-xs text-sticker bg-red-500 text-white is-loader-submit loader-white flex items-center mt-5" data-delete="{{ __('Are you sure you want to remove this font?') }}">{{ __('Remove') }}</button>
                            </form>
                        </div>
                    </div>
                </label>
                @endforeach
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
@endsection