<div class="mort-main-bg p-5 rounded-2xl">
    <div class="form-input">
        <label>{{ __('Link') }}</label>
        <input type="text" name="data[link]" class="bg-w" id="video-link" value="{{ ao($data, 'link') }}">
        <p class="mt-5 text-xs">{!! __t('Make sure it\'s a direct url to the audio or it wont work. Your audo url should play like <a href="https://interactive-examples.mdn.mozilla.net/media/cc0-audio/t-rex-roar.mp3" class="underline" target="_blank">this</a> in your browser if visited. If not, it cant be used.') !!}</p>
    </div>
    <button class="button mt-5">{{ __('Save') }}</button>
</div>