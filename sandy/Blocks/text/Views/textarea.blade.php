@extends('mix::layouts.master')
@section('title', __('New Block'))
@section('content')
@section('head')
<style>
.header, header, .floaty-bar{
  display: none !important;
}
#content{
  display: flex;
  flex-direction: column;
}
</style>
@stop
@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}" data-barba-script></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}" data-barba-script></script>
<script data-barba-script>
app.utils.Smalltinymce();
</script>
@stop
<form class="p-5 md:p-10" method="post" action="{{ route('sandy-blocks-text-post-new') }}">
    @csrf
    <div class="inner-pages-header mb-0">
        <div class="inner-pages-header-container mort-main-bg">
            
            <a class="previous-page" href="{{ get_previous('user-mix') }}" app-sandy-prevent="">
                <p class="back-button"><i class="la la-arrow-left"></i></p>
                <h1 class="inner-pages-title ml-3">{{ __('Back') }}</h1>
            </a>
            <button class="button rounded-none h-full text-xs w-half">{{ __('Save') }}</button>
        </div>
    </div>
    <div class="inner-page-banner rounded-2xl mb-10">
        <div class="flex items-center mb-3">
            <div class="h-avatar sm mr-3 bg-white border-0 is-video">
                <i class="sni sni-text c-black"></i>
            </div>
            <h1 class="mb-0 title text-lg">{{ __('Add Text') }}</h1>
        </div>
        <p>{{ __('A simple editor that allows you to enter plain text which can be bold, italic, or lists format. ') }}</p>
    </div>
    <div class="mort-main-bg rounded-2xl p-5 mb-7">
        
        <div class="form-input">
            <label for="">{{ __('Heading') }}</label>
            <input type="text" class="bg-w" name="heading">
        </div>
    </div>
    <div class="bio-tox is-white mort-main-bg rounded-2xl p-5">
        <textarea name="content" class="editor lol" placeholder="{{ __('Start typing with plain text') }}"></textarea>
    </div>
    <button class="button w-full mt-5">{{ __('Save') }}</button>
</form>
@endsection