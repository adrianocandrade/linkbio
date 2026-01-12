@extends('mix::layouts.master')
@section('title', __('Payments'))
@section('namespace', 'user-mix-settings-methods')
@section('content')
<div class="mix-padding-10-">
	<div class="relative">
		<div class="card customize mb-5">
			<div class="card-header">
				<p class="title font-bold">{{ __('Payment Methods') }}</p>
				<p class="subtitle">{{ __('Set a payment method to be used by paid elements like products, tip jar, and any other active paid element.') }}</p>

				@if (empty(user('payments.default')))
					<p class="mt-5 text-xs">{!! __t('(Note: it\'s important you select a default method & currency for you to accept payments. Click :here to setup your default method & currency.)', ['here' => '<a href="#" class="text-link config-modal-open">'. __('here') .'</a>']) !!}</p>
				@endif
				<a href="#" class="mt-8 button w-full config-modal-open">{{ __('Configure') }}</a>
			</div>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-4 relative z-10">
			@foreach ($payments as $key => $value)

			@php
				$scribbbles = seed_random_number("PAYMENT-SEED-$key");

			@endphp
			<div class="card card_widget mb-7 block has-sweet-container border border-solid border-gray-200">
				<div class="card-container bg-repeat-right" data-bg="{{ gs("assets/image/others/scribbbles/$scribbbles.png") }}">
					
					
					<div class="icon ">
						<div class="h-avatar is-medium bg-white p-2 is-video">
							<img class="avatar is-squared object-contain rounded-xl" src="{{ gs('assets/image/payments', ao($value, 'thumbnail')) }}" alt="">
						</div>
					</div>
					<div class="mt-5 text-2xl font-bold">{{ __(':method Integration', ['method' => ao($value, 'name')]) }}</div>
					<div class="my-2 text-xs is-info">{{ ao($value, 'description') }}</div>
					
					@if (Route::has("sandy-payments-$key-user-edit"))
						<a href="{{ route("sandy-payments-$key-user-edit") }}" class="sandy-expandable-btn px-10"><span>{{ __('Setup') }}</span></a>
					@endif
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
<div data-popup=".config-modal">
	<div class="card customize mb-5">
		<div class="card-header">
			<p class="title font-bold">{{ __('Configure your payment method') }}</p>
			<p class="subtitle text-xs italic mt-4">{{ __('(Note: you need to configure your preferred payment method & your currency to be used by your paid elements.)') }}</p>
		</div>
	</div>
	
	<form method="post" action="{{ route('user-mix-settings-post', 'payments') }}">
		@csrf
		<div class="grid grid-cols-2 gap-4">
			<div class="form-input">
				<label class="initial">{{ __('Default Method') }}</label>
				<select name="payments[default]">
					@foreach ($payments as $key => $value)
						@if (user("payments.$key.status"))
							<option value="{{ $key }}" {{ user('payments.default') == $key ? 'selected' : '' }}>{{ ao($value, 'name') }}</option>
						@endif
					@endforeach
				</select>
			</div>
			<div class="form-input">
				<label class="initial">{{ __('Default Currency') }}</label>
				<select name="payments[currency]">
					@foreach (\Currency::all() as $key => $value)
					<option value="{{ $key }}" {{ user('payments.currency') == $key ? 'selected' : '' }}>{!! $key !!}</option>
					@endforeach
				</select>
			</div>
		</div>
		<button class="mt-5 text-sticker is-loader-submit">{{ __('Save') }}</button>
	</form>
</div>
@endsection