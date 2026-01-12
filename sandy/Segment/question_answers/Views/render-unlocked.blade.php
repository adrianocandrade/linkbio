@extends('bio::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'assets-da3.css') }}">
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'response-asset.css') }}">
@stop
@section('is_element', true)
<div class="context bio h-screen p-5 is-element flex flex-col">
    <div class="questions-header mt-10">
        <div class="card-shadow p-10 rounded-2xl">

            <div class="mb-5 font-bold text-base text-white">
                {{ __('Ask your Question') }}
            </div>
            
            <form method="post" action="{{ route('sandy-app-question_answers-paid-question-ask', ['slug' => $element->slug, 'sxref' => request()->get('sxref')]) }}">
                @csrf
                <div class="text-center">
                    <div class="form-input mb-5">
                        <label>{{ __('Question') }}</label>
                        <textarea name="question" cols="30" class="bg-dark" rows="10"></textarea>
                    </div>
                    <div class="form-input">
                        <label>{{ __('Name') }}</label>
                        <input type="text" name="name" class="bg-dark">
                    </div>
                    <button class="button mt-5 w-full">{{ __('Post') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection