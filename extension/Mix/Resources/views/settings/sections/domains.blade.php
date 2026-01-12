@extends('mix::layouts.master')
@section('title', __('Domain'))
@section('namespace', 'user-mix-settings-domain')
@section('content')
<div class="mix-padding-10">
	@csrf
	<div class="relative">
		@if (!plan('settings.custom_domain'))
		@include('include.no-plan')
		@endif
		
		
        <div class="card p-5 rounded-2xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
            <div class="card-container bg-repeat-right"
                data-bg="{{ gs('assets/image/others/scribbbles/95.png') }}">

				
                <div class="icon hidden">
                    {!! orion('smartphone-1', 'w-20 h-20') !!}
                </div>
                <div class="mt-5 text-2xl font-bold">{{ __('Domain') }}</div>
                <div class="my-2 text-xs is-info w-44 mb-5">{{ __('Set a custom domain for your page.') }}</div>

				<div class="mt-5 mr-14">

					<form action="{{ route('user-mix-settings-domain-set') }}" method="POST">
						@csrf
						<div class="sandy-widget has-shadow p-0 mb-5">
							
							<div class="custom-domain">
								<div class="custom-domain-row">
									<div class="custom-domain-details flex flex-col sandy-expandable-block shadow-none">
										<div class="custom-domain-preview mb-5 mt-auto">
											<i class="sio database-and-storage-004-internet text-5xl"></i>
										</div>
										<div>
											
											<div class="cap-title">{{ __('Custom Domain') }}</div>
											<div class="caption">{{ __('Select what domain to use or connect your own domain.') }}</div>
											@if (search_docs($query = 'Domain'))
											<a href="{{ search_docs($query) }}" target="_blank" app-sandy-prevent class="mt-10 text-xs c-black font-bold href-link-button">{{ __('Need Help?') }}</a>
											@endif
										</div>
										
									</div>
									<div class="custom-domain-variants">
										<label class="custom-domain-label">
											@if ($domain)
											<input class="custom-domain-radio" type="radio" name="set_domain" {{ $domain && $domain->is_active ? 'checked' : '' }} value="1" />
											<span class="custom-domain-in">
												<span class="custom-domain-tick"></span>
												<span class="custom-domain-desc flex flex-col">
													<span class="cap-title block mb-4">{{ $domain->host }}</span>
													<span class="caption">{{ __('Your connected domain.') }}</span>
													<div>
														<a class="sandy-expandable-btn mt-3 connect-modal-open"><span>{{ __('Edit') }}</span></a>
													</div>
												</span>
											</span>
											@else
											<span class="custom-domain-in">
												<span class="custom-domain-tick"></span>
												<span class="custom-domain-desc flex flex-col">
													<span class="cap-title block mb-4">{{ __('Connect a Domain') }}</span>
													<span class="caption">{{ __('Connect your custom domain to your bio.') }}</span>
													<div class="block">
														<a class="sandy-expandable-btn mt-3 connect-modal-open"><span>{{ __('Connect') }}</span></a>
													</div>
												</span>
											</span>
											@endif
										</label>
										<label class="custom-domain-label">
											<input class="custom-domain-radio" type="radio" name="set_domain" {{ $domain && !$domain->is_active ? 'checked' : '' }} value="0" />
											<span class="custom-domain-in">
												<span class="custom-domain-tick"></span>
												<span class="custom-domain-desc">
													<span class="cap-title block m-0">{{ parse(route('user-bio-home', $user->username), 'host') . parse(route('user-bio-home', $user->username), 'path') }}</span>
												</span>
											</span>
										</label>
									</div>
								</div>
							</div>
						</div>
						<button class="sandy-expandable-btn px-10"><span>{{ __('Save') }}</span></button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div data-popup=".connect-modal">
	<form action="{{ route('user-mix-settings-domain-configure') }}" method="POST">
		@csrf
		
		<div class="flex justify-between align-end items-center p-8 md:p-14 mort-main-bg mb-5 rounded-xl">
			<div class="flex align-center">
				<div class="color-primary flex flex-col">
					<span class="font-bold text-lg mb-1">{{ __('Connect Domain') }}</span>
					<span class="text-xs text-gray-400">{!! __t('Make sure you changed your domain nameservers to <b>:nameservers</b>', ['nameservers' => config('app.SANDY_NAMESERVERS')]) !!}</span>
				</div>
			</div>
		</div>


		<div class="form-input">
			<label class="initial">{{ __('Protocol') }}</label>
			<select name="protocol">
				<option value="https" {{ $domain && $domain->scheme == 'https' ? 'selected' : '' }}>{{ __('HTTPS') }}</option>
				<option value="http" {{ $domain && $domain->scheme == 'http' ? 'selected' : '' }}>{{ __('HTTP') }}</option>
			</select>
		</div>
		<div class="form-input mt-5">
			<label class="initial">{{ __('Host') }}</label>
			<input type="text" name="host" value="{{ $domain ? $domain->host : '' }}" placeholder="{{ __('Host without protocol ex: example.com') }}">
		</div>
		<button class="button w-full is-loader-submit loader-white mt-5">{{ __('Save') }}</button>
	</form>
</div>
@endsection