@extends('mix::layouts.master')
@section('title', __('Profile'))
@section('namespace', 'user-mix-settings-profile')
@section('content')

@section('footerJS')

	<script>
		jQuery('.sandy-upload-modal-close').on('click', function(){
			jQuery('.profile-form').submit();
		});
	</script>
@stop
<form class="mix-padding-10 profile-form" method="post" action="{{ route('user-mix-settings-post', 'profile') }}" enctype="multipart/form-data">
	@csrf
	<div class="card customize mb-10 hidden">
		<div class="card-header">
			<p class="title">{{ __('Profile') }}</p>
			<p class="subtitle">{{ __('Edit your profile information') }}</p>
		</div>
	</div>
	
	<div class="wj-image-selector-w is-avatar relative sandy-upload-modal-open is-sandy-upload-modal active mb-5" data-generic-preview=".h-avatar">
		<a class="wj-image-selector-trigger rounded-xl flex items-center relative">
			<div class="wj-image-container inline-flex items-center justify-center">
				
				{!! avatar($user->id, true) !!}
			</div>
			<div class="wj-image-selector-text ml-3 flex flex-col">
				<span class="wj-text-holder text-sm font-bold">{{ __('Upload a thumbnail') }}</span>
				<span class="font-8 font-bold uppercase">{{ __(':mb Max', ['mb' => '2mb']) }}</span>
			</div>
		</a>
	</div>

	{!! sandy_upload_modal($user->avatar_settings, 'media/bio/avatar') !!}

	<div class="mb-10">
		<div class="form-input is-link always-active active mb-7">
			<label class="is-alt-label hidden">{{ __('Username') }}</label>
			<div class="is-link-inner">
			<div class="side-info">
				@
			</div>
			<input type="text" name="username" placeholder="{{ __('Input a username') }}" class="is-alt-input bg-white" value="{{ Auth::user()->username }}">
			</div>
		</div>
		<div class="form-input mb-7">
			<label>{{ __('Name') }}</label>
			<input type="text" name="name" class="bg-w-" value="{{ Auth::user()->name }}">
		</div>
		<div class="form-input mb-7">
			<label>{{ __('Email') }}</label>
			<input type="email" name="email" class="bg-w-" value="{{ Auth::user()->email }}">
		</div>
		<div class="form-input">
			<label>{{ __('Bio') }}</label>
			<textarea rows="4" name="bio" class="bg-w-">{{ Auth::user()->bio }}</textarea>
		</div>

		<button class="sandy-expandable-btn px-10 mt-5"><span>{{ __('Save') }}</span></button>
	</div>
	<div class="relative z-10">
		
		<div class="card card_widget card-inherit" bg-style="#e5e7eb">
			
			<div class="font-bold text-xl mb-1">{{ __('Share') }}</div>
			<div class="text-gray-400 text-xs mb-5">{{ __('Share your page to various platforms.') }}</div>

			<div class="social-links">
				<a href="{{ share_to_media('facebook', user('name'), bio_url(user('id'))) }}" class="social-link facebook">
					<i class="o-facebook-1"></i>
				</a>
				<a href="{{ share_to_media('twitter', user('name'), bio_url(user('id'))) }}" class="social-link twitter">
					<i class="o-twitter-1"></i>
				</a>
				<a href="{{ share_to_media('whatsapp', user('name'), bio_url(user('id'))) }}" class="social-link whatsapp">
					<i class="o-whatsapp-1"></i>
				</a>
				<a href="{{ share_to_media('linkedin', user('name'), bio_url(user('id'))) }}" class="social-link linkedin">
					<i class="o-linkedin-1"></i>
				</a>
				<a href="{{ share_to_media('pinterest', user('name'), bio_url(user('id'))) }}" class="social-link pinterest">
					<i class="o-pinterest-1"></i>
				</a>
			</div>
			<div class="social-links mt-5">
				<a class="social-link mort-main-bg cursor-pointer share-profile-qr-code-open">
					<i class="la la-qrcode color-black"></i>
				</a>
				
				<div class="index-header-code">
					<a class="index-header-number text-xs" href="{{ bio_url(user('id')) }}" target="_blank">{{ bio_url(user('id'), 'short') }}</a>
					<button class="index-header-copy copy-btn ml-3" data-copy="{{ bio_url(user('id')) }}" data-after-copy="{{ __('Copied') }}">
					<i class="flaticon2-copy"></i>
					</button>
				</div>
			</div>
			
			<div class="flex mt-5 items-center share-profile-learn-open">
				<div class="social-links w-full">
					<a class="social-link instagram rounded-full">
						<i class="o-instagram-1"></i>
					</a>
					<a class="social-link -ml-5 rounded-full tiktok">
						<svg class="h-4 w-4 fill-current text-white">
							<use xlink:href="{{ gs('assets/image/svg/sprite.svg#icon-tiktok') }}"></use>
						</svg>
					</a>
					<a class="social-link -ml-5 rounded-full youtube">
						<i class="o-youtube-1"></i>
					</a>
				</div>
				<div class="text-xs text-gray-400">{{ __('Learn how to share on other social channels') }} <i class="la la-arrow-right"></i> </div>
			</div>
		</div>
	</div>
</form>
@endsection