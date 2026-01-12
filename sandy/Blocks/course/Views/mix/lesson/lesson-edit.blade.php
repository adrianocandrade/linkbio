@extends('mix::layouts.master')
@section('title', __('Course Lesson'))
@section('content')
<div class="mix-padding-10">
	<form action="{{ route('sandy-blocks-course-mix-edit-lesson-post', ['id' => $lesson->id]) }}" method="post">
		@csrf
		<div class="mort-main-bg p-5 rounded-2xl">
			<div class="form-input">
				<label>{{ __('Name of Lesson') }}</label>
				<input type="text" class="bg-w" name="name" value="{{ $lesson->name }}">
			</div>
			<div class="form-input mt-5 mb-0">
				<label>{{ __('Description') }}</label>
				<textarea name="description" class="bg-w">{{ $lesson->description }}</textarea>
			</div>
			<div class="form-input mt-5">
				<label>{{ __('Lesson duration') }}</label>
				<input type="text" class="bg-w" name="duration" value="{{ $lesson->lesson_duration }}">
			</div>
		</div>

		<div class="my-5">
			@includeIf("Blocks-course::mix.lesson.$lesson->lesson_type.edit", ['video_skel' => $video_skel, 'data' => $lesson->lesson_data])
		</div>
	</form>
</div>
@endsection