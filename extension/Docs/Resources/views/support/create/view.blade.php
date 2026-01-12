@extends('docs::layouts.master')
@section('title', __('Submit Support'))
@section('content')
<div class="p-5 md:px-32 md:pt-10 relative">
      @if (!plan('settings.support'))
         @include('include.no-plan')
      @endif
   <div class="inner-page-banner preview flex rounded-2xl">
      <div class="thumbnail">
         <div class="thumbnail-inner">
            <div class="thumbnail h-avatar is-elem md is-video">
               <i class="sio shopping-icon-099-support"></i>
            </div>
         </div>
      </div>
      <div class="content">
         <h4 class="title">{{ __('Create Support') }}</h4>
         <p>{{ __('Having issues with our site? Create a support ticket now!') }}</p>
      </div>
   </div>
   <div class="mt-5 rounded-2xl mort-main-bg p-5">
      <form action="{{ route('user-support-create') }}" method="post">
         @csrf
         <div class="form-input">
            <label>{{ __('Subject') }}</label>
            <input type="text" name="subject" class="bg-w">
         </div>
         <div class="form-input mt-5 text-count-limit" data-limit="200">
            <label>{{ __('Describe your issue') }}</label>
            <span class="text-count-field"></span>
            <textarea name="description" id="" cols="30" rows="10" class="bg-w"></textarea>
         </div>
         <button class="mt-5 text-sticker">{{ __('Submit') }}</button>
      </form>
   </div>
</div>
@endsection