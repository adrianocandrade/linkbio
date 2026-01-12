@extends('mix::layouts.master')
@section('title', __('Create Highlight'))
@section('content')

<div class="mix-padding-10">
    <div class="dashboard-header-banner relative mb-5">
        <div class="card-container">
            
            <div class="text-lg font-bold">{{ __('Highlight') }}</div>
            <div class="side-cta">
                <img src="{{ gs('assets/image/emoji/Yellow-1/Selfie.png') }}" alt="">
            </div>
        </div>
    </div>
    <form method="post" action="{{ route('user-mix-highlight-create-post') }}" enctype="multipart/form-data">
        @csrf
        <div class="wj-image-selector-w is-avatar relative sandy-upload-modal-open is-sandy-upload-modal" data-generic-preview=".h-avatar">
            <a class="wj-image-selector-trigger rounded-xl flex items-center relative">
                <div class="wj-image-container inline-flex items-center justify-center">
                    <img src=" " alt="">
                </div>
                <div class="wj-image-selector-text ml-3 flex flex-col">
                    <span class="wj-text-holder text-sm font-bold">{{ __('Upload a thumbnail') }}</span>
                    <span class="font-8 font-bold uppercase">{{ __(':mb Max', ['mb' => '2mb']) }}</span>
                </div>
            </a>
        </div>

        <div class="form-input mb-5">
            <label>{{ __('Add text or Emoji') }}</label>
            <input type="text" name="content[heading]">
        </div>

        {!! Elements::LinkOrElementHtml($user->id, ['element' => '']) !!}


        {!! sandy_upload_modal() !!}
        
        <button class="button w-full mt-5 is-loader-submit loader-white">{{ __('Save') }}</button>
    </form>
</div>
@endsection