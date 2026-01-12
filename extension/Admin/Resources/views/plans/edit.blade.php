@extends('admin::layouts.master')
@section('title', __('Edit Plan'))
@section('content')
<div class="sandy-page-row">
  <div class="sandy-page-col pl-0">
    <div class="page__head">
      <div class="step-banner remove-shadow">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle">{{ __('Plans') }} ({{ number_format(\App\Models\Plan::count()) }})</p>
            <h2 class="section-title">{{ __('Edit Plan') }}</h2>
          </div>
          <div class="section-header-actions">
            <a href="{{ route('admin-plans') }}" class="section-header-action">{{ __('All Plans') }}</a>
          </div>
        </div>
      </div>
    </div>
    <form method="post" action="{{ route('admin-edit-plan-post', $plan->id) }}" class="rounded-3xl card-shadow p-8">
      @csrf
      
      <div class="card cuztomize mb-5 p-5 mort-main-bg rounded-2xl">
        <div class="form-input">
          <label>{{ __('Name') }}</label>
          <input type="text" name="name" value="{{ $plan->name }}" class="bg-w">
        </div>
        <div class="form-input mt-5">
          <label class="initial">{{ __('Plan type') }}</label>
          <select name="type" class="bg-w" data-sandy-select=".select-shift">
            <option value="paid" {{ $plan->price_type == 'paid' ? 'selected' : '' }}>{{ __('Paid') }}</option>
            <option value="free" {{ $plan->price_type == 'free' ? 'selected' : '' }}>{{ __('Free forever') }}</option>
            <option value="trial" {{ $plan->price_type == 'trial' ? 'selected' : '' }}>{{ __('Free trial') }}</option>
          </select>
        </div>
        <div class="select-shift mt-5">
          <div data-sandy-open="paid">
            <div class="grid grid-cols-2 gap-4">
              <div class="form-input">
                <label>{{ __('Monthly Price') }}</label>
                <input type="text" value="{{ $settings($plan->price, 'monthly') }}" name="price[monthly]" class="bg-w">
              </div>
              <div class="form-input">
                <label for="">{{ __('Annual Price') }}</label>
                <input type="text" name="price[annually]" value="{{ $settings($plan->price, 'annually') }}" class="bg-w">
              </div>
            </div>
          </div>
          <div data-sandy-open="free">
          </div>
          <div data-sandy-open="trial">
            <div class="form-input">
              <label>{{ __('Trial duration') }}</label>
              <input type="text" name="price[trial_duration]" value="{{ $settings($plan->price, 'trial_duration') }}" class="bg-w">
            </div>
          </div>
        </div>
        <div class="form-input mt-5">
          <label class="initial">{{ __('Status') }}</label>
          <select name="status" class="bg-w">
            <option value="1" {{ $plan->status ? 'selected' : '' }}>{{ __('Active') }}</option>
            <option value="0" {{ !$plan->status ? 'selected' : '' }}>{{ __('Hidden') }}</option>
          </select>
        </div>
        <div class="form-input mt-5 text-count-limit" data-limit="250">
          <label for="">{{ __('Describe this plan') }}</label>
          <span class="text-count-field"></span>
          <textarea name="extra[description]" class="bg-w" cols="30" rows="10">{{ ao($plan->extra, 'description') }}</textarea>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
          
          <div class="card customize mt-5 mb-0">
            <div class="card-header">
              <p class="subtitle text-xs">{{ __('Set this plan as featured.') }}</p>
              <p class="text-xs italic mt-3">{{ __('(Note: only one plan can be featured.)') }}</p>
              <div class="custom-switch mt-3">
                <input type="hidden" name="extra[featured]" value="0">
                <input type="checkbox" class="custom-control-input" name="extra[featured]" id="plan-featured" value="1" {{ ao($plan->extra, 'featured') ? 'checked' : '' }}>
                <label class="custom-control-label" for="plan-featured"></label>
              </div>
            </div>
          </div>
          <div class="card customize mt-5 mb-0">
            <div class="card-header">
              <p class="subtitle text-xs">{{ __('Set this plan as default plan on registration or first login.') }}</p>
              <div class="custom-switch mt-3">
                <input type="hidden" name="defaults" value="0">
                <input type="checkbox" class="custom-control-input" name="defaults" id="plan-default" value="1" {{ $plan->defaults ? 'checked' : '' }}>
                <label class="custom-control-label" for="plan-default"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($skeleton as $key => $value)
        <label class="sandy-big-checkbox">
          <input type="hidden" name="settings[{{$key}}]" value="0">
          <input type="checkbox" name="settings[{{$key}}]" class="sandy-input-inner" value="1" {{ $settings($plan->settings, $key) ? 'checked' : '' }}>
          <div class="checkbox-inner">
            <div class="checkbox-wrap">
              <div class="content">
                <h1>{{ __($value['name'] ?? '') }}</h1>
                <p>{{ __($value['description'] ?? '') }}</p>
              </div>
              <div class="icon">
                <div class="active-dot">
                  <i class="la la-check"></i>
                </div>
              </div>
            </div>
          </div>
        </label>
        @endforeach
      </div>
      <div class="my-5 p-5 card mort-main-bg rounded-2xl">
        <div class="grid grid-cols-2 gap-4">
          <div class="form-input">
            <label>{{ __('Blocks Limit') }}</label>
            <input type="text" value="{{ $settings($plan->settings, 'blocks_limit') }}" name="settings[blocks_limit]" class="bg-w">
            <p class="italic mt-4 text-xs">{{ __('(Note: Min is 1)') }}</p>
          </div>
          <div class="form-input">
             <label>{{ __('Workspaces Limit') }}</label>
             <input type="text" value="{{ $settings($plan->settings, 'workspaces_limit') }}" name="settings[workspaces_limit]" class="bg-w">
             <p class="italic mt-4 text-xs">{{ __('(Note: Min is 1)') }}</p>
          </div>
          <div class="form-input">
            <label>{{ __('Pixel Limit') }}</label>
            <input type="text" value="{{ $settings($plan->settings, 'pixel_limit') }}" name="settings[pixel_limit]" class="bg-w">
          </div>
        </div>
      </div>
      <div class="promotion__body px-0 pb-0">
        <div class="promotion__text text-xs italic">{{ __('(Note: The prices are based on the currency & payment method selected in the settings. This script does not provide a currency converter.)') }}</div>
        <button class="text-sticker is-submit is-loader-submit loader-white button">{{ __('Save') }}</button>
      </div>
    </form>
  </div>
  <div class="sandy-page-col sandy-page-col_pt100 px-10">
    <div class="card card_widget desktop-hide">
      <div class="card__head card__head_mb32">
        <div class="card__title h6">{{ __('Other Plans') }}</div>
      </div>
      
      <div class="sandy-quality">
        @forelse (\App\Models\Plan::limit(5)->get() as $item)
        <div class="admin-plans is-side">
          <div class="plan-details">
            <div class="title">
              {{ $item->name }}
            </div>
            <div class="plan-actions">
              <a href="{{ route('admin-edit-plan', $item->id) }}" class="action">{{ __('Edit') }}</a>
            </div>
          </div>
          <div class="plan-cta">
            <div class="name">{{ __('Users') }}</div>
            <div class="number">{{ \App\Models\Plan::count_users($item->id) }}</div>
          </div>
        </div>
        @empty
        <div class="is-empty p-10 text-center">
          <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
          <p class="mt-10 text-lg font-bold">{{ __('It\'s kinda lonely here! Start creating.') }}</p>
          <a href="{{ route('admin-new-plan') }}" class="text-sticker mt-5">{{ __('Create Plan') }}</a>
        </div>
        @endforelse
        <a class="button sandy-quality-button bg-black" href="{{ route('admin-plans') }}">{{ __('All Plans') }}</a>
      </div>
    </div>
  </div>
</div>
@endsection