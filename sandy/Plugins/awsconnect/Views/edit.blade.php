@extends('admin::layouts.master')
@section('title', __('Aws Connect'))
@section('content')
<div class="sandy-page-row">
  <div class="sandy-page-col pl-0">
    <div class="page__head">
      
      <div class="step-banner">
        <div class="page__title h2 m-0">{{ __('S3 Connect') }}</div>
        <p class="mt-4">{{ __('Connect to your aws s3 bucket with this plan.') }}</p>
      </div>
    </div>
    <form method="post" action="{{ route('sandy-plugins-awsconnect-edit-post') }}">
      @csrf
      <div class="col-span-2">
        <div class="card-shadow rounded-2xl p-5">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mort-main-bg p-5 mb-10 rounded-2xl">
            <div class="form-input">
              <label class="initial">{{ __('Enable aws') }}</label>
              <select name="env[FILESYSTEM]" class="bg-w">
                @foreach (['s3' => 'Aws Connect Enable', 'local' => 'Aws Connect Disable'] as $key => $value)
                <option value="{{ $key }}" {{ config('app.FILESYSTEM') == $key ? 'selected' : '' }}>
                  {{ __($value) }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-input">
              <label class="initial">{{ __('Use Assets from aws') }}</label>
              <select name="env[AWS_ASSETS]" class="bg-w">
                @foreach (['0' => 'Use local assets', '1' => 'Use assets in aws'] as $key => $value)
                <option value="{{ $key }}" {{ config('app.AWS_ASSETS') == $key ? 'selected' : '' }}>
                  {{ __($value) }}
                </option>
                @endforeach
              </select>
              <p class="text-xs italic mt-5">{{ __('(Note: this will completely change all assets url to aws. Do well to move your "assets" folder to aws before using.)') }}</p>
            </div>
          </div>
          <!-- FileSystem.S3:START -->
          <div class="popup__label">{{ __('Amazone s3') }}</div>
          <div class="grid md:grid-cols-2 gap-4 mort-main-bg p-5 rounded-2xl mb-10">
            <div class="form-input">
              <label>{{ __('Access key id') }}</label>
              <input type="text" name="env[AWS_ACCESS_KEY_ID]" value="{{ config('app.AWS_ACCESS_KEY_ID') }}" class="bg-w">
            </div>
            <div class="form-input">
              <label>{{ __('Secret access key id') }}</label>
              <input type="text" name="env[AWS_SECRET_ACCESS_KEY]" value="{{ config('app.AWS_SECRET_ACCESS_KEY') }}" class="bg-w">
            </div>
            <div class="form-input">
              <label>{{ __('Defualt region') }}</label>
              <input type="text" name="env[AWS_DEFAULT_REGION]" value="{{ config('app.AWS_DEFAULT_REGION') }}" class="bg-w">
            </div>
            <div class="form-input">
              <label>{{ __('Bucket') }}</label>
              <input type="text" name="env[AWS_BUCKET]" value="{{ config('app.AWS_BUCKET') }}" class="bg-w">
            </div>
          </div>
          <!-- FileSystem.S3:END -->
          <button class="button">{{ __('Save') }}</button>
        </div>
      </div>
    </form>
  </div>
  <div class="sandy-page-col sandy-page-col_pt100">
    <div class="card card_widget">
      <div class="flex items-center">
        <i class="text-2xl sio banking-finance-flaticon-097-information-sign mr-3"></i>
        <p>{{ __('Info') }}</p>
      </div>
      
      <a class="text-xs italic mt-5 text-link" href="#">{{ __('Visit our documentation for help.') }}</a>

      <p class="text-xs italic mt-5">{{ __('(Note: due to cors issues on some browsers the "use assets in aws" option might not work as expected.)') }}</p>


      <p class="text-xs italic mt-5">{{ __('Please properly check your credentials before enabling this plugin. Do well to use the button below to validate login before enabling. This uses a simple file upload test to validate the connection.') }}</p>


      <form class="mt-5" action="{{ route('sandy-plugins-awsconnect-test-con') }}" method="POST">
        @csrf
        <button class="text-sticker is-submit is-loader-submit mb-0">{{ __('Test connection') }}</button>
      </form>

      <p class="text-xs italic mt-5">{{ __('Important so it wont lead to errors.') }}</p>
    </div>
  </div>
</div>
@endsection