@extends('mix::layouts.master')
@section('title', __('Customize Template'))
@section('namespace', 'user-mix-settings-cuztomize')
@section('fonts')
{!! fonts('html') !!}
@stop
@section('content')
<form method="post" action="{{ route('user-mix-settings-post', 'customize') }}" class="mix-padding-10" enctype="multipart/form-data">
	@csrf
	<div class="tab-header mb-5">
		<div class="flex justify-between items-baseline">
			<h1 class="tab-title">{{ __('Customize') }}</h1>
			<button class="sandy-expandable-btn mt-5 bg-white"><span>{{ __('Save') }}</span></button>
		</div>
	</div>
	<div class="subtab-wrapper sandy-tabs">
		<div class="flex items-baseline justify-between">
			<div class="flex max-w-100 overflow-auto">
				<a class="subtab sandy-tabs-link active">{{ __('General') }}</a>
				<a class="subtab sandy-tabs-link">{{ __('Background') }}</a>
				<a class="subtab sandy-tabs-link">{{ __('Fonts') }}</a>
			</div>
		</div>
		<div class="tab-title-divider"></div>
		<div class="sandy-tab-body">
			<div class="sandy-tabs-item">
				
				<div class="card customize rounded-2xl mb-10 relative">
					@if (!plan('settings.customize'))
					@include('include.no-plan')
					@endif
					<p class="text-sm font-bold text-gray-400">{{ __('Bio Align') }}</p>
					<div class="bio-swiper-container mt-3">
						<div class="bio-swiper-wrapper">
							<div class="bio-swiper-slide">
								@foreach (['left' => 'Left', 'center' => 'Center', 'right' => 'Right'] as $key => $value)
								<label class="sandy-big-checkbox is-bio-radius">
									<input type="radio" class="sandy-input-inner" name="settings[bio_align]" value="{{ $key }}" {{ user('settings.bio_align') == $key ? 'checked' : '' }}>
									<div class="checkbox-inner p-5 h-14">
										<div class="checkbox-wrap">
											<div class="content">
												<h1>{{ __($value) }}</h1>
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
						</div>
					</div>
					<p class="text-sm font-bold text-gray-400 mt-7">{{ __('Color Scheme') }}</p>
					<div class="grid grid-cols-2 gap-4 mt-3">
						@foreach (['0' => 'Light', '1' => 'Dark'] as $key => $value)
						<label class="sandy-big-checkbox">
							<input type="radio" class="sandy-input-inner" name="settings[always_dark]" value="{{ $key }}" {{ user('settings.always_dark') == $key ? 'checked' : '' }}>
							<div class="checkbox-inner p-5 h-14 rounded-2xl">
								<div class="checkbox-wrap">
									<div class="content">
										<h1>{{ __($value) }}</h1>
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
					<button class="sandy-expandable-btn mt-5 bg-white"><span>{{ __('Save') }}</span></button>
				</div>
				
				<div class="card customize rounded-2xl mb-10 relative">
					@if (!plan('settings.customize'))
					@include('include.no-plan')
					@endif
					
					<div class="bio-swiper-container mt-0">
						<div class="bio-swiper-wrapper">
							<div class="bio-swiper-slide">
								@foreach (['straight' => ['class' => 'rounded-none', 'name' => 'Straight'], 'round' => ['class' => 'rounded-2xl', 'name' => 'Rounded'], 'rounded' => ['class' => 'rounded-full', 'name' => 'Round']] as $key => $value)
								<label class="sandy-big-checkbox is-bio-radius">
									<input type="radio" class="sandy-input-inner" name="settings[radius]" value="{{ $key }}" {{ user('settings.radius') == $key ? 'checked' : '' }}>
									<div class="checkbox-inner {{ ao($value, 'class') }} p-5 h-14">
										<div class="checkbox-wrap">
											<div class="content">
												<h1>{{ __(ao($value, 'name')) }}</h1>
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
						</div>
					</div>
					<button class="sandy-expandable-btn mt-5 bg-white"><span>{{ __('Save') }}</span></button>
				</div>

				
	<!-- Buttons Start -->
	<div class="card customize rounded-2xl mb-10 relative">
		
		@if (!plan('settings.customize'))
		@include('include.no-plan')
		@endif
		<div class="card-header">
			<p class="title font-bold">{{ __('Theme Color') }}</p>
			<p class="subtitle text-gray-600">{{ __('Set global theme color.') }}</p>
		</div>
		<div class="grid grid-cols-1 gap-4 mt-7">
			<div>
				<div class="form-wrap" pickr>
					<label>{{ __('Color') }}</label>
					<input pickr-input type="hidden" name="color[button_background]" value="{{ user('color.button_background') ?? '#000' }}">
					<div id="button-background-color" pickr-div></div>
				</div>
				<p class="text-gray-400 text-xs mt-2">{{ __('Note: does not work with default theme.') }}</p>
			</div>
			<div class="hidden">
				<div class="form-wrap" pickr>
					<label>{{ __('Buttons Text Color') }}</label>
					<input pickr-input type="hidden" name="color[button_color]" value="{{ user('color.button_color') ?? '#000' }}">
					<div id="button-button-text-color" pickr-div></div>
				</div>
			</div>
		</div>
		<button class="sandy-expandable-btn mt-5 bg-white"><span>{{ __('Save') }}</span></button>
	</div>
	<!-- Buttons END -->
	<!-- Branding Start -->
	<div class="card customize rounded-2xl mb-10 relative">
		@if (!plan('settings.branding'))
		<div class="not-plan">
			<div class="opacity-reduce"></div>
		</div>
		@endif
		<div class="flex items-center justify-between">
			<p>{{ __('Remove our branding') }}</p>
			<label class="sandy-switch">
				<input type="hidden" name="settings[remove_branding]" value="0">
				<input class="sandy-switch-input" name="settings[remove_branding]" value="1" type="checkbox" {{ user('settings.remove_branding') ? 'checked' : '' }}>
				<span class="sandy-switch-in"><span class="sandy-switch-box"></span></span>
			</label>
		</div>
		<button class="sandy-expandable-btn mt-5 bg-white"><span>{{ __('Save') }}</span></button>
	</div>
	<!-- Branding End -->
	<!-- Branding Start -->
	<div class="card customize rounded-2xl mb-10 relative">
		@if (!plan('settings.verified'))
		<div class="not-plan">
			<div class="opacity-reduce"></div>
		</div>
		@endif
		<div class="flex items-center justify-between">
			<p>{{ __('Verified checkmark') }}</p>
			
			<label class="sandy-switch">
				<input type="hidden" name="settings[verified]" value="0">
				<input class="sandy-switch-input" name="settings[verified]" value="1" type="checkbox" {{ user('settings.verified') ? 'checked' : '' }}>
				<span class="sandy-switch-in"><span class="sandy-switch-box"></span></span>
			</label>
		</div>
		<button class="sandy-expandable-btn mt-5 bg-white"><span>{{ __('Save') }}</span></button>
	</div>
	<!-- Branding End -->
	
			</div>
			<div class="sandy-tabs-item">
				
				<!-- Background START -->
				<div class="card customize rounded-2xl mb-10 relative">
					@if (!plan('settings.customize'))
					@include('include.no-plan')
					@endif
					<div class="card-header">
						<p class="title font-bold">{{ __('Background') }}</p>
						<p class="subtitle text-gray-600">{{ __('Choose a suitable background for your page.
						Could be picture, color or gradient.') }}</p>
					</div>
					
					<div class="grid grid-cols-2 gap-4 mt-5">
						<label class="sandy-big-checkbox is-html-demo">
							<input type="radio" class="sandy-input-inner" name="settings[banner_or_background]" value="0" {{ !user('settings.banner_or_background') ? 'checked' : '' }}>
							<div class="checkbox-inner h-full items-center">
								
								<div class="html-demo-bio has-bio-background w-full">
									<div class="html-demo-background-main"></div>
									<div class="flex w-full flex-col">
										<div class="flex">
											
											<div class="html-demo-avatar"></div>
										</div>
										<div class="w-full">
											
											<div class="html-demo-description h-2"></div>
											<div class="html-demo-description h-2 mt-2"></div>
										</div>
									</div>
									<div class="html-demo-description hidden"></div>
								</div>
							</div>
						</label>
						<label class="sandy-big-checkbox is-html-demo">
							<input type="radio" class="sandy-input-inner" name="settings[banner_or_background]" value="1" {{ user('settings.banner_or_background') ? 'checked' : '' }}>
							<div class="checkbox-inner h-full items-center">
								
								<div class="html-demo-bio has-bio-banner w-full">
									<div class="html-demo-background-banner"></div>
									<div class="flex w-full flex-col">
										<div class="flex">
											
											<div class="html-demo-avatar"></div>
										</div>
										<div class="w-full">
											
											<div class="html-demo-description h-2"></div>
											<div class="html-demo-description h-2 mt-2"></div>
										</div>
									</div>
									<div class="html-demo-description hidden"></div>
								</div>
							</div>
						</label>
					</div>
					<div class="grid grid-cols-2 md:grid-cols-3 --lg:grid-cols-4-- gap-4 mt-7 switch-is-customize">
						<label class="profile-background-types-wrapper background-picture-open">
							<input type="radio" name="background" value="image" {{ user('background') == 'image' ? 'checked' : '' }}>
							
							<div class="profile-background-types rounded-2xl">
								<div class="active-dot"></div>
								<div class="icon is-ava">
									{!! getBioBackground($user->id, 'image') !!}
									<i class="flaticon-photo-camera"></i>
								</div>
								<p>{{ __('Picture/Gif') }}</p>
							</div>
						</label>
						
						<label class="profile-background-types-wrapper solid-background-open">
							<input type="radio" name="background" value="color" {{ user('background') == 'color' ? 'checked' : '' }}>
							
							<div class="profile-background-types rounded-2xl">
								<div class="active-dot"></div>
								<div class="icon is-ava">
									{!! getBioBackground($user->id, 'color') !!}
									<i class="la la-pencil"></i>
								</div>
								<p>{{ __('Solid Color') }}</p>
							</div>
						</label>
						<label class="profile-background-types-wrapper gradient-background-open">
							<input type="radio" name="background" value="gradient" {{ user('background') == 'gradient' ? 'checked' : '' }}>
							<div class="profile-background-types rounded-2xl">
								<div class="active-dot"></div>
								<div class="icon is-ava">
									{!! getBioBackground($user->id, 'gradient') !!}
									<i class="flaticon-background"></i>
								</div>
								<p>{{ __('Gradient') }}</p>
							</div>
						</label>
					</div>
					<div class="flex">
						<label class="profile-background-types-wrapper">
							<input type="radio" name="background" value="" {{ user('background') == '' ? 'checked' : '' }}>
							
							<div class="profile-background-types min-h-0 h-0 cursor-pointer flex flex-row items-center rounded-2xl">
								<p>{{ __('Reset') }}</p>
								<div class="active-dot relative ml-2 top-0 right-0"></div>
							</div>
						</label>
					</div>
					<div class="mt-5">
						<div class="form-wrap" pickr>
							<label>{{ __('Overall Text Color') }}</label>
							<input pickr-input type="hidden" name="color[text]" value="{{ user('color.text') ?? '#000' }}">
							<div id="button-text-color" pickr-div></div>
						</div>
						<p class="text-gray-400 text-xs mt-2">{{ __('Ex: if your background is dark, you can set the "overall text color" white.') }}</p>
					</div>
					<button class="sandy-expandable-btn mt-5 bg-white"><span>{{ __('Save') }}</span></button>
				</div>
				<!-- Background END -->
			</div>
			<div class="sandy-tabs-item">
				
	<!-- Font Start -->
	<div class="card customize rounded-2xl relative">
		@if (!plan('settings.customize'))
		@include('include.no-plan')
		@endif
		<div class="card-header">
			<p class="title">{{ __('Font') }}</p>
			<p class="subtitle">{{ __('Choose a suitable font for your page.') }}</p>
		</div>
		<div class="grid mt-5 grid-cols-2 gap-4">
			@foreach (fonts() as $key => $value)
			<label class="sandy-big-radio">
				<input type="radio" name="font" value="{{ $key }}" class="custom-control-input" {{ user('font') == $key ? 'checked' : '' }}>
				<div class="radio-select-inner font">
					<div class="active-dot"></div>
					<h1 class="{{ slugify($key) }}-font-preview">{{ $key }}</h1>
					<p class="font-preview {{ slugify($key) }}-font-preview">{{ __($value['text'] ?? 'The quick brown fox') }}</p>
				</div>
			</label>
			@endforeach
		</div>
		<button class="sandy-expandable-btn mt-5 bg-white"><span>{{ __('Save') }}</span></button>
	</div>
	<!-- Font End -->
			</div>
		</div>
	</div>
	<!-- Background Video popup -->
	<div data-popup=".background-video">
		<div class="form-input mort-main-bg rounded-2xl p-5 mb-5">
			<label class="initial">{{ __('Video source') }}</label>
			<select name="background_settings[video][source]" class="bg-w" data-sandy-select=".select-background-shift">
				@foreach (['url' => 'External Url', 'upload' => 'Upload a Video'] as $key => $value)
				<option value="{{ $key }}" {{ user('background_settings.video.source') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
				@endforeach
			</select>
		</div>
		<div class="mort-main-bg rounded-2xl p-5 select-background-shift">
			<div data-sandy-open="url">
				<div class="form-input">
					<label>
						{{ __('Enter url') }}
					</label>
					<input type="text" class="bg-w" value="{{ user('background_settings.video.external_url') }}" name="background_settings[video][external_url]">
				</div>
			</div>
			<div data-sandy-open="upload">
				<div class="flex items-center flex-col">
					<div class="thumbnail-upload boxed block w-72" id="logo-thumbnail">
						<div class="h-avatar h-56 w-full is-upload is-outline-dark text-2xl mb-5 active" data-generic-preview=".h-avatar">
							<i class="flaticon-upload-1"></i>
							<input type="file" name="background_video_input" id="video-upload-input" accept="video/*">
						<video src="{{ getStorage('media/bio/background', user('background_settings.video.video')) }}"></video>
					</div>
					<label class="button mt-5 w-full initial" for="video-upload-input">
						{{ __('Select a video') }}
					</label>
				</div>
			</div>
		</div>
	</div>
	<button class="background-video-close" data-close-popup><i class="flaticon-close"></i></button>
	<button class="button main mt-5">{{ __('Save') }}</button>
</div>
<!-- Background image popup -->
<div data-popup=".background-picture">
	<div class="form-input mort-main-bg rounded-2xl p-5 mb-5">
		<label class="initial">{{ __('Background source') }}</label>
		<select name="background_settings[image][source]" class="bg-w" data-sandy-select=".select-background-shift">
			@foreach (['url' => 'External Url', 'upload' => 'Upload a background'] as $key => $value)
			<option value="{{ $key }}" {{ user('background_settings.image.source') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
			@endforeach
		</select>
	</div>
	<div class="mort-main-bg rounded-2xl p-5 select-background-shift">
		<div data-sandy-open="url">
			<div class="form-input">
				<label>
					{{ __('Enter url') }}
				</label>
				<input type="text" class="bg-w" value="{{ user('background_settings.image.external_url') }}" name="background_settings[image][external_url]">
			</div>
		</div>
		<div data-sandy-open="upload">
			<div class="flex items-center flex-col">
				<div class="thumbnail-upload boxed block w-72" id="logo-thumbnail">
					<div class="h-avatar h-56 w-full is-upload is-outline-dark text-2xl mb-5 active" data-generic-preview=".h-avatar">
						<i class="flaticon-upload-1"></i>
						<input type="file" name="background_image_input">
						<img src="{{ getStorage('media/bio/background', user('background_settings.image.image')) }}" alt="">
					</div>
					<label class="button mt-5 w-full initial" for="logo-thumbnail-input">
						{{ __('Select a background image') }}
					</label>
				</div>
			</div>
		</div>
	</div>
	<button class="background-picture-close" data-close-popup><i class="flaticon-close"></i></button>
	<button class="button main mt-5">{{ __('Save') }}</button>
</div>
<!-- Solid background popup -->
<div data-popup=".solid-background">
	<div class="inner-page-banner rounded-2xl">
		<h1 class="font-bold text-lg">{{ __('Solid Color') }}</h1>
		<p class="text-gray-400 text-xs">{{ __('Use solid color as your profile\'s background') }}</p>
	</div>
	<div class="form-wrap mt-7" pickr>
		<label>{{ __('Solid Color') }}</label>
		<input pickr-input type="hidden" name="background_settings[solid][color]" value="{{ user('background_settings.solid.color') ?? '#000' }}">
		<div id="solid-background-color" pickr-div></div>
	</div>
	
	<button class="solid-background-close" data-close-popup><i class="flaticon-close"></i></button>
	<button class="sandy-expandable-btn main mt-5"><span>{{ __('Save') }}</span></button>
</div>
<!-- Gradient background popup -->
<div data-popup=".gradient-background">
	<div class="inner-page-banner">
		<h1 class="font-bold text-lg">{{ __('Gradient Background') }}</h1>
		<p class="text-gray-400 text-xs">{{ __('Use gradient background as your profile\'s background') }}</p>
	</div>
	<div class="grid grid-cols-2 gap-4">
		
		<div class="form-wrap mt-7" pickr>
			<label>{{ __('Color 1') }}</label>
			<input pickr-input type="hidden" name="background_settings[gradient][color_1]" value="{{ user('background_settings.gradient.color_1') ?? '#fff' }}">
			<div id="gradient-background-color-1" pickr-div></div>
		</div>
		<div class="form-wrap mt-7" pickr>
			<label>{{ __('Color 2') }}</label>
			<input pickr-input type="hidden" name="background_settings[gradient][color_2]" value="{{ user('background_settings.gradient.color_2') ?? '#fff' }}">
			<div id="gradient-background-color-2" pickr-div></div>
		</div>
	</div>
	<div class="flex items-center justify-between mt-7">
		<p>{{ __('Animate gradient') }}</p>
		<div class="custom-switch mr-4">
			<input type="hidden" name="background_settings[gradient][animate]" value="0">
			
			<input type="checkbox" class="custom-control-input" name="background_settings[gradient][animate]" id="animate-gradient" value="1" {{  user('background_settings.gradient.animate') ? 'checked' : '' }}>
			<label class="custom-control-label" for="animate-gradient"></label>
		</div>
	</div>
	
	<button class="gradient-background-close" data-close-popup><i class="flaticon-close"></i></button>
	<button class="sandy-expandable-btn main mt-5" type="submit"><span>{{ __('Save') }}</span></button>
</div>
</form>
@endsection