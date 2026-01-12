@extends('mix::layouts.master')
@section('title', __('New Block'))
@section('content')
@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}"></script>
<script>
app.utils.Smalltinymce();
</script>
@stop
<div class="card customize m-5 md:m-10 mb-5 md:mb-0 rounded-2xl">
    <div class="card-header">
        <div class="flex items-center mb-3">
            <div class="h-avatar sm mr-3 bg-white border-0 is-video">
                <i class="sni sni-text c-black"></i>
            </div>
            <h1 class="mb-0 title text-lg">{{ __('Edit Text') }}</h1>
        </div>
        @if (Route::has('docs-index'))
        <a href="{{ route('docs-index', ['query' => 'Blocks']) }}" target="_blank" app-sandy-prevent class="mt-10 text-xs c-black font-bold href-link-button">{{ __('Need Help?') }}</a>
        @endif
    </div>
</div>
<form class="p-5 md:p-10" method="post" action="{{ route('sandy-blocks-text-post-edit', $block->id) }}">
    @csrf
    <div class="mort-main-bg rounded-2xl p-5 mb-7">
        
        <div class="form-input">
            <label for="">{{ __('Heading') }}</label>
            <input type="text" class="bg-w" value="{{ ao($block->blocks, 'heading') }}" name="heading">
        </div>
    </div>
    <div class="bio-tox is-white rounded-2xl mort-main-bg p-5">
        <textarea name="content" class="editor lol" placeholder="{{ __('Start typing with plain text') }}">{{ ao($block->blocks, 'content') }}</textarea>
    </div>
    <button class="button mt-5">{{ __('Save') }}</button>
</form>
@endsection