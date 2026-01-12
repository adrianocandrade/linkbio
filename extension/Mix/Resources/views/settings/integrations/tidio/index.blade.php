@extends('mix::layouts.master')
@section('title', __('Tidio'))
@section('content')
<div class="mix-padding-10">
	<div class="mb-10">
		<p class="text-lg font-bold">{{ __('Tidio') }}</p>
		<p class="text-xs text-gray-400">{{ __('Let your visitors communicate with you via tidio. Add your tidio api public key below.') }}</p>
	</div>

	<form method="post" action="{{ route('user-mix-settings-integrations-tidio-post') }}" class="mort-main-bg p-5 rounded-2xl">
		@csrf
		



		<div class="form-input mb-5">
			<label class="initial mb-5">{{ __('Status') }}</label>
			<select name="integrations[tidio][enable]" class="bg-w nice-select">
				<option value="0" {{ !user('integrations.tidio.enable') ? 'selected' : '' }}>{{ __('Disable') }}</option>
				<option value="1" {{ user('integrations.tidio.enable') ? 'selected' : '' }}>{{ __('Enable') }}</option>
			</select>
		</div>


		<div class="form-input">
			<label>{{ __('Api Key') }}</label>
			<input type="text" name="integrations[tidio][api]" class="bg-w" value="{{ user('integrations.tidio.api') }}">
		</div>

		<button class="mt-5 sandy-expandable-btn"><span>{{ __('Save') }}</span></button>
	</form>
</div>
@endsection