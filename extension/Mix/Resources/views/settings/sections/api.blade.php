@extends('mix::layouts.master')
@section('title', __('Api Key'))
@section('namespace', 'user-mix-settings-api')
@section('content')
<div class="mix-padding-10">
	<div class="relative">
		@if (!plan('settings.api'))
		@include('include.no-plan')
		@endif
		
		
        <div class="card p-5 rounded-2xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
            <div class="card-container bg-repeat-right"
                data-bg="{{ gs('assets/image/others/scribbbles/65.png') }}">
                <div class="mt-5 text-2xl font-bold">{{ __('Api Key') }}</div>
                <div class="my-2 text-xs is-info w-44 mb-5">{{ __('Please look into our documentation to find endpoints that can be used with our api.') }}</div>
				@if (Route::has('sandy-plugins-api-docs-api'))
				<a href="{{ route('sandy-plugins-api-docs-api') }}" target="_blank" app-sandy-prevent class="mt-5 text-xs c-black font-bold href-link-button block">{{ __('Documentation?') }}</a>
				@endif

				<div class="mr-24 mt-5">

					@if (empty($user->api))
						<div class="my-10 text-center">
							<div class="p-10">
							<img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
							</div>
			
							<form action="{{ route('user-mix-settings-api-reset') }}" method="post" class="flex justify-center">
								@csrf
								<button class="text-xs c-black font-bold mt-5 href-link-button text-sticker is-loader-submit loader-white">{{ __('Generate Api Key') }}</button>
							</form>
						</div>
					@endif

					@if (!empty($user->api))
						
					<div class="border-2 border-solid border-gray-100 p-5 rounded-xl">
						<div class="text-base font-black capitalize c-dark mb-1">
							{{ __("Here's your api key") }}
						</div>
						<form action="{{ route('user-mix-settings-api-reset') }}" method="post">
							@csrf
							<button class="text-xs c-black font-bold mb-5 href-link-button">{{ __('Reset Key') }}</button>
						</form>

						@if (session('api_token') && !session('api_token_shown'))
							{{-- ✅ Segurança: Mostrar token plain apenas uma vez após geração --}}
							<div class="alert alert-warning mb-3">
								<small>{{ __('⚠️ Important: Copy your API key now. You will not be able to see it again!') }}</small>
							</div>
							<div class="form-input copy active">
								<input type="text" value="{{ session('api_token') }}" readonly="" id="api-token-input">
								<div class="copy-btn" data-copy="{{ session('api_token') }}" data-after-copy="{{ __('Copied') }}">
									<i class="la la-copy"></i>
								</div>
							</div>
							{{ session()->forget('api_token_shown') }}
							<script>
								// Remover token da sessão após copiar ou após 30 segundos
								setTimeout(function() {
									var input = document.getElementById('api-token-input');
									if (input) input.value = '{{ __("Token hidden for security") }}';
								}, 30000);
							</script>
						@else
							{{-- Token já foi gerado, não mostrar hash --}}
							<div class="alert alert-info mb-3">
								<small>{{ __('🔒 Your API key is already set. Reset it to generate a new one.') }}</small>
							</div>
							<div class="form-input">
								<input type="text" value="••••••••••••••••••••••••••••••••••••" readonly="" disabled>
								<small class="text-gray-500">{{ __('Token hidden for security') }}</small>
							</div>
						@endif
					</div>
					@endif
				</div>
			</div>
		</div>
		
	</div>
</div>
@endsection