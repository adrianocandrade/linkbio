@extends('mix::layouts.master')
@section('title', __('Edit Block'))
@section('head')
<style>
.header, header, .floaty-bar, .nav-mobile-header, .header-side, .mix-back-button {
    display: none !important;
}
#content{
    padding: 0 !important;
}
#app-sandy-mix{
    background: #fff !important;
}
</style>
@stop

@section('footerJS')
    @if ($block->block == 'text')
    <script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/tinymce/sr.js') }}"></script>
    <script>
    app.utils.Smalltinymce();
    </script>
    @endif

    <script>
        var block_id = "{{ $block->id }}";
        var heading = "34";
        var sub_heading = "34";
        var doc = jQuery(window.parent.document);
        var block = doc.find('#block-id-' + block_id);
        var load = "{{ bio_url($block->user) }}" + ' #block-id-' + block_id + " > *";

        jQuery('.method-block-submit').submit(function(){
            var heading = jQuery(this).find('.heading').val();
            var subheading = jQuery(this).find('.subheading').val();
            var textareaeditor = jQuery(this).find('.textarea-editor').html();

            block.find('.bio-titles .heading').html(heading);
            block.find('.bio-titles .subheading').html(subheading);

            var parse_textarea = jQuery('<div></div>');
            parse_textarea.html(textareaeditor);
            block.find('.textarea-content .text').html(parse_textarea);

            block.find('.textarea-content .text').load(load);
        });
    </script>
@stop
@section('content')
<form action="{{ route('user-mix-block-edit', $block->id) }}" class="method-block-submit" method="post">
    @csrf
    <div class="form-input">
        <label>{{ __('Heading') }}</label>
        <input type="text" name="blocks[heading]" class="heading" value="{{ ao($block->blocks, 'heading') }}">
    </div>
    @if ($block->block == 'text')

    <div class="is-white rounded-2xl mt-5">
        <textarea name="blocks[content]" class="editor textarea-editor" placeholder="{{ __('Start typing with plain text') }}">{{ ao($block->blocks, 'content') }}</textarea>
    </div>
    @else
    
    <div class="form-input mt-5">
        <label>{{ __('Sub Heading') }}</label>
        <textarea name="blocks[subheading]" class="subheading" cols="5" rows="2">{{ ao($block->blocks, 'subheading') }}</textarea>
    </div>
    @endif
    <button class="mt-5 button w-full">{{ __('Save') }}</button>
</form>
@endsection