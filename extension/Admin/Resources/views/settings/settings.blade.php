@extends('admin::layouts.master')
@section('title', __('Settings'))
@section('namespace', 'admin-settings')
@section('content')
<form method="post" action="{{ route('admin-settings-post') }}" class="md:grid md:grid-cols-3 gap-4 sandy-tabs" enctype="multipart/form-data">
  @csrf
  <div>
    <div class="step-banner nav remove-shadow">
      <nav class="sidebar__nav">
        <a class="sidebar__item sandy-tabs-link active">
          <div class="sidebar__text">{{ __('General') }}</div>
        </a>
        <a class="sidebar__item sandy-tabs-link">
          <div class="sidebar__text">{{ __('Ads') }}</div>
        </a>
        <a class="sidebar__item sandy-tabs-link">
          <div class="sidebar__text">{{ __('Social Login') }}</div>
        </a>
        <a class="sidebar__item sandy-tabs-link">
          <div class="sidebar__text">{{ __('File System') }}</div>
        </a>
        <a class="sidebar__item sandy-tabs-link">
          <div class="sidebar__text">{{ __('Captcha') }}</div>
        </a>
        <a class="sidebar__item sandy-tabs-link">
          <div class="sidebar__text">{{ __('Head JS/CSS') }}</div>
        </a>
        <a class="sidebar__item sandy-tabs-link">
          <div class="sidebar__text">{{ __('Invoice') }}</div>
        </a>
        <a class="sidebar__item sandy-tabs-link">
          <div class="sidebar__text">{{ __('Smtp') }}</div>
        </a>
        <a class="sidebar__item sandy-tabs-link">
          <div class="sidebar__text">{{ __('Pwa') }}</div>
        </a>
      </nav>
    </div>
  </div>
  <div class="col-span-2">
    <div class="border mix-padding-10">
      <!-- General.Tab:START -->
      <div class="sandy-tabs-item" id="general-tab">
        <!-- General.General:START -->
        <div class="popup__label">{{ __('Basic') }}</div>
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input mb-5 is-disabled">
            <label>{{ __('App URL') }}</label>
            <input type="text" name="env[APP_URL]" disabled="" readonly="" value="{{ config('app.url') }}" class="bg-w">
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="form-input">
              <label>{{ __('App Name') }}</label>
              <input type="text" name="env[APP_NAME]" value="{{ config('app.name') }}" class="bg-w">
            </div>
            <div class="form-input">
              <label>{{ __('App Email') }}</label>
              <input type="email" name="env[APP_EMAIL]" value="{{ config('app.APP_EMAIL') }}" class="bg-w">
            </div>
          </div>
        </div>
        <!-- General.General:END -->
        <!-- General.Logo&Favicon:START -->
        <div class="grid grid-cols-2 gap-4 mb-10">
          <div class="form-input mort-main-bg rounded-2xl p-5 flex items-center flex-col">
            <label class="initial">
              {{ __('Logo') }}
            </label>
            <div class="h-avatar is-upload h-48 w-full is-outline-dark" data-generic-preview>
              
              <i class="flaticon-upload-1"></i>
              <img src="{{ logo() }}" class="object-contain" alt="">
              <input type="file" id="logo-thumbnail-input" class="thumbnail-upload-input" name="logo">
            </div>
          </div>
          <div class="form-input mort-main-bg rounded-2xl p-5 flex items-center flex-col">
            <label class="initial">
              {{ __('Favicon') }}
            </label>
            <div class="h-avatar is-upload h-48 w-full is-outline-dark" data-generic-preview>
              <i class="flaticon-upload-1"></i>
              <img src="{{ favicon() }}" class="object-contain" alt="">
              <input type="file" id="favicon-thumbnail-input" class="thumbnail-upload-input" name="favicon">
            </div>
            <label class="button mt-5 initial hidden" for="favicon-thumbnail-input">
              {{ __('Select Favicon') }}
            </label>
          </div>

          
          <div class="form-input mort-main-bg rounded-2xl p-5 flex items-center flex-col col-span-2">
            <label class="initial">
              {{ __('Mix Dashboard Logo') }}
            </label>
            <div class="h-avatar is-upload h-48 w-full is-outline-dark" data-generic-preview>
              
              <i class="flaticon-upload-1"></i>
              <img src="{{ mix_logo() }}" class="object-contain" alt="">
              <input type="file" id="logo-thumbnail-input" class="thumbnail-upload-input" name="mix_logo">
            </div>
          </div>
        </div>
        <!-- General.Logo&Favicon:END -->
        <!-- General.Payment:START -->
        <div class="popup__label">{{ __('Payment') }}</div>
        <div class="mort-main-bg rounded-2xl p-5 grid grid-cols-2 gap-4 mb-10">
          <div class="form-input hidden">
            <label class="initial">{{ __('Enable payment') }}</label>
            <select name="settings[payment][enable]" class="bg-w">
              @foreach (['1' => 'Enable', '0' => 'Disable'] as $key => $value)
              <option value="{{ $key }}" {{ settings('payment.enable') == $key ? 'selected' : '' }}>
                {{ __($value) }}
              </option>
              @endforeach
            </select>
            <p class="text-xs mt-4">{{ __('Enable or disable wide payment support on this site. Users cant purchase plans nor can they use payment method\'s or collect payment') }}</p>
          </div>
          <div class="form-input">
            <label class="initial">{{ __('Currency') }}</label>
            <select name="settings[payment][currency]" class="bg-w">
              @foreach (Currency::all() as $key => $value)
              <option value="{{ $key }}" {{ settings('payment.currency') == $key ? 'selected' : '' }}>
                {!! $key !!}
              </option>
              @endforeach
            </select>
            <p class="text-xs mt-4">{{ __('Please select the currency that works with your current payment method & will be used to purchase plans') }}</p>
          </div>
        </div>
        <!-- General.Payment:END -->
        <!-- General.Notifications:START -->
        <div class="popup__label">{{ __('Notifications') }}</div>
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="grid grid-cols-2 gap-4">
            <div class="form-input">
              <label>{{ __('Email\'s') }}</label>
              <textarea name="settings[notification][emails]" class="bg-w" id="" cols="30" rows="3">{{ settings('notification.emails') }}</textarea>
              <p class="text-xs mt-4">{{ __('Emails that will receive a notification when one of the bottom actions are performed. Add valid email addresses separated by a comma.') }}</p>
            </div>
            <div>
              @foreach (['user' => 'New user', 'plan' => 'New Plan Activation', 'pending_plan' => 'New Manual Plan Request', 'new_support' => 'New Support'] as $key => $value)
              <label class="checkbox block mb-5">
                <input name="settings[notification][{{$key}}]" type="hidden" value="0">
                <input class="checkbox__input" name="settings[notification][{{$key}}]" type="checkbox" value="1" {{ settings("notification.$key") ? 'checked' : '' }}>
                <span class="checkbox__in">
                  <span class="checkbox__tick"></span>
                  <span class="checkbox__text">{{ __($value) }}</span>
                </span>
              </label>
              @endforeach
            </div>
          </div>
          <button class="text-sticker mt-5 is-loader-submit black flex items-center">{{ __('Save') }}</button>
        </div>
        <!-- General.Notifications:END -->
        <!-- General.SEO:START -->
        <div class="popup__label">{{ __('Index Seo') }}</div>
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="card customize mb-5 p-5 bg-white rounded-2xl">
            <div class="card-header flex justify-between">
              <p class="text-base font-bold mb-0">{{ __('Enable custom seo info') }}</p>
              <label class="sandy-switch">
                <input type="hidden" name="settings[seo][enable]" value="0">
                <input class="sandy-switch-input" name="settings[seo][enable]" value="1" type="checkbox" {{ settings('seo.enable') == 1 ? 'checked' : '' }}>
                <span class="sandy-switch-in"><span class="sandy-switch-box"></span></span>
              </label>
            </div>
          </div>
          <p class="text-base font-bold">{{ __('Block Search Engine Indexing') }}</p>
          <p class="subtitle">{{ __('Block your site from being indexed by search engines') }}</p>
          <div class="custom-switch mt-3 mb-10">
            <input type="hidden" name="settings[seo][block_engine]" value="0">
            <input type="checkbox" class="custom-control-input" name="settings[seo][block_engine]" id="block-engine" value="1" {{ settings('seo.block_engine') == 1 ? 'checked' : '' }}>
            <label class="custom-control-label" for="block-engine"></label>
          </div>
          <div class="form-input mb-7 text-count-limit" data-limit="55">
            <label>{{ __('Index Name') }}</label>
            <span class="text-count-field"></span>
            <input type="text" name="settings[seo][page_name]" class="bg-w" value="{{ settings('seo.page_name') }}">
          </div>
          <div class="form-input text-count-limit" data-limit="400">
            <label>{{ __('Index Description') }}</label>
            <span class="text-count-field"></span>
            <textarea rows="4" name="settings[seo][page_description]" class="bg-w">{{ settings('seo.page_description') }}</textarea>
          </div>
          <button class="text-sticker mt-5 is-loader-submit black flex items-center">{{ __('Save') }}</button>
        </div>
        <!-- General.SEO:END -->
        <!-- General.User:START -->
        <div class="popup__label">{{ __('User') }}</div>
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="grid grid-cols-2 gap-4">
            <div class="form-input">
              <label class="initial">{{ __('Enable registration') }}</label>
              <select name="settings[user][enable_registration]" class="bg-w">
                @foreach (['1' => 'Enable', '0' => 'Disable'] as $key => $value)
                <option value="{{ $key }}" {{ settings('user.enable_registration') == $key ? 'selected' : '' }}>
                  {{ __($value) }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-input">
              <label class="initial">{{ __('Enable email verification') }}</label>
              <select name="settings[user][email_verification]" class="bg-w">
                @foreach (['1' => 'Enable', '0' => 'Disable'] as $key => $value)
                <option value="{{ $key }}" {{ settings('user.email_verification') == $key ? 'selected' : '' }}>
                  {{ __($value) }}
                </option>
                @endforeach
              </select>
            </div>
          </div>
          
          <div class="form-input mt-5">
            <label>{{ __('Bio Prefix') }}</label>
            <input type="text" name="env[BIO_PREFIX]" class="bg-w" value="{{ config('app.bio_prefix') }}">
          </div>
        </div>
        <!-- General.User:END -->
        <!-- General.Social:START -->
        <div class="popup__label">{{ __('Index Social') }}</div>
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="grid grid-cols-2 gap-4">
            @foreach (socials() as $key => $items)
            <div class="form-input mb-6">
              <label><em class="la la-{{$items['icon']}}"></em> <span>{{ ucfirst($key) }}</span></label>
              
              <input type="text" class="bg-w" value="{{ settings('social.' . $key) }}" name="settings[social][{{$key}}]">
            </div>
            @endforeach
          </div>
        </div>
        <!-- General.Social:END -->
        <!-- General.Others:START -->
        <div class="popup__label">{{ __('Others') }}</div>
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input mb-5">
            <label class="initial">{{ __('No reload page links like a SPA.') }}</label>
            <select name="settings[others][spa_prevent]" class="bg-w">
              @foreach (['enable' => 'Enable', 'disable' => 'Prevent / Disable'] as $key => $value)
              <option value="{{ $key }}" {{ settings('others.spa_prevent') == $key ? 'selected' : '' }}>
                {{ __($value) }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="form-input mb-5">
            <label class="initial">{{ __('Timezone') }}</label>
            {!! $timezone !!}
          </div>
          <div class="gap-4 mb-5">
            <div class="form-input mb-5">
              <label>{{ __('Redirect index') }}</label>
              <input type="text" name="settings[others][redirect_url]" value="{{ settings('others.redirect_url') }}" class="bg-w">
              <p class="text-xs mt-5">
                {{ __('Set the full custom index url ( ex: https://google.com/ ) if you want to completely disable the default landing page of the script. Helpful when you want to have your own landing page. Leave empty to disable.') }}
              </p>
            </div>
            <div class="form-input mb-5">
              <label>{{ __('Privacy policy url') }}</label>
              <input type="text" name="settings[others][privacy]" value="{{ settings('others.privacy') }}" class="bg-w">
            </div>
            <div class="form-input">
              <label>{{ __('Terms&condition url') }}</label>
              <input type="text" name="settings[others][terms]" value="{{ settings('others.terms') }}" class="bg-w">
            </div>
          </div>
          <div class="form-input">
            <label class="initial">{{ __('Copy page translations') }}</label>
            <select name="settings[others][copy_trans]" class="bg-w">
              @foreach (['0' => 'Dont copy', '1' => 'Copy'] as $key => $value)
              <option value="{{ $key }}" {{ settings('others.copy_trans') == $key ? 'selected' : '' }}>
                {{ __($value) }}
              </option>
              @endforeach
            </select>
              <p class="text-xs mt-5">
                {!! __t('99% of Texts on this script can be translated by coping the key and pasting the new values but with this option, this script will auto copy translation texts on each page view & add them to the default translation file. Once the option is enabled, you will need to visit the pages you want to copy the translation texts & it will copy all translation texts on that current page to the default translation file. <br> Please turn this off when done as it might affect page speed if left on.') !!}
              </p>
          </div>
          <!-- General.Others:END -->
          <button class="text-sticker mt-5 is-loader-submit black flex items-center">{{ __('Save') }}</button>
        </div>
        <!-- General.Htaccess:START -->
        <div class="popup__label">{{ __('.htaccess') }}</div>
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('admin-settings-htaccess', ['type' => 'https']) }}" app-sandy-prevent="" class="auth-link text-sticker items-center h-full">{{ __('Force https on htaccess.') }}</a>
            <a href="{{ route('admin-settings-htaccess', ['type' => 'revert']) }}" app-sandy-prevent="" class="auth-link text-sticker items-center h-full">{{ __('Use http on htaccess.') }}</a>
          </div>
        </div>
        <!-- General.Htaccess:END -->
        <!-- General.PageSpeed:START -->
        <div class="popup__label">{{ __('Page speed compression v1') }}</div>
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input mb-5">
            <label class="initial">{{ __('Enable compression') }}</label>
            <select name="env[LARAVEL_PAGE_SPEED_ENABLE]" class="bg-w">
              @foreach (['1' => 'Enable', '0' => 'Disable'] as $key => $value)
              <option value="{{ $key }}" {{ config('app.LARAVEL_PAGE_SPEED_ENABLE') == $key ? 'selected' : '' }}>
                {{ __($value) }}
              </option>
              @endforeach
            </select>
          </div>
          <p class="italic text-xs mt-5">{{ __('(Note: enabling this will make the script compress all pages. Check the images below.)') }}</p>
          <div class="grid grid-cols-2 mt-5 gap-4">
            <a href="{{ gs('assets/image/others/compress-page-speed-1.png') }}" target="_blank">
              <p class="italic text-sm font-bold mb-2">{{ __('From this') }}</p>
              <img src="{{ gs('assets/image/others/compress-page-speed-1.png') }}" alt="">
            </a>
            <a href="{{ gs('assets/image/others/compress-page-speed-2.png') }}" target="_blank">
              <p class="italic text-sm font-bold mb-2">{{ __('To this') }}</p>
              <img src="{{ gs('assets/image/others/compress-page-speed-2.png') }}" alt="">
            </a>
          </div>
        </div>
        <!-- General.PageSpeed:END -->
        <div class="popup__label">{{ __('Cron Type') }}</div>
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="card customize mb-5 p-5 bg-white rounded-2xl">
            <div class="card-header flex justify-between">
              <p class="text-base font-bold mb-0">{{ __('Disable silent cron') }}</p>
              <label class="sandy-switch">
                <input type="hidden" name="settings[cron][type]" value="0">
                <input class="sandy-switch-input" name="settings[cron][type]" value="1" type="checkbox" {{ settings('cron.type') == 1 ? 'checked' : '' }}>
                <span class="sandy-switch-in"><span class="sandy-switch-box"></span></span>
              </label>
            </div>
          </div>
          <p class="text-xs mt-5">{{ __('PS: Normally cron jobs on this script are silent, meaning they run as each page loads & they do things like check expired user plan & send them expiry mails. If you turn this feature it will disable silent cron & you would have to setup a cron to hit the cron page. Cron url below.') }}</p>
          
          <div class="step-banner bg-gray-400 rounded-2xl mt-5 mb-0">
            <p class="p-3 text-base bg-white rounded-xl text-center mb-4">
              <span class="font-bold text-red-500">* * * * *</span>
              <span class="font-bold ml-2 text-black">wget -q -O - {{ route('sandy-cron') }} >/dev/null 2>&1</span>
            </p>
            <div class="is-label text-white">{{ __('Cron Url') }}</div>
            <div class="form-input copy active">
              <input type="text" value="{{ route('sandy-cron') }}" readonly="">
              <div class="copy-btn" data-copy="{{ route('sandy-cron') }}" data-after-copy="{{ __('Copied') }}">
                <i class="la la-copy"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- General.Tab:END -->
      <!-- Ads.Tab:START -->
      <div class="sandy-tabs-item" id="ads-tab">
        <!-- Ads.Title:START -->
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <p class="text-base font-bold">{{ __('Accepts text & html') }}</p>
          <p class="subtitle">{{ __('Can be removed depending on plan') }}</p>
        </div>
        <!-- Ads.Title:END -->
        <!-- Ads.Textarea:START -->
        <div class="popup__label">{{ __('User Ads') }}</div>
        <div class="grid grid-cols-2 gap-4 mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input">
            <label>{{ __('Header') }}</label>
            <textarea rows="5" name="settings[ads][header]" class="bg-w">{{ settings('ads.header') }}</textarea>
          </div>
          <div class="form-input">
            <label>{{ __('Footer') }}</label>
            <textarea rows="5" name="settings[ads][footer]" class="bg-w">{{ settings('ads.footer') }}</textarea>
          </div>
        </div>
        <!-- Ads.Textarea:END -->
        
      </div>
      <!-- Ads.Tab:END -->
      <!-- Social-Login.Tab:START -->
      <div class="sandy-tabs-item" id="social-login-tab">
        <!-- Social-Login.Facebook:START -->
        <div class="popup__label">{{ __('Facebook') }}</div>
        <div class="grid grid-cols-2 gap-4 mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input col-span-2 mb-5">
            <label class="initial">{{ __('Enable') }}</label>
            <select name="env[FACEBOOK_ENABLE]" class="bg-w">
              @foreach (['0' => 'Disable', '1' => 'Enable'] as $key => $value)
              <option value="{{ $key }}" {{ config('app.FACEBOOK_ENABLE') == $key ? 'selected' : '' }}>
                {{ __($value) }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="form-input mb-5">
            <label>{{ __('Client Id') }}</label>
            <input type="text" name="env[FACEBOOK_CLIENT_ID]" value="{{ config('app.FACEBOOK_CLIENT_ID') }}" class="bg-w">
          </div>
          <div class="form-input mb-5">
            <label>{{ __('Secret Id') }}</label>
            <input type="text" name="env[FACEBOOK_SECRET]" value="{{ config('app.FACEBOOK_SECRET') }}" class="bg-w">
          </div>
          <div class="form-input mb-5 col-span-2">
            <label class="initial block mb-0">{{ __('Callback') }}</label>
            <input type="text" disabled="" value="{{ config('app.FACEBOOK_CALLBACK') }}" class="bg-w">
          </div>
        </div>
        <!-- Social-Login.Facebook:END -->
        <!-- Social-Login.Google:START -->
        <div class="popup__label">{{ __('Google') }}</div>
        <div class="grid grid-cols-2 gap-4 mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input col-span-2 mb-5">
            <label class="initial">{{ __('Enable') }}</label>
            <select name="env[GOOGLE_ENABLE]" class="bg-w">
              @foreach (['0' => 'Disable', '1' => 'Enable'] as $key => $value)
              <option value="{{ $key }}" {{ config('app.GOOGLE_ENABLE') == $key ? 'selected' : '' }}>
                {{ __($value) }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="form-input mb-5">
            <label>{{ __('Client Id') }}</label>
            <input type="text" name="env[GOOGLE_CLIENT_ID]" value="{{ config('app.GOOGLE_CLIENT_ID') }}" class="bg-w">
          </div>
          <div class="form-input mb-5">
            <label>{{ __('Secret Id') }}</label>
            <input type="text" name="env[GOOGLE_SECRET]" value="{{ config('app.GOOGLE_SECRET') }}" class="bg-w">
          </div>
          <div class="form-input mb-5 col-span-2">
            <label class="initial block mb-0">{{ __('Callback') }}</label>
            <input type="text" disabled="" value="{{ config('app.GOOGLE_CALLBACK') }}" class="bg-w">
          </div>
        </div>
        <!-- Social-Login.Google:END -->
      </div>
      <!-- Social-Login.Tab:END -->
      <!-- FileSystem.Tab:START -->
      <div class="sandy-tabs-item" id="filesystem-tab">
        <!-- FileSystem.Type:START -->
        <div class="popup__label">{{ __('Type') }}</div>
        <div class="grid grid-cols-2 gap-4 mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input">
            <label class="initial">{{ __('File system') }}</label>
            <select name="env[FILESYSTEM]" class="bg-w">
              @php
              $filesystem = ['local' => 'Local Server'];
              if(Plugins::has('awsconnect')):
                $filesystem['s3'] = 'Amazon S3';
              endif;

              $filesystem[''] = 'Ftp (coming soon)';
              @endphp
              @foreach ($filesystem as $key => $value)
              <option value="{{ $key }}" {{ config('app.FILESYSTEM') == $key ? 'selected' : '' }}>
                {{ __($value) }}
              </option>
              @endforeach
            </select>
          </div>
        </div>
        <!-- FileSystem.Type:END -->
      </div>
      <!-- FileSystem.Tab:END -->
      <!-- Captcha.Tab:START -->
      <div class="sandy-tabs-item" id="captcha-tab">
        <div class="grid grid-cols-2 gap-4 mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input">
            <label class="initial">{{ __('Enable captcha') }}</label>
            <select name="settings[captcha][enable]" class="bg-w">
              @foreach (['0' => 'Disable', '1' => 'Enable'] as $key => $value)
              <option value="{{ $key }}" {{ settings('captcha.enable') == $key ? 'selected' : '' }}>
                {{ __($value) }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="form-input">
            <label class="initial">{{ __('Captcha type') }}</label>
            <select name="settings[captcha][type]" class="bg-w">
              @foreach (['default' => 'Default', 'google_recaptcha' => 'Google Recaptcha'] as $key => $value)
              <option value="{{ $key }}" {{ settings('captcha.type') == $key ? 'selected' : '' }}>
                {{ __($value) }}
              </option>
              @endforeach
            </select>
          </div>
        </div>
        <!-- Captcha.Recaptcha:START -->
        <div class="popup__label">{{ __('Recaptcha') }}</div>
        <div class="grid grid-cols-2 gap-4 mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input">
            <label>{{ __('Recaptcha site key') }}</label>
            <input type="text" name="env[RECAPTCHA_SITE_KEY]" value="{{ config('app.RECAPTCHA_SITE_KEY') }}" class="bg-w">
          </div>
          <div class="form-input">
            <label>{{ __('Recaptcha secret key') }}</label>
            <input type="text" name="env[RECAPTCHA_SECRET_KEY]" value="{{ config('app.RECAPTCHA_SECRET_KEY') }}" class="bg-w">
          </div>
        </div>
        <!-- Captcha.Recaptcha:END -->
      </div>
      <!-- Captcha.Tab:END -->
      <!-- HeadJSCSS.Tab:START -->
      <div class="sandy-tabs-item" id="headjscss-tab">
        <div class="grid grid-cols-2 gap-4 mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input">
            <label class="initial">{{ __('Enable head js/css') }}</label>
            <select name="settings[headjscss][enable]" class="bg-w">
              @foreach (['0' => 'Disable', '1' => 'Enable'] as $key => $value)
              <option value="{{ $key }}" {{ settings('headjscss.enable') == $key ? 'selected' : '' }}>
                {{ __($value) }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="form-input col-span-2">
            <label>{{ __('Head code') }}</label>
            <div class="prism-wrap h-screen rounded-2xl">
              <textarea spellcheck="false" name="settings[headjscss][code]" oninput="app.sandyPrism.update(this.value); app.sandyPrism.sync_scroll(this);" onscroll="app.sandyPrism.sync_scroll(this);" onkeydown="app.sandyPrism.check_tab(this, event);">{!! settings('headjscss.code') !!}</textarea>
                                                                            <pre id="highlighting">
                                                                                        <code class="language-html" id="highlighting-content"></code>
              </pre>
            </div>
            <p class="mt-5 text-xs">
              {{ __('Please include the html tags in the textarea ex: <style> ---- </style>') }}
            </p>
            <p class="mt-5 text-xs italic">
              {{ __('(Note: this only works on all pages except user bio. For example we would not want our livechat to disturb our user bio pages.)') }}
            </p>
          </div>
        </div>
        
      </div>
      <!-- HeadJSCSS.Tab:END -->
      <!-- Invoice.Tab:START -->
      <div class="sandy-tabs-item" id="invoice-tab">
        <!-- Invoice.Invoice:START -->
        <div class="popup__label">{{ __('Invoice') }}</div>
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input col-span-2 mb-5">
            <label class="initial">{{ __('Enable') }}</label>
            <select name="settings[invoice][enable]" class="bg-w">
              @foreach (['0' => 'Disable', '1' => 'Enable'] as $key => $value)
              <option value="{{ $key }}" {{ settings('invoice.enable') == $key ? 'selected' : '' }}>
                {{ __($value) }}
              </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="grid grid-cols-2 gap-4">
            @foreach ($invoiceField as $key => $value)
            <div class="form-input mb-3">
              <label>{{ ao($value, 'name') }}</label>
              <input type="text" name="settings[invoice][{{$key}}]" value="{{ settings("invoice.$key") }}" class="bg-w">
            </div>
            @endforeach
          </div>
        </div>
        <!-- Invoice.Invoice:END -->
      </div>
      <!-- Invoice.Tab:END -->
      <!-- SMTP.Tab:START -->
      <div class="sandy-tabs-item" id="smtp-tab">
        
        <!-- SMTP.mailer:START -->
        <div class="mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input">
            <label>{{ __('Mailer') }}</label>
            <input type="text" name="env[MAIL_MAILER]" value="{{ config('app.MAIL_MAILER') }}" class="bg-w">
          </div>
        </div>
        <!-- SMTP.mailer:END -->
        <!-- SMTP.smtp:START -->
        <div class="popup__label">{{ __('Smtp') }}</div>
        <div class="grid grid-cols-2 gap-4 mort-main-bg rounded-2xl p-5 mb-10">
          <div class="form-input">
            <label>{{ __('Host') }}</label>
            <input type="text" name="env[MAIL_HOST]" value="{{ config('app.MAIL_HOST') }}" class="bg-w">
          </div>
          <div class="form-input">
            <label>{{ __('From email') }}</label>
            <input type="text" name="env[MAIL_FROM_ADDRESS]" value="{{ config('app.MAIL_FROM_ADDRESS') }}" class="bg-w">
          </div>
          <div class="form-input">
            <label>{{ __('From name') }}</label>
            <input type="text" name="env[MAIL_FROM_NAME]" value="{{ config('app.MAIL_FROM_NAME') ?? '${APP_NAME}' }}" class="bg-w">
          </div>
          <div class="form-input">
            <label>{{ __('Port') }}</label>
            <input type="text" name="env[MAIL_PORT]" value="{{ config('app.MAIL_PORT') }}" class="bg-w">
          </div>
          <div class="form-input">
            <label>{{ __('Username') }}</label>
            <input type="text" name="env[MAIL_USERNAME]" value="{{ config('app.MAIL_USERNAME') }}" class="bg-w">
          </div>
          <div class="form-input">
            <label>{{ __('Password') }}</label>
            <input type="text" name="env[MAIL_PASSWORD]" value="{{ config('app.MAIL_PASSWORD') }}" class="bg-w">
          </div>
          
        </div>
        <!-- SMTP.smtp:END -->
      </div>
      <!-- SMTP.Tab:END -->

      
      <div class="sandy-tabs-item" id="pwa-tab">
        <div class="p-5 mb-5 rounded-2xl mort-main-bg">
          <div class="page__title h4 m-0 font-bold text-lg">{{ __('Pwa IOS Splash') }}</div>
          <p class="mt-1 mb-1 text-xs text-gray-400">{{ __('Pwa allows your user visitor install thier bio as an app on their devices and you would need to complete this for the process to work. Note, if you dont want pwa for users, you can always disable the plan option. Please test the whole process before going into live / production mode.') }}</p>
        </div>
        <p class="text-xs font-bold">{{ __('Admin requirements') }}</p>
        <ul class="pricing-lists mb-7 mt-3">
          <li class="mt-3">
            <p class="text-xs flex items-center">
              •
              <span class="underline">{{ __('HTTPS') }}</span>
            </p>
          </li>
          <li class="mt-3">
            <p class="text-xs flex items-center">
              •
              <span class="underline">{{ __('Splash Screen images') }}</span>
            </p>
          </li>
          <li class="mt-3">
            <p class="text-xs flex items-center">
              •
              <span class="underline">{{ __('Enable in Plans') }}</span>
            </p>
          </li>
        </ul>
        <p class="mt-1 mb-1 text-xs text-gray-400 mb-5">{{ __('Add your splash screen image in all these resolution in order for IOS Splash to work properly.') }}</p>
        @foreach (['640x1136', '750x1334', '1242x2208', '1125x2436', '828x1792', '1242x2688', '1536x2048', '1668x2224', '1668x2388', '2048x2732'] as $key => $value)
        
        <div class="sandy-upload-v2 mb-5 border-white sandy-upload-modal-open card-shadow cursor-pointer {{!empty(settings("pwa_splash.$value")) && file_exists(public_path('media/bio/pwa-splash/'. settings("pwa_splash.$value"))) ? 'active' : '' }}" data-generic-preview="">
          <input type="file" name="ios_pwa_splash[{{ $value }}]">
          <div class="image-con">
            @if (!empty(settings("pwa_splash.$value")) && file_exists(public_path('media/bio/pwa-splash/'. settings("pwa_splash.$value"))))
            <div class="image lozad" data-background-image="{{ url('media/bio/pwa-splash', settings("pwa_splash.$value")) }}"></div>
            @endif
            <div class="file-name">
              <span class="font-bold">{{ settings("pwa_splash.$value") }}</span>
              <p class="text-xs">{{ __('App icon for your pwa. This is required.') }}</p>
            </div>
          </div>
          <div class="info flex-col items-start">
            <span class="font-bold">{{ __(':size - 2mb', ['size' => $value]) }}</span>
            <p class="text-xs">{{ __('The spash size is :size and it is required.', ['size' => $value]) }}</p>
          </div>
          <div class="add-button text-sm">
            {{ __('Add') }}
          </div>
        </div>
        @endforeach
        <div class="text-xs font-bold my-7">{{ __('Firebase') }}</div>
        <div class="mort-main-bg p-5 rounded-xl mb-5">
          
          <div class="form-input">
            <label>{{ __('Api Key') }}</label>
            <input type="text" name="settings[firebase][apiKey]" value="{{ settings('firebase.apiKey') }}" class="bg-w">
          </div>
          <div class="form-input mt-5">
            <label>{{ __('Auth Domain') }}</label>
            <input type="text" name="settings[firebase][authDomain]" value="{{ settings('firebase.authDomain') }}" class="bg-w">
          </div>
          <div class="form-input mt-5">
            <label>{{ __('Project ID') }}</label>
            <input type="text" name="settings[firebase][projectId]" value="{{ settings('firebase.projectId') }}" class="bg-w">
          </div>
          <div class="form-input mt-5">
            <label>{{ __('Storage Bucket') }}</label>
            <input type="text" name="settings[firebase][storageBucket]" value="{{ settings('firebase.storageBucket') }}" class="bg-w">
          </div>
          <div class="form-input mt-5">
            <label>{{ __('Messaging sender ID') }}</label>
            <input type="text" name="settings[firebase][messagingSenderId]" value="{{ settings('firebase.messagingSenderId') }}" class="bg-w">
          </div>
          <div class="form-input mt-5">
            <label>{{ __('App ID') }}</label>
            <input type="text" name="settings[firebase][appId]" value="{{ settings('firebase.appId') }}" class="bg-w">
          </div>
          <div class="form-input mt-5">
            <label>{{ __('Server Key') }}</label>
            <input type="text" name="settings[firebase][server_key]" value="{{ settings('firebase.server_key') }}" class="bg-w">
          </div>
        </div>
      </div>
      <div class="mort-main-bg rounded-2xl p-5 mb-10">
        <button class="button">{{ __('Save') }}</button>
      </div>
    </div>
  </form>
  @endsection