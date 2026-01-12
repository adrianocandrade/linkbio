@extends('mix::layouts.master')
@section('title', __('Create Workspace'))
@section('mix-body-class', 'bg-white')
@section('content')
<div class="mix-padding-10">
    <div class="mb-10">
        <p class="text-lg font-bold">{{ __('Create New Workspace') }}</p>
        <p class="text-xs text-gray-400">{{ __('Each workspace is a separate LinkBio page with its own settings.') }}</p>
    </div>

    <form action="{{ route('workspace-store') }}" method="POST" class="mort-main-bg p-5 rounded-2xl">
        @csrf

        <div class="form-input mb-7">
            <label>{{ __('Workspace Name') }}</label>
            <input type="text" name="name" class="bg-w" required>
        </div>

        <div class="form-input is-link always-active active mb-7">
            <label class="is-alt-label hidden">{{ __('URL Slug') }}</label>
            <div class="is-link-inner">
                <div class="side-info">
                    {{ config('app.url') }}/
                </div>
                <input type="text" name="slug" class="is-alt-input bg-white" required>
            </div>
        </div>

        <button class="mt-5 sandy-expandable-btn"><span>{{ __('Create Workspace') }}</span></button>
    </form>
</div>
@endsection
