@extends('index::layouts.master')
@section('title', __('Offline'))
@section('content')
<style>
header, footer{
display: none !important;
}
</style>
<div class="index-hero is-payment-error pt-20">
    
    <div class="index-hero-container flex flex-col justify-center items-center">

        <div class="">
            <img src="{{ emoji('Yellow-1/Sad', 'png') }}" class="w-24" alt="">
        </div>


        <div class="mt-4 text-center">
            <div class="font-bold text-lg">{{ __('Whoops! You are offline.') }}</div>
            <p class="text-sm text-gray-400">{{ __('Connect to a network to continue viewing this page.') }}</p>
        </div>
    </div>
</div>
@stop