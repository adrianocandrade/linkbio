@extends('mix::layouts.master')
@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}"></script>
<script>
  app.utils.tinymce();
</script>
@stop
@section('content')

<form action="{{ route('sandy-app-textarea-create') }}" method="post">
    @csrf
    <input type="hidden" value="textarea" name="section">
    
    <div class="inner-page-banner">

        {!! Elements::icon('textarea') !!}

        <h1 class="mt-5 text-base">{{ Elements::config('textarea', 'name') }}</h1>
        <p>{{ Elements::config('textarea', 'description') }}</p>

        <div class="form-input mt-5">
            <label>{{ __('Element Label') }}</label>
            <input type="text" class="bg-w" name="label">
        </div>

        <div class="mt-4">
            <button class="text-sticker">{{ __('Save') }}</button>
        </div>
    </div>
    <div class="p-10">
        <div class="form-input mb-7">
            <label for="login-username">{{ __('Textarea') }}</label>
            <textarea name="textarea" class="editor"></textarea>
        </div>
    </div>
</form>

@endsection
