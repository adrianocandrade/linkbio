@extends('mix::layouts.master')
@section('title', __('Social'))
@section('namespace', 'user-mix-settings-social')
@section('content')
<form class="mix-padding-10" method="post" action="{{ route('user-mix-settings-post', 'social') }}">
	@csrf
	<div class="links-accordion relative">
		
		@if (!plan('settings.social'))
			@include('include.no-plan')
		@endif
		
		
		
        <div class="card p-5 rounded-2xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
            <div class="card-container bg-repeat-right"
                data-bg="{{ gs('assets/image/others/scribbbles/4.png') }}">
                <div class="mt-5 text-2xl font-bold">{{ __('Social') }}</div>
                <div class="my-2 text-xs is-info w-44 mb-5">{{ __('Set your social media handles.') }}</div>

				<div class="mr-14">
					<div class="sortable flex flex-col gap-4" data-handle=".handle">
						@foreach ($socials as $key => $items)
						<div class="sandy-accordion mort-main-bg sortable-item m-0">
							<div class="sandy-accordion-head flex">
								
								<span class="drag mr-4 handle cursor-move"><i class="sni sni-move"></i></span>
								<span><em class="{{ ao($items, 'icon') }} mr-2"></em> {{ ao($items, 'name') }}</span>
							</div>
							<div class="sandy-accordion-body mt-5 pb-0">
								
								@php
								$address = ao($items, 'address') == '%s' ? __('{link}') : '{username}';
								@endphp
								<div class="form-input">
									<input type="text" class="bg-w" value="{{ user('social.'.$key) ?? '' }}" name="socials[{{$key}}]" placeholder="{{ ao($items, 'placeholder') }}">
								</div>
							</div>
						</div>
						@endforeach
					</div>
					<button class="sandy-expandable-btn px-10 mt-5"><span>{{ __('Save') }}</span></button>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection