<div class="not-plan">
  <div class="content">
    <div class="step-banner mb-0">
      <div class="section-header">
        <div class="section-header-info">
          <div class="flex items-center mb-2">
            <i class="sio web-hosting-052-error-page text-4xl"></i>
          </div>
          <p class="text-sm">{{ __('Your current plan does not allow you access this feature.') }}</p>
          <div class="section-header-actions mt-2">
            <a href="{{ Route::has('pricing-index') ? route('pricing-index') : '' }}" app-sandy-prevent="" class="section-header-action text-sticker">{{ __('Change Plan') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="opacity-reduce"></div>
</div>