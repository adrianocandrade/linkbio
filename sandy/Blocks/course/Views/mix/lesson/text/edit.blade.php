@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}" data-barba-script></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}" data-barba-script></script>
<script data-barba-script>
app.utils.Smalltinymce();
</script>
@stop
<div class="bio-tox is-white mort-main-bg rounded-2xl p-5">
    <textarea name="data[text]" class="editor" placeholder="{{ __('Start typing with plain text') }}">{{ ao($data, 'text') }}</textarea>
</div>
<button class="button mt-5">{{ __('Save') }}</button>