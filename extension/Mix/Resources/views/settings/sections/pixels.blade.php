@extends('mix::layouts.master')
@section('title', __('Pixel'))
@section('namespace', 'user-mix-settings-pixel')
@section('footerJS')
<script>
	app.utils.pixel_popup = function(){
		jQuery('[data-popup=".edit-pixel"]').on('dialog:open', function(e, $elem) {
			var pixel_name = jQuery($elem).data('name');
			var pixel_type = jQuery($elem).data('type');
			var pixel_id = jQuery($elem).data('pixel-id');
			var pixel_status = jQuery($elem).data('status');
			var id = jQuery($elem).data('id');
			var $dialog = jQuery(this);
			$dialog.find('input[name="pixel_id"]').parent('.form-input').addClass('active');
			$dialog.find('input[name="id"]').val(id);
			$dialog.find('input[name="pixel_name"]').val(pixel_name);
			$dialog.find('input[name="pixel_id"]').val(pixel_id);
			$dialog.find('select[name="pixel_status"] option[value="'+ pixel_status +'"]').prop('selected', true);


      $dialog.find('[name="pixel_type"]').each(function(){
        if(jQuery(this).val() === pixel_type){
          jQuery(this).prop('checked', true);
        }
      });
		});
	}
	app.utils.pixel_popup();
</script>
@stop
@section('content')
<div class="mix-padding-10">
	
		
	<div class="relative">
		@if (!plan('settings.pixel_codes'))
		@include('include.no-plan')
		@endif
        <div class="card p-5 rounded-2xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
            <div class="card-container bg-repeat-right"
                data-bg="{{ gs('assets/image/others/scribbbles/63.png') }}">
                <div class="mt-5 text-2xl font-bold">{{ __('Pixel Codes') }}</div>
                <div class="my-2 text-xs is-info w-44 mb-5">{{ __('Pixel helps you better with analytics, conversion, retargeting.') }}</div>

				<a class="sandy-expandable-btn px-10 pixel-open mb-5"><span>{{ __('Create Pixel') }}</span></a>

				<div class="mr-14">
					
					@if (!$pixels->isEmpty())
					<div class="flex-table">
						<!--Table header-->
						<div class="flex-table-header mort-main-bg hidden">
							<span class="is-grow">{{ __('Type') }}</span>
							<span>{{ __('Name') }}</span>
							<span>{{ __('Status') }}</span>
							<span class="cell-end">{{ __('Actions') }}</span>
						</div>
						@foreach ($pixels as $item)
						<div class="flex-table-item rounded-2xl shadow-none border-2 border-solid border-gray-200">
							<div class="flex-table-cell is-media is-grow" data-th="">
								<div class="h-avatar sm is-video p-2" style="background: {{ $skeleton_pixel($item->pixel_type, 'color') }}">
									<i class="text-2xl {{ $skeleton_pixel($item->pixel_type, 'icon') }}"></i>
									{!! $skeleton_pixel($item->pixel_type, 'svg') !!}
								</div>
								<div>
									<span class="item-name md:text-xs">{{ $skeleton_pixel($item->pixel_type, 'name') }}</span>
								</div>
							</div>
							<div class="flex-table-cell" data-th="{{ __('Name') }}">
								<span class="light-text">{{ $item->name }}</span>
							</div>
							<div class="flex-table-cell" data-th="{{ __('Status') }}">
								<span class="dark-inverted is-weight-600">{{ $status($item->status) }}</span>
							</div>
							<div class="flex-table-cell cell-end" data-th="Actions">
								<a href="#" class="text-sticker m-0 ml-auto edit-pixel-open" data-name="{{ $item->name }}" data-type="{{ $item->pixel_type }}" data-status="{{ $item->status }}" data-pixel-id="{{ $item->pixel_id }}" data-id="{{ $item->id }}">
									{{ __('Edit') }}
								</a>


								<form action="{{ route('user-mix-settings-pixels-post', 'delete') }}" method="post">
									@csrf 
									<input type="hidden" name="id" value="{{ $item->id }}">

									<button class="text-sticker bg-red-500 ml-4 c-white m-0 cursor-pointer" data-delete="{{ __('Are you sure you want to delete this pixel?') }}" data-title="{{ __('Delete Pixel') }}">
										<i class="flaticon-delete"></i>
									</button>
								</form>
							</div>
						</div>
						@endforeach
					</div>
					@else
						@include('include.is-empty')
					@endif
				</div>

			</div>
		</div>
	</div>
	
