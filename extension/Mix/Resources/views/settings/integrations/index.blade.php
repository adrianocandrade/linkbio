@extends('mix::layouts.master')
@section('title', __('Integrations'))
@section('namespace', 'user-mix-settings')
@section('content')
<div class="mix-padding-10">
	<div class="mb-10">
		<p class="text-lg font-bold">{{ __('Communication') }}</p>
		<p class="text-xs text-gray-400">{{ __('Integrate other communication platforms to your page.') }}</p>
	</div>
	<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
		<div class="integrations-card card-shadow p-5 rounded-2xl">
			<div class="preview mb-5">
				<img src="{{ gs('assets/image/brands/tidio.png') }}" class="w-half object-contain" alt="">
			</div>
			<p class="text-base mb-1 md:text-lg font-bold">{{ __('Tidio') }}</p>
			<p class="text-xs text-gray-400">{{ __('Let your visitors communicate with you via a livechat.') }}</p>
			<a href="{{ route('user-mix-settings-integrations-tidio') }}" class="mt-4 sandy-expandable-btn"><span>{{ __('Configure') }}</span></a>
		</div>
	</div>
	<div class="hidden">
		
		<div class="mb-10 mt-10">
			<p class="text-lg font-bold">{{ __('Payment Method\'s') }}</p>
			<p class="text-xs text-gray-400">{{ __('Integrate other communication platforms to your page.') }}</p>
		</div>
		<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
			<div class="integrations-card card-shadow p-5 rounded-2xl">
				<div class="preview mb-5">
					<img src="{{ gs('assets/image/brands/tidio.png') }}" class="w-half object-contain" alt="">
				</div>
				<p class="text-base mb-1 md:text-lg font-bold">{{ __('Tidio') }}</p>
				<p class="text-xs text-gray-400">{{ __('Let your visitors communicate with you via a livechat.') }}</p>
				<a href="" class="mt-4 sandy-expandable-btn"><span>{{ __('Configure') }}</span></a>
			</div>
		</div>
	</div>
</div>
@endsection