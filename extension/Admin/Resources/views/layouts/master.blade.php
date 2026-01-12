<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      @include('include.mix-tag.mix-head-tag')
      <link href="{{ gs('assets/css/sandy.admin.css') }}" rel="stylesheet">
      @yield('headJS')
   </head>
   <body id="app-sandy-admin" app-sandy="wrapper" {!! barba_prevent() !!}>
   <div class="page">
      <div class="sidebar">
         <div class="sidebar__head">
            <a class="sidebar__logo" href="{{ url('/') }}">
            <img class="sidebar__pic sidebar__pic_light" src="{{ logo() }}" alt=" " />
            </a>
            <button class="sidebar__toggle">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                  <path d="M22 12H3" stroke="#11142d"></path>
                  <g stroke="#808191">
                     <path d="M22 4H13"></path>
                     <path opacity=".301" d="M22 20H13"></path>
                  </g>
                  <path d="M7 7l-5 5 5 5" stroke="#11142d"></path>
               </svg>
            </button>
            <button class="sidebar__close">
               <svg class="icon icon-close">
                  <use xlink:href="{{ gs('assets/image/svg/sprite.svg#icon-close') }}"></use>
               </svg>
            </button>
         </div>
         <div class="sidebar__body">
            <nav class="sidebar__nav">
               <div class="sidebar__caption">{{ __('Admin tools') }}</div>
               <a class="sidebar__item active" href="{{ route('admin-dashboard') }}">
                  <div class="sidebar__icon">
                     <i class="icon sio real-estate-048-house-value"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Overview') }}</div>
               </a>
               <a class="sidebar__item" href="{{ route('admin-users') }}">
                  <div class="sidebar__icon">
                     <i class="icon sio network-icon-069-users"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Users') }}</div>
               </a>
               <a class="sidebar__item" href="{{ route('admin-plans') }}">
                  <div class="sidebar__icon">
                     <i class="sio design-and-development-086-shop icon"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Plans') }}</div>
               </a>
               <a class="sidebar__item" href="{{ route('admin-domain-all') }}">
                  <div class="sidebar__icon">
                     <i class="sio internet-043-internet-connection icon"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Domain') }}</div>
               </a>
               <a class="sidebar__item" href="{{ route('admin-payments') }}">
                  <div class="sidebar__icon">
                     <i class="sio project-management-083-payment icon"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Payments') }}</div>
               </a>
               <a class="sidebar__item" href="{{ route('admin-languages') }}">
                  <div class="sidebar__icon">
                     <i class="icon sio design-and-development-048-text-tool"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Translation') }}</div>
               </a>
               <a class="sidebar__item" href="{{ route('admin-analytics') }}">
                  <div class="sidebar__icon">
                     <i class="icon sio network-icon-019-web-analytics"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Analytics') }}</div>
               </a>
               <a class="sidebar__item" href="{{ route('admin-plugins-types') }}">
                  <div class="sidebar__icon">
                     <i class="icon sio office-029-power-plug"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Plugins') }}</div>
               </a>
              <a class="sidebar__item" href="{{ route('admin-pages') }}">
                  <div class="sidebar__icon">
                     <i class="icon sio web-hosting-001-error-page"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Pages') }}</div>
               </a>
               <a class="sidebar__item" href="{{ route('admin-blogs') }}">
                  <div class="sidebar__icon">
                     <i class="icon sio office-082-text-document"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Blog') }}</div>
               </a>
               @if (Plugins::has('user_util') && Route::has('sandy-plugins-user_util-tree'))
               <a class="sidebar__item" href="{{ Route::has('sandy-plugins-user_util-tree') ? route('sandy-plugins-user_util-tree') : '#' }}">
                  <div class="sidebar__icon">
                     <i class="icon sio design-and-development-017-blog-template"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Customize') }}</div>
               </a>
               @endif
               <a class="sidebar__item" href="{{ route('admin-settings') }}">
                  <div class="sidebar__icon">
                     <i class="icon sio design-and-development-025-settings"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Settings') }}</div>
               </a>

               <a class="sidebar__item" href="{{ route('admin-error-logs') }}">
                  <div class="sidebar__icon">
                     <i class="icon sio web-hosting-001-error-page"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Error Log') }}</div>
               </a>
               @if (Route::has('docs-index'))
               <div class="sidebar__caption">{{ __('Documentation') }}</div>
               <a class="sidebar__item" href="{{ route('admin-docs-index') }}">
                  <div class="sidebar__icon">
                     <i class="icon flaticon-list"></i>
                  </div>
                  <div class="sidebar__text">{{ __('Documentation') }}</div>
               </a>
               <a class="sidebar__item" href="{{ route('admin-support-requests') }}">
                  <div class="sidebar__icon">
                     <i class="icon sio web-hosting-032-customer-support"></i>
                  </div>
                  <div class="sidebar__text">{!! __t('Inbox <small class="text-xs italic">(v1)</small>') !!}</div>
               </a>
               @endif
               {!! getPluginAdminMenus() !!}
            </nav>
            <div class="step-banner sidebar-footer has-cta-bg-shade mb-5">
               <div class="cta-background-shade">
                  <img src="{{ gs('assets/image/others/index-cta-bg.png') }}" alt="">
               </div>
               <div class="flex justify-center z-10 relative">
                  <i class="sio security-icon-039-danger-sign text-5xl text-white pt-5"></i>
               </div>
               <p class="text-center text-white text-sm mt-5 font-bold block z-10 relative">{{ __('Wanna log an error? Do it here!') }}</p>
               <a class="button white w-full mt-5 z-10 relative" href="{{ sandy_dev_links('support') }}" target="_blank">{{ __('Send error') }}</a>
            </div>
         </div>
      </div>
      <div class="page__content">
         <div class="header">
            <a class="header__logo" href="{{ route('index-home') }}" target="_blank">
            <img src="{{ logo() }}" alt="" />
            </a>
            <div class="header__group">
               <div class="header__item">
                  <a href="{{ route('user-mix') }}" app-sandy-prevent="" class="header__head">
                  <i class="sio design-and-development-036-homepage text-lg"></i>
                  </a>
               </div>
            </div>
            <button class="header__toggle ml-5">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                  <path d="M22 12H3" stroke="#11142d"></path>
                  <g stroke="#808191">
                     <path d="M22 4H13"></path>
                     <path opacity=".301" d="M22 20H13"></path>
                  </g>
                  <path d="M7 7l-5 5 5 5" stroke="#11142d"></path>
               </svg>
            </button>
            <div class="index-header-item index-header-item_user">
               <button class="index-header-head js-header-head">
                  <div class="header__user ml-0 md:ml-7 block h-avatar md rounded-full">
                     <img src="{{ avatar() }}" class="h-full w-full" alt="">
                  </div>
               </button>
               <div class="index-header-body js-header-body">
                  <div class="index-header-name">{{ __('Hi, :name', ['name' => user('name')]) }}</div>
                  <div class="index-header-code">
                     <p class="index-header-number text-xs">{{ __('Last Activity :date', ['date' => \Carbon\Carbon::parse(user('lastActivity'))->toDayDateTimeString()]) }}</p>
                  </div>
                  <div class="index-header-menu">
                     <a class="index-header-link" app-sandy-prevent="" href="{{ route('user-mix') }}">
                        <div class="index-header-icon">
                           <i class="icon flaticon2-browser-1"></i>
                        </div>
                        <div class="index-header-text">{{ __('User Mix') }}</div>
                     </a>
                     <a class="index-header-link" href="{{ route('admin-dashboard') }}">
                        <div class="index-header-icon text-base">
                           <i class="icon sio web-hosting-017-web-analysis"></i>
                        </div>
                        <div class="index-header-text">{{ __('Overview') }}</div>
                     </a>
                     <a class="index-header-link" href="{{ route('admin-payments') }}">
                        <div class="index-header-icon text-base">
                           <i class="icon sio shopping-icon-034-payment-gateway"></i>
                        </div>
                        <div class="index-header-text">{{ __('Payments') }}</div>
                     </a>
                     <a class="index-header-link" href="{{ route('admin-settings') }}">
                        <div class="index-header-icon text-base">
                           <i class="icon sio design-and-development-025-settings"></i>
                        </div>
                        <div class="index-header-text">{{ __('Settings') }}</div>
                     </a>
                     <a class="index-header-link" href="{{ route('user-logout') }}" app-sandy-prevent>
                        <div class="index-header-icon text-base">
                           <i class="icon sio industrial-icon-016-electric-outlet"></i>
                        </div>
                        <div class="index-header-text">{{ __('Logout') }}</div>
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <div app-sandy="container" class="mt-0" app-sandy-namespace="@yield('namespace')">


            <div id="content">
               @yield('content')
               <footer class="footer mt-16">
                  <div class="footer-center">
                     <div class="footer-foot">
                        <div class="footer-copyright">{{ __('Copyright © :date :website. v :version', ['date' => date('Y'), 'website' => config('app.name'), 'version' => app_version()]) }}</div>
                        <div class="footer-note block text-center mt-2 md:mt-0 ">Built with 💖 by <a class="ml-1" href="https://jeffreyjola.com" target="_blank">Me</a></div>
                     </div>
                  </div>
               </footer>
            </div>
         </div>
      </div>
   </div>
   <!-- Input's -->
   <div data-delete-data="" data-title="{{ __('Delete') }}" data-cancel="{{ __('Cancel') }}" data-confirm-btn="{{ __('Yes, Delete') }}"></div>
   @include('include.mix-tag.mix-footer-tag')
   <!-- Custom page scripts -->
   </body>
</html>