</div>



<div data-popup=".pixel" class="sandy-dialog-overflow">
	<div class="sandy-dialog-body">
		
		<form method="post" action="{{ route('user-mix-settings-pixels-post', 'new') }}" enctype="multipart/form-data">
			@csrf
			<div class="card customize mb-5">
				<div class="card-header">
					<div class="flex items-center mb-3">
						<h1 class="mb-0 title text-base font-bold">{{ __('Add Pixel') }}</h1>
					</div>
					<p class="text-xs text-gray-600">{{ __('Choose from the available pixel types & add your pixel ID down below to begin tracking.') }}</p>
				</div>
			</div>
			<div class="grid sm:grid-cols-2 gap-1 md:gap-4 mb-5">
				@foreach ($skeleton as $key => $value)
				<label class="sandy-big-checkbox">
					<input type="radio" name="pixel_type" class="sandy-input-inner" data-placeholder-input="#pixel_new_id" data-placeholder="{{ ao($value, 'placeholder') }}" {{ $key == 'facebook' ? 'checked' : '' }} value="{{ $key }}">
					<div class="checkbox-inner">
						<div class="checkbox-wrap">
							<div class="h-avatar sm is-video p-2" style="background: {{ ao($value, 'color') }}">
								<i class="{{ ao($value, 'icon') }}"></i>
								{!! ao($value, 'svg') !!}
							</div>
							<div class="content ml-2 flex items-center">
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
			<div class="grid grid-cols-2 mt-5 gap-4">
				<div class="form-input">
					<label class="initial">{{ __('Pixel Name') }}</label>
					<input type="text" name="pixel_name">
				</div>
				<div class="form-input">
					<label class="initial">{{ __('Pixel Status') }}</label>
					<select name="pixel_status" id="">
						<option value="1">{{ __('Active') }}</option>
						<option value="0">{{ __('Hidden') }}</option>
					</select>
				</div>
				<div class="form-input col-span-2">
					<label>{{ __('Pixel ID') }}</label>
					<input type="text" name="pixel_id" id="pixel_new_id">
				</div>
			</div>
			<button class="button main w-full mt-5" type="submit">{{ __('Save') }}</button>
		</form>
	</div>
</div>

<div data-popup=".edit-pixel" class="sandy-dialog-overflow">
	<form method="post" action="{{ route('user-mix-settings-pixels-post', 'edit') }}" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="id">
		<div class="card customize mb-5">
			<div class="card-header">
				<div class="flex items-center">
					<h1 class="mb-0 title text-base">{{ __('Edit Pixel') }}</h1>
				</div>
			</div>
		</div>
		<div class="grid sm:grid-cols-2 gap-1 md:gap-4 mb-5">
			@foreach ($skeleton as $key => $value)
			<label class="sandy-big-checkbox">
				<input type="radio" name="pixel_type" class="sandy-input-inner" data-placeholder-input="#pixel_edit_id" data-placeholder="{{ ao($value, 'placeholder') }}" {{ $key == 'facebook' ? 'checked' : '' }} value="{{ $key }}">
				<div class="checkbox-inner">
					<div class="checkbox-wrap">
						<div class="h-avatar sm is-video p-2" style="background: {{ ao($value, 'color') }}">
							<i class="{{ ao($value, 'icon') }}"></i>
							{!! ao($value, 'svg') !!}
						</div>
						<div class="content ml-2 flex items-center">
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
		<div class="grid grid-cols-2 mt-5 gap-4">
			<div class="form-input">
				<label class="initial">{{ __('Pixel Name') }}</label>
				<input type="text" name="pixel_name">
			</div>
			<div class="form-input">
				<label class="initial">{{ __('Pixel Status') }}</label>
				<select name="pixel_status" id="">
					<option value="1">{{ __('Active') }}</option>
					<option value="0">{{ __('Hidden') }}</option>
				</select>
			</div>
			<div class="form-input col-span-2">
				<label>{{ __('Pixel ID') }}</label>
				<input type="text" name="pixel_id" id="pixel_edit_id">
			</div>
		</div>
		<button class="button main mt-5 w-full" type="submit">{{ __('Save') }}</button>
	</form>
</div>
@endsection