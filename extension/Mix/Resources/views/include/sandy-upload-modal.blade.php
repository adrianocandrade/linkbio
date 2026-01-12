<div data-popup=".sandy-upload-modal" class="small rounded-2xl sandy-dialog-overflow dialog-overflow-all-height sandy-upload-modal-dialog">
	<div class="sandy-tabs">
		<div class="mb-0">
			<p class="text-lg font-bold">{{ __('Upload Media') }}</p>
		</div>
		<div class="grid grid-cols-2 md:grid-cols-2 gap-4">
			<label class="profile-background-types-wrapper sandy-tabs-link {{ ao($data, 'type') == 'upload' ? 'active' : '' }} {{ !ao($data, 'type') ? 'active' : '' }}">
				
				<input type="radio" name="sandy_upload_media_type" value="upload" {{ ao($data, 'type') == 'upload' ? 'checked' : '' }} {{ !ao($data, 'type') ? 'checked' : '' }}>
				<div class="profile-background-types mort-main-bg shadow-none rounded-2xl">
					<div class="active-dot"></div>
					<div class="icon is-ava">
						{!! svg_i('camera-1', 'w-8 h-5') !!}
					</div>
					<p>{{ __('Upload Image') }}</p>
				</div>
			</label>
			<label class="profile-background-types-wrapper sandy-tabs-link {{ ao($data, 'type') == 'external' ? 'active' : '' }}">
				<input type="radio" name="sandy_upload_media_type" value="external" {{ ao($data, 'type') == 'external' ? 'checked' : '' }}>
				<div class="profile-background-types mort-main-bg shadow-none rounded-2xl">
					<div class="active-dot"></div>
					<div class="icon is-ava">
						{!! svg_i('link-2', 'w-8 h-5') !!}
					</div>
					<p>{{ __('Media Url') }}</p>
				</div>
			</label>
			<label class="profile-background-types-wrapper sandy-tabs-link {{ ao($data, 'type') == 'solid_color' ? 'active' : '' }}">
				<input type="radio" name="sandy_upload_media_type" value="solid_color" {{ ao($data, 'type') == 'solid_color' ? 'checked' : '' }}>
				<div class="profile-background-types mort-main-bg shadow-none rounded-2xl">
					<div class="active-dot"></div>
					<div class="icon is-ava">
						<i class="flaticon-photo-camera"></i>
					</div>
					<p>{{ __('Solid Color') }}</p>
					<div class="p-1 text-xs flex items-center justify-center bg-yellow-200">BETA</div>
				</div>
			</label>
		</div>
		<div class="mt-10">
			
			<div class="sandy-tabs-item">
				<div class="flex items-center flex-col">
					<div class="thumbnail-upload- boxed block w-full">
						<div class="h-avatar h-40 w-full is-upload is-outline-dark text-2xl is-sandy-upload-modal {{ !empty(ao($data, 'image_upload')) ? 'selected' : '' }}" data-generic-preview>
							<i class="flaticon-upload-1"></i>
							<input type="file" name="sandy_upload_media_upload" accept="image/*">
							<div class="image lozad sandy-upload-modal-identifier" data-background-image="{{ ao($data, 'upload') }}"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="sandy-tabs-item">
				<div class="form-input">
					<label>{{ __('Link') }}</label>
					<input type="text" name="sandy_upload_media_link"  value="{{ ao($data, 'link') }}">
				</div>
				<p class="text-xs text-gray-400 mt-2">{{ __('Media URL can be a type of image or video.') }}</p>
			</div>
			<div class="sandy-tabs-item">
				
				<div class="form-wrap" pickr>
					<label>{{ __('Solid Color') }}</label>
					<input pickr-input type="hidden" name="sandy_upload_solid_color" value="{{ ao($data, 'solid_color') ?? '#000' }}">
					<div id="sandy-modal-pickr" pickr-div></div>
				</div>
			</div>
		</div>
		<a class="sandy-expandable-btn sandy-upload-modal-close mt-5"><span>{{ __('Select') }}</span></a>
	</div>
</div>