@extends('layouts.app')
@section('title', __('Auth'))
@section('content')
<div class="yetti-auth-box">
  <div class="yetti-auth-header text-left items-start">
    <div class="text-center">
      <img src="https://external-preview.redd.it/DNllPxmZJ9PWhJNH18C5IKyg1FhamTQ8pooP_Z7hNhk.jpg?auto=webp&s=51e7066dc50c2196201af207316553d1bf42f4b3" class="w-20 mx-auto" alt="">
      <div class="yetti-auth-title">Yetti</div>
      <div class="yetti-auth-description">Create a one page site to share your favourite links, photos, videos, and more with your audience</div>
    </div>
    <div class="flex gap-4 mt-10 w-full">
      
      <a href="{{ route('user-login') }}" class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-5">{{ __('Login') }}</a>
      <a href="{{ route('user-register') }}" class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-5">{{ __('Register') }}</a>
    </div>
    <div class="mt-3 flex items-center">
      
      <div class="text-xs text-gray-400">{{ __('Sign up for free to start creating awesome pages.') }}</div>
      <img data-src="{{ \Bio::emoji('Smiling_Face_with_Heart_Eyes') }}" class="lozad w-7 ml-1" alt=" ">
    </div>
  </div>
  <div class="entry-circles">
    <div class="entry-circle"></div>
    <div class="entry-circle"></div>
    <div class="entry-circle"></div>
    <div class="entry-circle"></div>
    <div class="entry-circle"></div>
  </div>
</div>
@endsection