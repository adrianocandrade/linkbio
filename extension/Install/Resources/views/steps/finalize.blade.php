@extends('install::layouts.master')
@section('title', 'Finalize')
@section('content')
<div class="m-auto">
    <div class="relative z-50">
        
        <div class="card is-install-card card_widget mx-5 md:mx-20 p-0 card-shadow">
            <div class="card-container">

                <div class="side-cta is-small">
                    <img src="{{ gs('assets/image/others/Asset-555.png') }}" alt="">
                </div>
            <div class="flex items-center mb-5">
                <i class="text-4xl mr-3">🎉</i>
            </div>
            <p class="mb-7 text-base font-bold">Success 🎉</p>
            <div class="mb-5 text-sm relative z-50">
                Rio has been installed. Here are some useful links to get started with.
            </div>

            <a class="mb-5 text-link block" href="https://sandydev.com/docs" target="_blank">Docs</a>
            <div class="flex relative z-50">
                <a class="ml-auto text-sticker" href="{{ Route::has('user-mix') ?  route('user-mix') : url('/') }}">{{ __('Start Mixing!') }}</a>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection