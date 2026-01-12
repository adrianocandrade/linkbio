@extends('mix::layouts.master')
@section('title', __('Course lesson'))
@section('content')
<div class="mix-padding-10 relative z-10">
	<div class="fancy-back-arrow card_widget relative item-center bg-gray-200 card-inherit">
		<a class="back-button" href="{{ route('sandy-blocks-course-mix-view', $course->id) }}">
		<i class="la la-arrow-left"></i>
		{{ __('Course') }}
		</a>
		<p class="text-xl font-bold">{{ __('Lessons') }}</p>
	</div>
	@if (!$lessons->isEmpty())
	<div class="mt-10 bg-gray-200 p-5 rounded-2xl sortable gap-4 grid sm:grid-cols-2" data-delay="150" data-route="{{ route('sandy-blocks-course-mix-lessons-sort', $course->id) }}">
		@foreach ($lessons as $item)
		<div class="edit-lesson card card_widget p-5 flex items-center rounded-2xl justify-between sortable-item" data-id="{{ $item->id }}">
			<h5 class="card-title mb-0 text-base truncate">
			<i class="{{ $types_icon($item->lesson_type) }} sligh-thick text-lg mr-3"></i>
			<span class="font-light c-light text-xs">
				{{ strtoupper($item->lesson_type) }}
			</span>:
			<span class="text-sm">
				{{ $item->name }}
			</span>
			</h5>
			<div class="card-widgets flex text-lg">
				<a href="{{ route('sandy-blocks-course-mix-edit-lesson', $item->id) }}" app-sandy-prevent="" class="ml-2"><i class="la la-pencil"></i></a>
				<form action="{{ route('sandy-blocks-course-mix-lesson-delete', $item->id) }}" method="post">
					@csrf
					<button class="ml-2" data-delete="{{ __('Are you sure you want to delete this lesson?') }}"><i class="la la-trash"></i></button>
				</form>
				<p class="ml-4 cursor-pointer"><i class="sni sni-move"></i></p>
			</div>
		</div>
		@endforeach
	</div>
	@else
	<div class="p-10">
		@includeIf('include.is-empty', ['link' => ['title' => __('Add Lesson'), 'link' => '#', 'class' => 'lesson-types-open bg-white']])
	</div>
	@endif
</div>
<div class="add-new-link mt-10">
	<a class="el-btn bg-gray-200 rounded-xl lesson-types-open" href="#"><i class="sni sni-plus"></i></a>
</div>
<div data-popup=".lesson-types">
	<div class="fancy-back-arrow card_widget mb-7 relative item-center flex-col bg-gray-200 card-inherit">
		<h1 class="text-black">{{ __('Lesson Types') }}</h1>
		<p class="mt-3 text-xs text-black">{{ __('Choose your lesson type & proceed to addiing course lesson.') }}</p>
	</div>
	
	<div class="grid grid-cols-2 gap-4">
		@foreach ($lesson_types as $key => $value)
		<a class="sandy-big-checkbox relative z-10" app-sandy-prevent="" href="{{ route('sandy-blocks-course-mix-lesson-types', ['id' => $course->id, 'type' => $key]) }}">
			<div class="checkbox-inner rounded-2xl bg-gray-200 card_widget relative card-inherit">
				<div class="checkbox-wrap">
					<div class="content flex items-center justify-center">
						<div class="icon">
							<i class="{{ ao($value, 'icon') }} text-xl mr-3"></i>
						</div>
						<h1>{{ ao($value, 'name') }}</h1>
					</div>
				</div>
			</div>
		</a>
		@endforeach
	</div>
</div>
@endsection