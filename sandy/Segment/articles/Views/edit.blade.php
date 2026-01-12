@extends('mix::layouts.master')
@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}"></script>
<script>
app.utils.Smalltinymce();
</script>
@stop
@section('content')
<form action="{{ route("sandy-app-articles-edit", $element->slug) }}" class="mix-padding-10" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        <div class="form-input mb-5">
            <label>{{ __('Article Name') }}</label>
            <input type="text" class="bg-w" name="label" value="{{ $element->name }}">
        </div>
        <div class="form-input mb-0">
            <label>{{ __('Time to read') }}</label>
            <input type="text" class="bg-w" name="content[ttr]" value="{{ ao($element->content, 'ttr') }}">
        </div>
    </div>
    <div class="mt-5 mort-main-bg rounded-2xl p-5">
        <p class="mb-5 text-lg font-bold">{{ __('Paywall') }}</p>
        
        <div class="form-input mb-5">
            <label class="initial">{{ __('Enable Paywall') }}</label>
            <select name="content[paywall][enable]" class="bg-w" data-sandy-select=".select-shift">
                <option value="enable" {{ ao($element->content, 'paywall.enable') == 'enable' ? 'selected' : '' }}>{{ __('Enable') }}</option>
                <option value="disable" {{ ao($element->content, 'paywall.enable') == 'disable' ? 'selected' : '' }}>{{ __('Disable / Free') }}</option>
            </select>
        </div>
        <div class="select-shift">
            <div class="hide" data-sandy-open="enable">
                <div class="grid grid-cols-1 gap-4">
                    <div class="form-input is-link always-active active bg-white">
                        <label>{{ __('Price') }}</label>
                        <div class="is-link-inner">
                            <div class="side-info">
                                <p>{!! Currency::symbol(ao($bio->payments, 'currency')) !!}</p>
                            </div>
                            <input type="number" name="content[paywall][price]" value="{{ ao($element->content, 'paywall.price') }}" class="bg-w">
                        </div>
                    </div>

                    <div class="form-input">
                        <label class="initial">{{ __('Limit words') }}</label>
                        <input type="text" name="content[paywall][limit_words]" value="{{ ao($element->content, 'paywall.limit_words') }}" class="bg-w">
                    </div>

                    <p class="text-xs mt-2">
                        {{ __('Limit words before paywall starts') }}
                    </p>
                    
                </div>
            </div>
            <div data-sandy-open="disable" class="hide">
            </div>
        </div>
    </div>
    <div class="mort-main-bg rounded-2xl p-5 mt-5">
        
        <div class="form-input bio-tox">
            <label>{{ __('Description') }}</label>
            <textarea name="content[description]" class="bg-w editor">{{ ao($element->content, 'description') }}</textarea>
        </div>
    </div>


    <button class="mt-5 button">{{ __('Save') }}</button>
</form>
@endsection