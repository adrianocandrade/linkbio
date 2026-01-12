@extends('mix::layouts.master')
@section('title', __('New App'))
@section('namespace', 'user-mix-app-new')
@section('content')

<form action="{{ route('user-mix-app-post') }}" method="post">
    @csrf

    <input type="hidden" value="{{ $slug }}" name="section">
    <div class="inner-page-banner">
        <h1>{{ get_bio_apps_content($slug, 'name') }}</h1>
        <p>{{ get_bio_apps_content($slug, 'description') }}</p>

        <div class="mt-4">
            <button class="button primary">{{ __('Save') }}</button>
        </div>
    </div>
    <div class="p-10">
        {!! $sections !!}
    </div>
</form>

@endsection
