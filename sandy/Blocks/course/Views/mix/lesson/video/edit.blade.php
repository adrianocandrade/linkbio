<div class="mort-main-bg p-5 rounded-2xl mt-5">
	
	
	<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
		@foreach ($video_skel as $key => $value)
		<label class="sandy-big-checkbox">
			<input type="radio" name="data[type]" class="sandy-input-inner" data-placeholder-input="#video-link" data-placeholder="{{ ao($value, 'placeholder') }}" {{ ao($data, 'type') == $key ? 'checked' : '' }} value="{{ $key }}">
			<div class="checkbox-inner rounded-2xl border-0">
				<div class="checkbox-wrap">
					<div class="h-avatar sm is-video" style="background: {{ ao($value, 'color') }}">
						<i class="{{ ao($value, 'icon') }}"></i>
						{!! ao($value, 'svg') !!}
					</div>
					<div class="content ml-2 flex items-center">
						<h1>{{ ao($value, 'name') }}</h1>
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
	<div class="form-input">
		<label class="initial">{{ __('URL Link') }}</label>
		<input type="text" name="data[link]" class="bg-w" id="video-link" value="{{ ao($data, 'link') }}">
	</div>
	<button class="mt-5 text-sticker sandy-loader-flower">{{ __('Save') }}</button>
</div>