@extends('mix::layouts.master')
@section('title', __('Password'))
@section('namespace', 'user-mix-settings-password')
@section('content')

<form class="mix-padding-10" method="post" action="{{ route('user-mix-settings-post', 'password') }}" enctype="multipart/form-data">
	@csrf
	<div class="card customize mb-10">
		<div class="card-header">
			<p class="title font-bold">{{ __('Password') }}</p>
			<p class="subtitle text-gray-600">{{ __('Reset your Password') }}</p>
		</div>
	</div>

	<div class="card customize mb-5">
		<div class="form-input mb-7">
			<label>{{ __('New password') }}</label>
			<input type="text" name="password" class="bg-w">
		</div>
		<div class="form-input">
			<label>{{ __('Confirm password') }}</label>
			<input type="text" name="password_confirmation" class="bg-w">
		</div>
	</div>



    <button class="button w-full">{{ __('Save') }}</button>
</form>

@endsection
