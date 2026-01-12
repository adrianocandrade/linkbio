@extends('mix::layouts.master')
@section('title', __('No Plan'))
@section('head')
  <style>
    .header, header, .floaty-bar{
      display: none !important;
    }

    #content{
      display: flex;
      justify-content: center;
      flex-direction: column;
    }
  </style>
@stop
@section('content')
<div class="is-empty p-10 md:p-20 mt-20 text-center flex flex-col justify-center items-center">
    <img src="{{ \Bio::emoji('Crying_Face') }}" class="w-20" alt="">
    <p class="text-lg mt-10 font-bold">{{ __('Hold on, before you proceed!') }}</p>


    <p class="mt-1 text-sm text-gray-400">{{ __('Please take a moment to activate our default plan to continue using the platform.', ['user_name' => $user->name]) }}</p>
    <div class="flex flex-col w-full">
        @if ($plan = \App\Models\Plan::where('defaults', 1)->where('status', 1)->first())
            <a href="{{ route('user-mix-purchase-plan', $plan->id) }}" app-sandy-prevent="" class="button w-full mt-7">{{ __('Activate our default Plan') }}</a>
            <p class="my-7 italic text-xs">{{ __('Or') }}</p>
        @endif
        <a href="{{ route('pricing-index') }}" app-sandy-prevent="" class="button mt-5">{{ __('Checkout our pricing') }}</a>
    </div>
</div>
@endsection