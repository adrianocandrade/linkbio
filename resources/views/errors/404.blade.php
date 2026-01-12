@if($exception)
@extends('layouts.app')
@section('title', __('404'))
@section('content')
<div class="flex items-center justify-center min-h-40 h-screen bg-white text-body">
    <div class="text-center p-5 flex items-center flex-col justify-center">
        <img src="{{ \Bio::emoji('Eyes') }}" class="w-20 mb-5" alt="">
        <h1 class="text-xl font-medium mb-2">{{ __('Page not found') }}</h1>
        <div>{{ __('Sorry, the page you are looking for does not exists.') }}</div>

        <a href="{{ url('/') }}" class="button mt-4 w-full">{{ __('Back to Home') }}</a>
    </div>
</div>
@endsection
@else
@section('message', __('Not Found'))
@endif