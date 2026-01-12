<div class="card customize p-5 my-10 rounded-3xl">
	<div class="card-header">
		<p class="title m-0 text-sm">{{ __('Link') }}</p>
	</div>
</div>
<div data-checkbox-wrapper="">
	<div class="grid grid-cols-2 gap-4 mb-0">
		<label class="sandy-big-checkbox">
			<input type="radio" name="is_element" class="sandy-input-inner" data-checkbox-open=".element-type" value="1" {{ ao($defaults, 'is_element') ? 'checked' : '' }}>
			<div class="checkbox-inner rounded-2xl">
				<div class="checkbox-wrap">
					<div class="content">
						<h1>{{ __('Accelerated Page') }}</h1>
						<p>{{ __('Internal Pages') }}</p>
					</div>
					<div class="icon">
						<div class="active-dot"><i class="la la-check"></i></div>
					</div>
				</div>
			</div>
		</label>
		<label class="sandy-big-checkbox">
			<input type="radio" name="is_element" class="sandy-input-inner" data-checkbox-open=".link-type" value="0" {{ !ao($defaults, 'is_element') ? 'checked' : '' }}>
			<div class="checkbox-inner rounded-2xl">
				<div class="checkbox-wrap">
					<div class="content">
						<h1>{{ __('External') }}</h1>
						<p>{{ __('Enternal link url') }}</p>
					</div>
					<div class="icon">
						<div class="active-dot"><i class="la la-check"></i></div>
					</div>
				</div>
			</div>
		</label>
	</div>
	
	<div class="is-rounded mb-5 mt-5 element-type" data-checkbox-item>
		
		@if ($element = \App\Models\Element::find(ao($defaults, 'element_id')))
		<div class="card-center p-5 rounded-xl mt-5" style="
			box-shadow: rgb(0 0 0 / 3%) 0px 20px 25px -5px, rgb(0 0 0 / 2%) 0px 10px 10px -5px;
			background: #ebeef0;
			">
			<div class="flex">
				<div class="items-center flex mr-4">
					{!! Elements::icon($element->element) !!}
				</div>
				<div class="items-center ps-3 ms-1">
					<h1 class="font-20 mb-n1">{{ $element->name }}</h1>
					<p class="mb-0 font-12 opacity-70 text-xs mt-1">{{ __('View and edit your connected accelerated page') }}</p>
				</div>
			</div>
			<div class="flex mt-3">
				@if (Route::has("sandy-app-$element->element-edit"))
				<a href="{{ route("sandy-app-$element->element-edit", $element->slug) }}" app-sandy-prevent="" class="sandy-expandable-btn bg-white mr-2"><span>{{ __('Edit') }}</span></a>
				@endif
				@if (Route::has("sandy-app-$element->element-database"))
				<a href="{{ route("sandy-app-$element->element-database", $element->slug) }}" app-sandy-prevent="" class="sandy-expandable-btn bg-white"><span>{{ __('Submissions') }}</span></a>
				@endif
			</div>
		</div>
		@else
		<button class="mt-0 element-selector-open cursor-pointer sandy-expandable-btn"><span>{{ __('Select 🔥') }}</span></button>
		@endif
	</div>
	<div class="form-input link-type mt-5" data-checkbox-item>
		<label>{{ __('Link') }}</label>
		<input type="text" name="link" value="{{ ao($defaults, 'link') }}">
	</div>
</div>




<div class="half-short sandy-dialog-overflow" data-popup=".element-selector">
	<div class="sandy-dialog-body relative z-10">
		
		<div class="flex justify-between align-end items-center p-8 md:p-14 mort-main-bg rounded-2xl mb-5">
			<div class="flex align-center">
				<div class="color-primary flex flex-col">
					<span class="font-bold text-lg mb-1">{{ __('Accelerated Page') }}</span>
					<span class="text-xs text-gray-400">{{ __('Select one of your created page.') }}</span>
				</div>
			</div>
		</div>
		@forelse (elements($user->id) as $element)
		
		<label class="sandy-big-checkbox relative z-10 mb-5">
			<input type="radio" name="element" class="sandy-input-inner" value="{{ $element->id }}" {{ $element->id == ao($defaults, 'element_id') ? 'checked' : '' }}>
			<div class="checkbox-inner rounded-2xl">
				<div class="meta-app">
					{!! ElementIcon($element->element) !!}
					<div class="content">
						<p class="title">{{ $element->name }}</p>
						<span>{{ __('Added :date', ['date' => \Carbon\Carbon::parse($element->create_at)->format('F d')]) }}</span>
					</div>
					<div class="active-dot ml-auto rounded-lg">
						<i class="la la-check"></i>
					</div>
				</div>
			</div>
		</label>
		@empty
		@include('include.is-empty', ['link' => ['link' => route('user-mix-block-new'), 'title' => __('Create')]])
		@endforelse
	</div>


	<button class="mt-5 element-selector-close cursor-pointer sandy-expandable-btn"><span>{{ __('Select') }}</span></button>
</div>