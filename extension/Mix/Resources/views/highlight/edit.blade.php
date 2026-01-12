@extends('mix::layouts.master')
@section('title', __('Edit Highlight'))
@section('content')
<div class="mix-padding-10">
    
    <div class="dashboard-header-banner relative mb-5">
        <div class="card-container">
            
            <div class="text-lg font-bold">{{ __('Edit Highlight') }}</div>
            <div class="side-cta">
                <img src="{{ gs('assets/image/emoji/Yellow-1/Selfie.png') }}" alt="">
            </div>
        </div>
    </div>
    <form action="{{ route('user-mix-highlight-delete', $highlight->id) }}" method="POST" class="mb-5">
        @csrf
        <button data-delete="{{ __('Are you sure you want to delete this highlight?') }}" class="sandy-expandable-btn px-10 bg-red-400 text-white"><span>{{ __('Remove') }}</span></button>
    </form>
    <form method="post" action="{{ route('user-mix-highlight-edit-post', $highlight->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="wj-image-selector-w is-avatar relative sandy-upload-modal-open is-sandy-upload-modal active" data-generic-preview=".h-avatar">
            <a class="wj-image-selector-trigger rounded-xl flex items-center relative">
                <div class="wj-image-container inline-flex items-center justify-center">
                    {!! media_or_url($highlight->thumbnail, 'media/highlight', true) !!}
                </div>
                <div class="wj-image-selector-text ml-3 flex flex-col">
                    <span class="wj-text-holder text-sm font-bold">{{ __('Upload a thumbnail') }}</span>
                    <span class="font-8 font-bold uppercase">{{ __(':mb Max', ['mb' => '2mb']) }}</span>
                </div>
            </a>
        </div>
        <div class="form-input mb-5">
            <label>{{ __('Add text or Emoji') }}</label>
            <input type="text" name="content[heading]" value="{{ ao($highlight->content, 'heading') }}">
        </div>
        {!! Blocks::LinkOrElementHtml($user->id, ['is_element' => (int) $highlight->is_element, 'element_id' => $highlight->element, 'link' => $highlight->link]) !!}
    
        {!! sandy_upload_modal($highlight->thumbnail, 'media/highlight') !!}
        
        <button class="button w-full mt-5 is-loader-submit loader-white">{{ __('Save') }}</button>
    </form>
</div>
@endsection