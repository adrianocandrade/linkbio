@extends('mix::layouts.master')
@section('title', __('Edit Block'))
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
@section('content')
<form method="post" action="{{ route('user-mix-block-element-edit', $block->id) }}" class="mix-padding-10 w-full" enctype="multipart/form-data">
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
    <div class="h-avatar h-32 w-full is-upload is-outline-dark text-2xl mb-5 sandy-upload-modal-open">
      <?= media_or_url($block->thumbnail, 'media/blocks', true) ?>

      <div class="sandy-file-name"></div>
    </div>
  <div class="grid grid-cols-2 gap-4 mt-5">
    
    <div class="form-input col-span-2">
      <label>{{ __('Slider Caption') }}</label>
      <input type="text" name="content[heading]" value="{{ ao($block->content, 'heading') }}">
    </div>
  </div>


  {!! sandy_upload_modal($block->thumbnail, 'media/blocks') !!}
  <button class="button w-full mt-5 is-loader-submit">{{ __('Save') }}</button>
</form>
@endsection