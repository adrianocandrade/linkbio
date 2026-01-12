@extends('mix::layouts.master')
@section('title', __('New Block'))
@section('head')
<style>
.header, header, .floaty-bar{
display: none !important;
}
#content{
display: flex;
justify-content: center;
flex-direction: column;
}
</style>
@stop
@section('content')
<form method="post" action="{{ $route }}" class="mix-padding-10 w-full" enctype="multipart/form-data">
  @csrf
  @if (!empty(request()->input('blocks.heading')))
  <input type="hidden" name="blocks[heading]" value="{{ request()->input('blocks.heading') }}">
  @endif
  @if (!empty(request()->input('blocks.subheading')))
  <input type="hidden" name="blocks[subheading]" value="{{ request()->input('blocks.subheading') }}">
  @endif

  <div class="inner-pages-header mb-0">
    <div class="inner-pages-header-container mort-main-bg">
      <a class="previous-page" href="{{ get_previous('user-mix') }}" app-sandy-prevent="">
        <p class="back-button"><i class="la la-arrow-left"></i></p>
        <h1 class="inner-pages-title ml-3">{{ __('Back') }}</h1>
      </a>
      <button class="button rounded-none h-full text-xs w-half">{{ __('Save') }}</button>
    </div>
  </div>

  <div class="inner-page-banner mb-10 rounded-2xl">
    <div class="flex items-center mb-3">
      <div class="h-avatar sm mr-3 bg-white border-0 is-video">
        {!! svg_i(config('blocks.lists.svg_i'), 'w-8 h-4') !!}
      </div>
      <h1 class="mb-0 title text-lg">{{ __('Add List(s)') }}</h1>
    </div>
    <p>{{ __('Let your visitors see more with our list block. A more beautiful way to post texts and image on links.') }}</p>
  </div>
  <div class="grid grid-cols-2 gap-4 mb-5">
    
    <div class="form-input">
      <label>{{ __('List Caption') }}</label>
      <input type="text" name="content[heading]">
    </div>
    <div class="form-input">
      <label>{{ __('Describe the list') }}</label>
      <input type="text" name="content[subheading]">
    </div>
  </div>
  <div class="h-avatar h-32 w-full is-upload is-outline-dark text-2xl sandy-upload-modal-open">
    <div class="lozad image"></div>
    <i class="flaticon-upload-1"></i>
  </div>
  {!! Blocks::LinkOrElementHtml($user->id, ['element' => '']) !!}
  
  {!! sandy_upload_modal() !!}
  <button class="button w-full mt-5 is-loader-submit">{{ __('Save') }}</button>
</form>
@endsection