@extends('mix::layouts.master')
@section('title', __('New Block'))
@section('content')
<div class="inner-page-banner m-5 md:m-10 mb-5 md:mb-0 rounded-2xl">
  <div class="flex items-center mb-3">
    <div class="h-avatar sm mr-3 bg-white border-0 is-video">
      {!! svg_i(config('blocks.course.svg_i'), 'w-8 h-4') !!}
    </div>
    <h1 class="mb-0 title text-lg">{{ __('Course') }}</h1>
  </div>
  <p>{{ __('Let your visitors buy & take courses directly from your bio.') }}</p>
</div>
<form class="links-accordion mix-padding-10" method="post" action="{{ route('user-mix-block-element-post', 'course') }}">
  @csrf
  <div class="sandy-accordion mort-main-bg">
    <div class="sandy-accordion-head flex">
      <span>{{ __('Heading') }}</span>
    </div>
    <div class="sandy-accordion-body mt-5 pb-0" id="take-input">
      <div class="form-input mb-5">
        <label>{{ __('Heading') }}</label>
        <input type="text" name="blocks[heading]" class="bg-w">
      </div>
      <div class="form-input">
        <label>{{ __('Sub Heading') }}</label>
        <textarea name="blocks[subheading]" cols="5" class="bg-w" rows="2"></textarea>
      </div>
    </div>
  </div>
  
  <button class="mt-5 text-sticker sandy-loader-flower">{{ __('Save') }}</button>
</form>
@endsection