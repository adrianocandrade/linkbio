@extends('mix::layouts.master')
@section('title', __('Theme'))
@section('namespace', 'user-mix-settings-theme')
@section('content')
<div class="mix-padding-10">
	
		
	<div class="card p-5 rounded-2xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
		<div class="card-container bg-repeat-right"
			data-bg="{{ gs('assets/image/others/scribbbles/89.png') }}">

			
			<div class="icon hidden">
				{!! orion('smartphone-1', 'w-20 h-20') !!}
			</div>
			<div class="mt-5 text-2xl font-bold">{{ __('Page Skin') }}</div>
			<div class="my-2 text-xs is-info w-44 mb-5">{{ __('Choose a page skin to change how your page looks.') }}</div>

			<div class="mr-16 mt-5">
				
				<form action="{{ route('user-mix-settings-theme-post') }}" method="POST">
					@csrf
					
					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
						@foreach (\BioStyle::getAll() as $key => $value)
						<label class="theme-html">
							<input type="radio" name="theme" value="{{ $key }}" class="custom-control-input" {{ user('theme') == $key ? 'checked' : '' }}>
							<div class="inner">
								<img src="{{ gs("assets/image/theme/$key", ao($value, 'cover')) }}" alt="">
								<div class="active-dot"></div>


								<div class="info">
									<p class="name font-bold">{{ ao($value, 'name') }}</p>
									<p class="description">{{ ao($value, 'description') }}</p>
								</div>
							</div>
						</label>
						@endforeach
					</div>
					
					<button class="sandy-expandable-btn px-10 mt-5"><span>{{ __('Save') }}</span></button>
				</form>

			</div>
		</div>
	</div>
</div>
@endsection