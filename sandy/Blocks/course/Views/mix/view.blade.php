@extends('mix::layouts.master')
@section('title', __('Course'))
@section('content')
@includeIf('include.back-header', ['route' => route('sandy-blocks-course-mix-dashboard')])
<div class="mix-padding-10">
    <div class="flex justify-between align-end items-center p-8 md:p-14 mort-main-bg rounded-2xl mb-5">
        <div class="flex align-center">
            <div class="color-primary flex flex-col">
                <span class="font-bold text-lg mb-1">{{ $course->name }}</span>
                <span class="text-xs text-gray-400">{{ __('Manage your course from here.') }}</span>
            </div>
        </div>
    </div>
    <div class="sandy-expandable-block">
        <h4 class="sandy-expandable-header">
        <div>
            <h4 class="sandy-expandable-title">{{ __('Edit') }}</h4>
            <p class="sandy-expandable-description">{{ __('Edit this course information') }}</p>
        </div>
        <a class="sandy-expandable-btn ml-3" app-sandy-prevent="" href="{{ route('sandy-blocks-course-mix-edit-course', $course->id) }}"><span>{{ __('Edit') }}</span></a>
        </h4>
    </div>
    <div class="sandy-expandable-block">
        <h4 class="sandy-expandable-header">
        <div>
            <h4 class="sandy-expandable-title">{{ __('Lesson') }}</h4>
            <p class="sandy-expandable-description">{{ __('Manage & setup lessons your users have access to once course is purchased.') }}</p>
        </div>
        <a class="sandy-expandable-btn  ml-3" href="{{ route('sandy-blocks-course-mix-lessons', $course->id) }}"><span>{{ __('Add Lesson') }}</span></a>
        </h4>
    </div>
    <div class="sandy-expandable-block">
        <h4 class="sandy-expandable-header">
        <div>
            <h4 class="sandy-expandable-title">{{ __('Delete') }}</h4>
            <p class="sandy-expandable-description">{{ __('Delete this course. Note: all information will be removed completly.') }}</p>
        </div>
        <form action="{{ route('sandy-blocks-course-mix-delete', $course->id) }}" method="post">
            @csrf
            <button class="sandy-expandable-btn ml-3 bg-red-500 text-white" data-delete="{{ __('Are you sure you want to delete this course and it content?') }}"><span>{{ __('Delete') }}</span></button>
        </form>
        </h4>
    </div>
</div>
@endsection