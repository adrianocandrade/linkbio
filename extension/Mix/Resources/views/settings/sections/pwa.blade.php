@extends('mix::layouts.master')
@section('title', __('Pwa'))
@section('content')
<div class="inner-pages-header mb-10 hidden">
	<div class="inner-pages-header-container">
		<a class="previous-page" href="{{ route('user-mix-settings') }}">
			<p class="back-button"><i class="la la-arrow-left"></i></p>
			<h1 class="inner-pages-title ml-3">{{ __('Back') }}</h1>
		</a>
		<a class="buy-now-button cursor-pointer is-loader-submit" data-form-submit=".submit-setting"> <span>{{ __('Save') }}</span> </a>
	</div>
</div>
<form class="mix-padding-10 submit-setting" method="post" action="{{ route('user-mix-settings-pwa-post') }}" enctype="multipart/form-data">
	@csrf
	<div class="relative">
		@if (!plan('settings.pwa'))
		@include('include.no-plan')
		@endif
		
		<div class="dashboard-header-banner relative mb-5 mt-5 md:mt-10">
			<div class="card-container">
				
				<div class="text-lg font-bold">{{ __('Progressive Web App') }}</div>
				<div class="side-cta">
					<img src="{{ gs('assets/image/emoji/Yellow-1/Nerdy.png') }}" alt="">
				</div>
			</div>
		</div>
		<div class="card customize mb-10 hidden">
			<div class="card-header">
				<p class="title font-bold">{{ __('Pwa') }}</p>
				<p class="subtitle text-gray-400">{{ __('Setup your pwa and let your visitors install your page as an app. Fill in all the field below as they are required.') }}</p>
				@if ($query = search_docs('Pwa'))
				<a href="{{ $query }}" target="_blank" app-sandy-prevent class="mt-5 text-xs c-black font-bold href-link-button block">{{ __('Need Help?') }}</a>
				@endif
			</div>
		</div>
		
        <div class="card p-5 rounded-2xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
            <div class="card-container bg-repeat-right"
                data-bg="{{ gs('assets/image/others/scribbbles/45.png') }}">

				
                <div class="icon hidden">
                    {!! orion('smartphone-1', 'w-20 h-20') !!}
                </div>
                <div class="mt-5 text-2xl font-bold">{{ __('Setup') }}</div>
                <div class="my-2 text-xs is-info w-44 mb-5">{{ __('Setup your pwa and let your visitors install your page as an app.') }}</div>


				<div class="card customize mb-5 mr-14">
					<div class="card-header bg-gray-100 flex justify-between">
						<p class="title mb-0 font-bold capitalize text-xs md:text-base">{{ __('Enable progressive web app') }}</p>
						<label class="sandy-switch">
							<input type="hidden" name="pwa[enable]" value="0">
							<input class="sandy-switch-input" name="pwa[enable]" value="1" type="checkbox" {{ user('pwa.enable') ? 'checked' : '' }}>
							<span class="sandy-switch-in"><span class="sandy-switch-box is-white"></span></span>
						</label>
					</div>
				</div>
				

				<div class="wj-image-selector-w is-avatar relative active mr-14" data-generic-preview>
					<a class="wj-image-selector-trigger rounded-xl flex items-center relative">
						<div class="wj-image-container inline-flex items-center justify-center">

							<img src="{!! url('media/bio/pwa-app-icon', user('pwa.app_icon')) !!}" alt="">
						</div>
						<div class="wj-image-selector-text ml-3 flex flex-col">
							<span
								class="wj-text-holder text-sm font-bold">{{ __('Upload a thumbnail') }}</span>
							<span
								class="font-8 font-bold uppercase">{{ __(':mb Max', ['mb' => '2mb']) }}</span>
						</div>
					</a>

					<input type="file" name="app_icon">
				</div>

				

				<div class="mb-5 mr-14">
					<div class="form-wrap" pickr>
						<p class="text-xs font-bold">{{ __('Browser Theme Color') }}</p>
						<input pickr-input type="hidden" name="pwa[theme_color]" value="{{ user('pwa.theme_color') ?? '#000' }}">
						<div id="button-background-color" pickr-div></div>
					</div>
				</div>
                <button class="sandy-expandable-btn px-10"><span>{{ __('Save') }}</span></button>
            </div>
        </div>

		
        <div class="card p-5 rounded-2xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
            <div class="card-container bg-repeat-right"
                data-bg="{{ gs('assets/image/others/scribbbles/48.png') }}">
				
				<div data-checkbox-sh-input=".show-color-div" class="mr-14">
					<p class="text-xs font-bold my-7">{{ __('Push Notification') }}</p>
					<div class="card customize mb-5">
						<div class="card-header flex justify-between">
							<p class="title mb-0 font-bold capitalize text-xs md:text-base">{{ __('Enable push notification') }}</p>
							<label class="sandy-switch">
								<input type="hidden" name="pwa[enable_push]" value="0">
								<input class="sandy-switch-input checkbox-sh-input" name="pwa[enable_push]" value="1" type="checkbox" {{ user('pwa.enable_push') ? 'checked' : '' }}>
								<span class="sandy-switch-in"><span class="sandy-switch-box is-white"></span></span>
							</label>
						</div>
					</div>
					<div class="w-full mb-5 show-color-div">
						
						<a class="button send-push-open shadow-none w-full button bg-gray-200 text-black ">
							{{ __('Send Notification') }}
						</a>
					</div>
				</div>
                <button class="sandy-expandable-btn px-10"><span>{{ __('Save') }}</span></button>
		
			</div>
		</div>
	</form>
	<div data-popup=".send-push">
		
		<div class="dashboard-fancy-card-v1 grid grid-cols-2 gap-2">
			<div>
				<div class="dashboard-fancy-card-v1-single active">
					<div class="details-item w-full">
						<div class="details-head flex-col items-start">
							<div class="details-preview text-sticker secondary-box rounded-full p-5 mt-0 mb-3">
								<i class="sio communication-036-unread-message sligh-thick text-black text-lg"></i>
							</div>
							<div class="details-text caption-sm font-bold">{{ __('Sent') }}</div>
						</div>
						<div class="details-counter text-2xl truncate font-bold">{{ nr(\App\Models\BioPushNotification::where('user', $user->id)->count()) }}</div>
						<div class="details-indicator">
							<div class="details-progress bg-red w-half"></div>
						</div>
					</div>
				</div>
			</div>
			<div>
				
				<div class="dashboard-fancy-card-v1-single active">
					<div class="details-item w-full">
						<div class="details-head flex-col items-start">
							<div class="details-preview text-sticker secondary-box rounded-full p-5 mt-0 mb-3">
								<i class="sio shopping-icon-063-smartphone sligh-thick text-black text-lg"></i>
							</div>
							<div class="details-text caption-sm font-bold">{{ __('Devices') }}</div>
						</div>
						<div class="details-counter text-2xl truncate font-bold">{{ nr(\App\Models\BioDevicetoken::where('user', $user->id)->count()) }}</div>
						<div class="details-indicator">
							<div class="details-progress bg-red w-half"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form action="{{ route('user-mix-settings-pwa-push') }}" method="post" class="mt-5 relative">
			@csrf
			@if (!plan('settings.pwa_messaging'))
				@include('include.no-plan')
			@endif
			<p class="text-xs font-bold mb-2">{{ __('Send Notification') }}</p>
			<div class="form-input">
				<label>{{ __('Title') }}</label>
				<input type="text" name="title">
			</div>
			<div class="form-input mt-3">
				<label>{{ __('Description') }}</label>
				<textarea name="description" cols="30" rows="10"></textarea>
			</div>
			<p class="text-xs font-bold mb-2 hidden">{{ __('Optional') }}</p>
			<div class="form-input hidden">
				<label>{{ __('Notification Link') }}</label>
				<input type="text" name="link">
			</div>
			<button class="mt-5 button shadow-none w-full button bg-gray-200 text-black">{{ __('Send') }}</button>
		</form>
	</div>
	@endsection