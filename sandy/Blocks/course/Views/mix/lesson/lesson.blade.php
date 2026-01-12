@extends('mix::layouts.master')
@section('title', __('Course Lesson'))
@section('content')
<div class="mix-padding-10">
	<form action="{{ route('sandy-blocks-course-mix-lesson-post', ['id' => $course->id, 'type' => $type]) }}" method="post">
		@csrf
		<div class="inner-page-banner rounded-2xl mb-5">
			<div class="thumbnail h-avatar is-elem md is-video bg-white text-black"><i class="sio media-icon-065-video-camera sligh-thick"></i></div>
			<h1 class="mt-5 text-base capitalize">{{ __(":type Lesson", ['type' => $type]) }}</h1>
			<p>{{ __('Add the details for your course lesson.') }}</p>
		</div>
		<div class="mort-main-bg p-5 rounded-2xl">
			<div class="form-input">
				<label>{{ __('Name of Lesson') }}</label>
				<input type="text" class="bg-w" name="name">
			</div>
			<div class="form-input mt-5 mb-0">
				<label>{{ __('Description') }}</label>
				<textarea name="description" class="bg-w"></textarea>
			</div>
			<div class="form-input mt-5">
				<label>{{ __('Lesson duration') }}</label>
				<input type="text" class="bg-w" name="duration">
			</div>
		</div>

		<div class="my-5">
			@includeIf("Blocks-course::mix.lesson.$type.add", ['video_skel' => $video_skel])
		</div>
	</form>
</div>
@endsection