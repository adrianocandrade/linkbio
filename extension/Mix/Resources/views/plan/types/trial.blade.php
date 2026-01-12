@extends('mix::layouts.master')
@section('title', __('Purchase Plan'))
@section('namespace', 'user-mix-purchase-plan')
@section('content')
<div class="inner-page-banner mb-10">
    <h1 class="text-lg"><i class="sio seo-and-marketing-068-package-box text-3xl mr-2"></i> {!! __('Try out our :duration days :plan_name for Free!', ['duration' => ao($plan->price, 'trial_duration'), 'plan_name' => '<b>'.$plan->name.'</b>']) !!}</h1>
    <p>{{ ao($plan->extra, 'description') }}</p>
    <p class="mt-5 italic text-xs">{{ __('(Note: you are about to activate our trial plan. This will cancel any other active plan you may have.)') }}</p>
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
                <span class="name">{{ __(':duration Days', ['duration' => ao($plan->price, 'trial_duration')]) }}</span>
            </span>
        </div>
        <!-- Captcha -->
        <!-- Captcha -->
        @if (!\App\Models\PlansHistory::where('user_id', $user->id)->where('plan_id', $plan->id)->first())
        <form action="{{ route('user-mix-activate-plan-trial', $plan->id) }}" method="POST" class="proceed-form">
            @csrf
            <button data-delete="{{ __('Are you sure you want to activate this plan?') }}" data-title="{{ __('Proceed?') }}" data-confirm-btn="{{ __('Yes, Proceed') }}" data-confirm-btn-color="text-green-500" class="button sandy-quality-button mt-0 is-loader-submit loader-white">{{ __('Activate') }}</button>
        </form>
        @else
        <div class="proceed-form">
            <button class="button sandy-quality-button mt-0 is-loader-submit loader-white" disabled="">{{ __('Trial already taken') }}</button>
        </div>
        @endif
    </div>
</div>
@endsection