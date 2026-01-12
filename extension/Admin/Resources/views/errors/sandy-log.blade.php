@extends('admin::layouts.master')
@section('title', __('Error Logs'))
@section('content')

<div class="sandy-page-row">
  <div class="sandy-page-col pl-0">
    <div class="page__head">
      <div class="step-banner remove-shadow">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle">{{ __('Error Logs') }}</p>
            <h2 class="section-title text-base">Location - <b>storage / logs / sandy.log</b></h2>
          </div>
        </div>
      </div>
    </div>

    <div class="whitespace-pre-wrap card-shadow p-5 rounded-2xl">
      {!! $logs !!}
    </div>
  </div>
  <div class="sandy-page-col sandy-page-col_pt100">
    <div class="card card_widget">
      <div class="flex items-center mb-5">
        <i class="text-2xl sio banking-finance-flaticon-097-information-sign mr-3"></i>
        <p>{{ __('Info') }}</p>
      </div>

      <p class="text-xs italic">{{ __('(Note: This catch all exceptions & log them to sandy.log which can be accessed in this page or manually in: storage / logs / sandy.log)') }}</p>
      
      <div class="flex items-center mt-5">
        <i class="text-2xl sio professions-007-phone-operator mr-3"></i>
        <p>{{ __('Wanna log an error to me? Do it here!') }}</p>
      </div>

      <a class="button sandy-quality-button bg-black mt-5" target="_blank" href="support.sandydev.com">{{ __('Submit here!') }}</a>
    </div>
  </div>
</div>
@endsection