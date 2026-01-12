@extends('mix::layouts.master')
@section('title', __('Purchase Plan'))
@section('namespace', 'user-mix-purchase-plan')
@section('content')
<div class="inner-page-banner mb-10">
    <h1><i class="sio seo-and-marketing-068-package-box text-3xl mr-2"></i> {{ $plan->name }}</h1>
    <p>{{ ao($plan->extra, 'description') }}</p>

    <p class="mt-5 italic text-xs">{{ __('(Note: you are about to activate our free plan. This will cancel any other active plan you have.)') }}</p>
</div>
<div class="summary card md:mx-24 mx-6 mb-10">
    <div class="card-shadow p-5 rounded-3xl">
        <div class="card-header mort-main-bg mb-5 p-5 rounded-3xl">
            <p class="title">{{ __('Summary') }}</p>
        </div>
        <div class="flex justify-between mb-5">
            <span class="text-muted text-sm font-bold">{{ __('Plan') }}</span>
            <span class="text-sm">{{$plan->name}}</span>
        </div>
        <div class="flex justify-between mb-5">
            <span class="text-sm font-bold">{{ __('Duration') }}</span>
            <span class="data-duration text-sm text-right">
                <span class="name">{{ __('Forever') }}</span>
            </span>
        </div>

        <!-- Captcha -->

        <!-- Captcha -->

        <form action="{{ route('user-mix-activate-plan-free', $plan->id) }}" method="POST" class="proceed-form">
            @csrf

            <button data-delete="{{ __('Are you sure you want to activate our free plan or join our pro\'s?') }}" data-title="{{ __('Proceed?') }}" data-confirm-btn="{{ __('Yes, Proceed') }}" data-confirm-btn-color="text-green-500" class="button sandy-quality-button mt-0 is-loader-submit loader-white">{{ __('Activate our free plan.') }}</button>
        </form>
    </div>
</div>
@endsection