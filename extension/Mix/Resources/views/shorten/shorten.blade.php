@extends('mix::layouts.master')
@section('content')
<div class="mix-padding-10">
    <div class="inner-page-banner rounded-2xl">
        <h1>{{ __('Shorten') }}</h1>
        <p>{{ __('Shorten links by transforming any url to a shorter version. When someone clicks the shortened link, they are taken to the original url while tracking their activity.') }}</p>
    </div>
    <div class="mt-5">
        <div class="p-0 z-50 relative rounded-2xl">
            <form method="POST" action="{{ route('user-mix-shorten-post') }}" class="step-banner m-0 has-cta-bg-shade" bg-style="rgb(215 218 220)">
                 @csrf
                <div class="cta-background-shade">
                    <img src="{{ gs('assets/image/others/index-cta-bg.png') }}" alt="">
                </div>
                <div class="form-input z-10 relative">
                    <label>{{ __('Enter link') }}</label>
                    <input type="text" name="link" class="text-black bg-w">
                </div>
                <button class="text-sticker text-black mt-5 z-10 relative is-loader-submit">{{ __('Generate') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection