<div class="login-include">
  
  <div class="social-links is-auth justify-center">
    @if (config('app.GOOGLE_ENABLE'))
    <a class="social-link google" app-sandy-prevent="" href="{{ route('user-auth-google', isset($extra) ? $extra : null) }}">
      <svg class="icon">
        <use xlink:href="{{ gs('assets/image/svg','sprite.svg#icon-google-icon') }}"></use>
      </svg>
    </a>
    @endif
    @if (config('app.FACEBOOK_ENABLE'))
    <a class="social-link facebook" app-sandy-prevent="" href="{{ route('user-auth-facebook', isset($extra) ? $extra : null) }}">
      <i class="sni sni-facebook-f"></i>
    </a>
    @endif
  </div>
  @if (config('app.GOOGLE_ENABLE') || config('app.FACEBOOK_ENABLE'))
  <p class="lined-text my-10 font-normal">{{ __('or') }}</p>
  @endif
  <!-- FORM -->
  <form class="form" method="post" action="{{ route('user-login-post', isset($extra) ? $extra : null) }}">
    @csrf
    <!-- FORM ROW -->
    <div class="form-row">
      <!-- FORM ITEM -->
      <div class="form-item">
        <!-- FORM INPUT -->
        <div class="form-input">
          <label for="login-username">{{ __('Username / E-Mail') }}</label>
          <input type="text" class="form-control @error('user') is-invalid @enderror" name="user" value="{{ old('user') }}" required autocomplete="email">
          @error('user')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <!-- /FORM INPUT -->
      </div>
      <!-- /FORM ITEM -->
    </div>
    <!-- /FORM ROW -->
    
    <!-- FORM ROW -->
    <div class="form-row">
      <!-- FORM ITEM -->
      <div class="form-item">
        <!-- FORM INPUT -->
        <div class="form-input is-password show-hide-password">
          <label for="login-password">{{ __('Password') }}</label>
          <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
          <div class="show-password">
            <i class="sni sni-eye"></i>
          </div>
          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <!-- /FORM INPUT -->
      </div>
      <!-- /FORM ITEM -->
    </div>
    <!-- /FORM ROW -->
    
    <!-- FORM ROW -->
    <div class="grid grid-cols-2 gap-4 my-8">
      <!-- FORM ITEM -->
      <div class="form-item">

      </div>
      <!-- /FORM ITEM -->
      
      <!-- FORM ITEM -->
      <div class="form-item text-right">
        <!-- FORM LINK -->
        <a class="auth-link" href="{{ route('user-login-reset-pw-request') }}" app-sandy-prevent="">
          <svg class="icon icon-link">
            <use xlink:href="{{ gs('assets/image/svg','sprite.svg#icon-link') }}"></use>
          </svg>
          {{ __('Forgot Password?') }}
        </a>
        <!-- /FORM LINK -->
      </div>
      <!-- /FORM ITEM -->
    </div>
    <!-- /FORM ROW -->
    
    @if ($captcha = \SandyCaptcha::html())
    <div class="mb-5 flex justify-center">{!! $captcha !!}</div>
    @endif
    <!-- FORM ROW -->
    <div class="form-row">
      <!-- FORM ITEM -->
      <div class="form-item">
        <!-- BUTTON -->
        <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower">{{ __('Login to your Account!') }}</button>
        <!-- /BUTTON -->
      </div>
      <!-- /FORM ITEM -->
    </div>
    <!-- /FORM ROW -->
    <div class="flex justify-center mt-8">
      <div class="auth-text mr-3">{{ __('Not a member?') }}</div>
      <a class="auth-link" href="{{ route('user-register', isset($extra) ? $extra : null) }}">
        <svg class="icon icon-link">
          <use xlink:href="{{ gs('assets/image/svg','sprite.svg#icon-link') }}"></use>
        </svg>
      {{ __('Create an account') }}</a>
    </div>
  </form>
</div>