@extends('mix::layouts.master')
@section('title', __('Seo'))
@section('namespace', 'user-mix-settings-seo')
@section('content')
<form class="mix-padding-10" method="post" action="{{ route('user-mix-settings-post', 'seo') }}" enctype="multipart/form-data">
	@csrf
	<div class="relative">
		@if (!plan('settings.seo'))
			@include('include.no-plan')
		@endif
		
		
        <div class="card p-5 rounded-2xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
            <div class="card-container bg-repeat-right"
                data-bg="{{ gs('assets/image/others/scribbbles/91.png') }}">
                <div class="mt-5 text-2xl font-bold">{{ __('Seo') }}</div>
                <div class="my-2 text-xs is-info w-44 mb-5">{{ __('Create custom title and description with keywords for search.') }}</div>

				<div class="mr-20">
					
					<div class="block my-10"></div>
					<div class="subtitle-border fs-15px flex justify-between uppercase">{{ __('Enable custom seo info') }}
						<label class="sandy-switch">
							<input type="hidden" name="seo[enable]" value="0">
							<input class="sandy-switch-input" name="seo[enable]" value="1" type="checkbox" {{ user('seo.enable') ? 'checked' : '' }}>
							<span class="sandy-switch-in"><span class="sandy-switch-box"></span></span>
						</label>
					</div>

					
					<div class="block my-10"></div>
					<div class="subtitle-border fs-15px flex justify-between uppercase">{{ __('Prevent Search Engine Indexing') }}
						<label class="sandy-switch">
							<input type="hidden" name="seo[block_engine]" value="0">
							<input class="sandy-switch-input" name="seo[block_engine]" value="1" type="checkbox" {{ user('seo.block_engine') ? 'checked' : '' }}>
							<span class="sandy-switch-in"><span class="sandy-switch-box"></span></span>
						</label>
					</div>


					<div class="card customize bg-gray-100">
							<div class="form-input mb-7 text-count-limit" data-limit="55">
								<label>{{ __('Page Name') }}</label>
								<span class="text-count-field"></span>
								<input type="text" name="seo[page_name]" class="bg-w" value="{{ user('seo.page_name') }}">
							</div>
							



							<div class="form-input text-count-limit" data-limit="400">
								<label>{{ __('Page Description') }}</label>
								<span class="text-count-field"></span>
								<textarea rows="4" name="seo[page_description]" class="bg-w">{{ user('seo.page_description') }}</textarea>
							</div>

							<div class="form-input mt-5">
								<label class="initial mb-4 block">{{ __('OpenGraph Image / Favicon') }}</label>
								<div class="h-avatar h-32 w-32 is-upload is-outline-dark text-2xl" data-generic-preview=".h-avatar">
									<i class="flaticon-upload-1"></i>
									<input type="file" name="opengraph_image">
									<div class="image lozad" data-background-image="{{ gs('media/bio/seo', user('seo.opengraph_image')) }}"></div>
								</div>


								<p class="italic text-xs mt-4">{{ __('A custom Favicon, OpenGraph & Twitter image for your bio page to display a link preview') }}</p>

								@if (mediaExists('media/bio/seo', user('seo.opengraph_image')))
									<a href="{{ route('user-mix-settings-seo-remove-opengraph') }}" app-sandy-prevent="" data-delete="{{ __('Are you sure you want to remove this image?') }}" class="text-sticker bg-red-500 text-white mt-5">{{ __('Remove Image') }}</a>
								@endif
							</div>
					</div>
					
					<button class="sandy-expandable-btn px-10 mt-5"><span>{{ __('Save') }}</span></button>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection