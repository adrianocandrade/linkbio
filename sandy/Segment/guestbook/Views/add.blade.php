@extends('mix::layouts.master')
@section('content')
<form action="{{ route('sandy-app-guestbook-create') }}" method="post">
    @csrf
    <div class="mix-padding-10">
        <div class="inner-page-banner rounded-2xl">
            {!! Elements::icon('guestbook') !!}
            <h1 class="mt-5 text-base">{{ Elements::config('guestbook', 'name') }}</h1>
            <p>{{ Elements::config('guestbook', 'description') }}</p>
            <div class="mt-4">
                <button class="text-sticker m-0">{{ __('Save') }}</button>
            </div>
        </div>

        <div class="mt-5 p-5 mort-main-bg rounded-2xl">
            <div class="card customize m-0 p-0">
                <div class="card-header">
                    <div class="form-input mb-7 text-count-limit" data-limit="60">
                        <label>{{ __('List Name') }}</label>
                        <span class="text-count-field"></span>
                        <input type="text" name="name" class="bg-w">
                    </div>
                    <div class="form-input text-count-limit" data-limit="200">
                        <label>{{ __('Description') }}</label>
                        <span class="text-count-field"></span>
                        <textarea rows="4" name="description" class="bg-w"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection