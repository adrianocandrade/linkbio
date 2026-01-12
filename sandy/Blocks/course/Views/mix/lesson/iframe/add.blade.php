<div class="mort-main-bg p-5 rounded-2xl">
    <div class="form-input">
        <label>{{ __('Link') }}</label>
        <input type="text" name="data[embed]" class="bg-w" id="video-link">
        <p class="mt-5 text-xs">{!! __t('This link will be shown in an iframe. Not all url are supported.') !!}</p>
    </div>
    <button class="button mt-5">{{ __('Save') }}</button>
</div>