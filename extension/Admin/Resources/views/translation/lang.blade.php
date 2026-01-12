@extends('admin::layouts.master')
@section('title', __('All Languages'))
@section('namespace', 'admin-translation')
@section('content')
<div class="step-banner">
   <div class="section-header">
      <div class="section-header-info">
         <p class="section-pretitle">{{ __('Languages') }} ({{ count($languages) }})</p>
         <h2 class="section-title">{{ __('All Languages') }}</h2>
      </div>
      <div class="section-header-actions">
         <a class="section-header-action cursor-pointer new-lang-open">{{ __('Create New Translation') }} +</a>
      </div>
   </div>
</div>
@if (count($languages) > 0)
<div class="grid md:grid-cols-4 gap-4">
   @foreach ($languages as $item)
   <div class="flex">
      <div class="widget w-full widget_chart card card_widget card-inherit widget_purple">
         <div class="widget__title color-white capitalize">{{ $info($item, 'filename') }}</div>
         <div class="widget__wrap">
            <div class="details__list details__list_four card-shadow rounded-4xl border-0">
               <div class="details__item rounded-4xl">
                  <div class="block">
                     <i class="sio design-and-development-048-text-tool text-2xl sligh-thick"></i>
                  </div>
                  <div class="details__head">
                     <div class="details__text caption-sm">{{ __('Translations') }}</div>
                  </div>
                  <div class="details__counter h3">{{ $info($item, 'count-lang') }}</div>
                  <div class="details__indicator">
                     <div class="details__progress bg-purple" style="width: 55%;"></div>
                  </div>
               </div>
            </div>
            <div class="widget__btns">
               <a href="{{ route('admin-duplicate-language', $info($item, 'filename')) }}" class="text-sticker mb-5" app-sandy-prevent>
                  {{ __('Duplicate') }}
               </a>
               <div class="grid grid-cols-2 gap-2">
                  <a href="{{ route('admin-view-translation', $info($item, 'filename')) }}" class="button">{{ __('Edit') }}</a>
                  <a class="button danger" app-sandy-prevent href="{{ route('admin-delete-language', $info($item, 'filename')) }}" data-delete="{{ __('Are you sure you want to delete this item?') }}">{{ __('Delete') }}</a>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endforeach
</div>
@else
@include('include.is-empty')
@endif
<div data-popup=".new-lang">
   <div class="inner-page-banner mb-10">
      <h1>{{ __('New Language') }}</h1>
      <p>{{ __('Translation value') }}</p>
   </div>
   <form action="{{ route('admin-new-language') }}" method="post">
      @csrf
      <div class="form-input">
         <label>
            {{ __('Language Name') }}
         </label>
         <input name="name" type="text">
      </div>
      <button class="button main mt-5" type="submit">{{ __('Save') }}</button>
   </form>
   
   <button class="new-lang-close" data-close-popup><i class="flaticon-close"></i></button>
</div>
@endsection