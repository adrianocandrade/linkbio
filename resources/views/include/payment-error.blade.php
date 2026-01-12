@extends('index::layouts.master')
@section('title', __('Error'))
@section('content')

<style>
  header, footer{
    display: none !important;
  }
</style>
<div class="index-hero is-payment-error pt-20">
  
  <div class="index-hero-container">
    <div class="hero-right bg-white flex justify-center">
      <img src="{{ gs('assets/image/others', 'Asset-22@4x.png') }}" class="main-img h-full object-contain" alt="">
    </div>
    <div class="hero-left pt-10 md:pt-0">
      <h1 class="text-3xl mb-5">{{ __('An error occurred!') }}</h1>

      <h4 class="mb-5 font-bold text-xl">{{ $method ?? '' }}</h4>
      <p class="m-0 italic">({!! $error !!})</p>

      <a href="{{ url()->previous() }}" app-sandy-prevent="" class="text-sticker">{{ __('Go Back!') }}</a>
    </div>
    </div>
  </div>
  @stop