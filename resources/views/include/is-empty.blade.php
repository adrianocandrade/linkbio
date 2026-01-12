<div class="no-record">
  <div class="rounded-3xl block p-5">
    <div class="text-center flex justify-center flex-col items-center">
      <img data-src="{{ gs('assets/image/emoji/Yellow-1/Speechless.png') }}" class="lozad w-20" alt="">
      <div class="text-xl font-bold mt-5">{{ __('This isn\'t right?') }}</div>
      <div class="w-3/4 mt-3">
        <div class="text-sm text-gray-400">{{ __('It\'s kinda lonely here! Start creating.') }}</div>

        @if (isset($link))

          <a href="{{ ao($link, 'link') }}" class="mt-5 sandy-expandable-btn rounded-lg sandy-loader-flower {{ ao($link, 'class') }}"><span>{{ ao($link, 'title') }}</span></a>
        @endif
      </div>
    </div>
  </div>
</div>