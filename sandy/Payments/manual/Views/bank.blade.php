@extends('index::layouts.master')
@section('title', __('Manual Payment'))
@section('content')
<style>
header, footer{
display: none !important;
}
</style>
<div class="index-hero is-payment-error">
  
  <div class="index-hero-container h-auto mt-20">
    <div class="hero-left pt-10 md:p-0 m-auto h-full w-full">
      <div class="h-avatar bg-white is-video mb-5">
        <img src="{{ gs('assets/image/payments', 'manual-bank-logo.png') }}" alt="">
      </div>
      <p class="m-0 font-bold">{{__('Please fill in the info below.')}}</p>

      <p class="mt-5 mb-0">{{ __('Info :') }}</p>
      <p class="mb-0 italic underline text-sm">({!! clean(settings('payment_manual.details'), 'titles') !!})</p>
      <form class="mt-5" action="{{ route('sandy-payments-manual-pending-create', ['sxref' => $sxref]) }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-4">
          <div class="form-input">
            <label for="">{{ __('Email') }}</label>
            <input type="text" name="email" value="{{ $spv->email }}">
          </div>
          
          <div class="form-input">
            <label>{{ __('Name') }}</label>
            <input type="text" name="name" value="{{ user('name') }}">
          </div>
          
          <div class="form-input col-span-2">
            <label>{{ __('Bank') }}</label>
            <input type="text" name="bank_name">
          </div>
          <div class="col-span-2 sm:col-span-1">
            <div class="h-avatar h-56 w-full is-upload is-outline-dark text-2xl mb-5 active" data-generic-preview=".h-avatar">
              <i class="flaticon-upload-1"></i>
              <input type="file" name="proof">
              <div class="image"></div>
            </div>
            
            <p class="mt-5 mb-0 italic underline text-sm">({{__('Note: Image should not exceed :mb in size.', ['mb' => '1mb'])}})</p>
          </div>
        </div>
        <button class="text-sticker mt-5">{{ __('Proceed') }}</button>
      </form>

      @if (!$pending->isEmpty())
      <div class="title-sections mt-10">
          <h2 class="text-base">{{ __('Pending Requests') }}</h2>
      </div>
      <div class="flex-table card-elements mort-main-bg w-full md:w-3/4 border-0 mt-4 p-10">
        <!--Table header-->
        <div class="flex-table-header">
          <span class="is-grow">{{ __('Label') }}</span>
          <span>{{ __('Date') }}</span>
          <span>{{ __('Status') }}</span>
          <span class="cell-end">{{ __('Actions') }}</span>
        </div>
        
        @foreach ($pending as $item)
        <div class="flex-table-item shadow-none card-titles">
          <div class="flex-table-cell is-media is-grow" data-th="">
            <div>
              <a href="{{ gs('media/site/manual-payment', ao($item->info, 'proof')) }}" target="_blank" class="thumbnail h-avatar is-elem md is-video">
                <img class="lozad object-cover h-full" data-src="{{ gs('media/site/manual-payment', ao($item->info, 'proof')) }}">
              </a>
            </div>
            <div class="ml-auto md:ml-0">
              <span class="title">{{ $plan->name }}</span>
              <span class="item-meta">
                <span>{{ $item->duration }}</span>
              </span>
            </div>
          </div>
          <div class="flex-table-cell" data-th="{{ __('Date') }}">
            <span class="light-text">{{ Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
          </div>
          <div class="flex-table-cell" data-th="{{ __('Status') }}">
            <span class="dark-inverted is-weight-600">{{$item->status == 0 ? 'Pending' : NULL}} {{$item->status == 1 ? 'Activated' : NULL }} {{$item->status == 2 ? 'Declined' : NULL }}</span>
          </div>
          <div class="flex-table-cell cell-end" data-th="{{ __('Actions') }}">

            <form action="{{ route('sandy-payments-manual-pending-delete', ['id' => $item->id, 'sxref' => $sxref]) }}" method="post">
              
              @csrf
              <button data-title="{{ __('Delete') }}" data-delete="{{ __('Are you sure you want to delete this?') }}" class="text-sticker"><i class="flaticon-delete"></i></button>
            </form>
          </div>
        </div>
        @endforeach
      </div>
      @else

      @endif
      <a href="{{ route('pricing-index') }}" class="mt-10 mb-10 text-sticker">{{ __('Back to Pricing') }}</a>
    </div>
  </div>
</div>
@stop