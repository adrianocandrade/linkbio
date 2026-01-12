@extends('mix::layouts.master')
@section('title', __('Settings'))
@section('content')
<div class="mix-padding-10">
	<div class="dashboard-header-banner relative mt-0 mb-10">
		<div class="card-container">
			
			<div class="text-lg font-bold">{{ __('Settings') }}</div>
            <div class="side-cta">
                <img src="{{ gs('assets/image/emoji/Yellow-1/Nerdy.png') }}" alt="">
            </div>
		</div>
	</div>
	<div class="subtitle-border">{{ __('Basic') }}</div>
	<div class="grid grid-cols-1 sm:grid-cols-2">
		<a class="settings-card" href="{{ route('user-mix-settings-social') }}">
			<div class="settings-card-avatar bg-fade2-mint shadow-bg shadow-bg-l">
				<span>
					{!! svg_i('instagram-1', 'w-4 h-4 stroke-current text-black') !!}
				</span>
			</div>
			<div class="settings-card-info">
				<h4>{{ __('Social') }}</h4>
				<p>{{ __('Edit your bio social icons.') }}</p>
			</div>
		</a>
		<a class="settings-card" href="{{ route('user-mix-settings-customize') }}">
			<div class="settings-card-avatar bg-fade-pink shadow-bg shadow-bg-l">
				<span>
					{!! svg_i('paint-bucket-2', 'w-4 h-4 stroke-current text-black') !!}
				</span>
			</div>
			<div class="settings-card-info">
				<h4>{{ __('Customization') }}</h4>
				<p>{{ __('Customize the looks of your page.') }}</p>
			</div>
		</a>
		<a class="settings-card" href="{{ route('user-mix-settings-theme') }}">
			<div class="settings-card-avatar bg-fade-brown shadow-bg shadow-bg-l">
				<span>
					{!! svg_i('wireframe-1', 'w-4 h-4 stroke-current text-black') !!}
				</span>
			</div>
			<div class="settings-card-info">
				<h4>{{ __('Theme') }}</h4>
				<p>{{ __('Change your page theme style.') }}</p>
			</div>
		</a>
		<a class="settings-card" href="{{ route('user-mix-settings-pwa') }}">
			<div class="settings-card-avatar bg-brown shadow-bg shadow-bg-l">
				<span>
					{!! svg_i('smartphone-1', 'w-4 h-4 stroke-current text-white') !!}
				</span>
			</div>
			<div class="settings-card-info">
				<h4>{{ __('Pwa') }}</h4>
				<p>{{ __('Progressive web app pages.') }}</p>
			</div>
		</a>
		<div class="subtitle-border mt-5 col-span-1 sm:col-span-2">{{ __('Advance') }}</div>
		<a href="{{ route('user-mix-settings-seo') }}" class="settings-card">
			<div class="settings-card-avatar bg-yellow-light shadow-bg shadow-bg-l">
				<span>
					{!! svg_i('goal-1', 'w-4 h-4') !!}
				</span>
			</div>
			<div class="settings-card-info">
				<h4>{{ __('Custom Seo') }}</h4>
				<p>{{ __('Modify your store SEO to target more people') }}</p>
			</div>
		</a>
		<a href="{{ route('user-mix-settings-pixels') }}" class="settings-card">
			<div class="settings-card-avatar bg-teal-dark shadow-bg shadow-bg-l">
				<span>
					{!! svg_i('source-code-1', 'w-4 h-4') !!}
				</span>
			</div>
			<div class="settings-card-info">
				<h4>{{ __('Pixel Codes') }}</h4>
				<p>{{ __('Add / Edit custom pixel codes') }}</p>
			</div>
		</a>
		<a class="settings-card" href="{{ route('user-mix-settings-domain') }}">
			<div class="settings-card-avatar shadow-bg shadow-bg-l bg-fade-night">
				<span>
					{!! svg_i('world-globe-1', 'w-4 h-4') !!}
				</span>
			</div>
			<div class="settings-card-info">
				<h4>{{ __('Domain') }}</h4>
				<p>{{ __('Access your page with through custom domain.') }}</p>
			</div>
		</a>
		@if (Plugins::has('api'))
		<a class="settings-card" href="{{ route('user-mix-settings-api') }}">
			<div class="settings-card-avatar bg-fade2-blue shadow-bg shadow-bg-l">
				<span>
					{!! svg_i('configuration-1', 'w-4 h-4 stroke-current text-black') !!}
				</span>
			</div>
			<div class="settings-card-info">
				<h4>{{ __('Api Key') }}</h4>
				<p>{{ __('Get access to your unique api key.') }}</p>
			</div>
		</a>
		@endif
		<a class="settings-card" href="{{ route('user-mix-settings-integrations-all') }}">
			<div class="settings-card-avatar shadow-bg shadow-bg-l bg-gray-dark">
				<span>
					{!! svg_i('power-cord-1', 'w-4 h-4') !!}
				</span>
			</div>
			<div class="settings-card-info">
				<h4>{{ __('Integrations') }}</h4>
				<p>{{ __('Connect other external platforms.') }}</p>
			</div>
		</a>
		<div class="subtitle-border mt-5 col-span-1 sm:col-span-2 text-red-500">{{ __('Danger Zone') }}</div>
        <div class="settings-card cursor-pointer" onclick="alert('{{ __('Please use Account menu to delete your account') }}')">
            <div class="settings-card-avatar bg-red-500 shadow-bg shadow-bg-l text-white">
                <span class="text-white">
                    {!! svg_i('close-1', 'w-4 h-4 stroke-current text-white') !!}
                </span>
            </div>
            <div class="settings-card-info w-full">
                <h4 class="text-red-500">{{ __('Delete Account') }}</h4>
                <p>{{ __('Use Account menu to delete your account.') }}</p>
            </div>
        </div>
	</div>
</div>
@endsection