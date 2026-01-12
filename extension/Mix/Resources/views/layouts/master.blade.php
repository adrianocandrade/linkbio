<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('include.mix-tag.mix-head-tag')

    @livewireStyles
</head>

<body app-sandy="wrapper" {!! barba_prevent() !!} class="@yield('mix-body-class')">
    <div id="app-sandy-mix">


        <div class="dashboard-wrapper">
            <div class="mb-10">
                

            <div class="nav-mobile-header">
                <div class="mobile-top">
                    <div class="mobile-logo-wrapper">
                        <a class="mobile-logo" href="/">
                            <img src="{{ mix_logo() }}" alt="">
                        </a>
                    </div>
                    <div class=" mobile-menu">
                        <div class="sidebar-toggle">
                            {!! svg_i('menu-1') !!}
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="header-side">
                <div class="nav-wrapper">
                    <div class="nav-sidebar">
                        <div class="navbar-content">
                            <div class="logo-wrapper">
                                <a href="/">
                                    <img src="{{ mix_logo() }}" alt="">
                                </a>
                            </div>
                            
                            {{-- Workspace Selector --}}
                            @if(auth()->check())
                            <div class="px-4 mb-6">
                                <label class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-2 block">{{ __('Workspace') }}</label>
                                <form action="" class="relative">
                                    <div class="relative">
                                        <select onchange="if(this.value === 'new') { window.location.href='{{ route('workspace-create') }}' } else if(this.value === 'edit') { window.location.href='{{ route('workspace-edit', session('active_workspace_id', auth()->user()->workspaces->first()->id ?? 0)) }}' } else { window.location.href='/mix/workspace/switch/'+this.value }" 
                                                class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm pl-3 pr-8 py-2 font-bold focus:ring-0 cursor-pointer appearance-none text-gray-700 dark:text-gray-200">
                                            @php
                                                $activeId = session('active_workspace_id');
                                                if(!$activeId && auth()->user()->workspaces->count() > 0) {
                                                     $activeId = auth()->user()->workspaces->first()->id;
                                                }
                                            @endphp
                                            @foreach(auth()->user()->workspaces as $space)
                                                <option value="{{ $space->id }}" {{ $activeId == $space->id ? 'selected' : '' }}>
                                                    {{ $space->name }}
                                                </option>
                                            @endforeach
                                            <option value="new" class="font-bold text-indigo-600 dark:text-indigo-400">+ {{ __('Create Workspace') }}</option>
                                            @if($activeId)
                                                <option value="edit" class="font-bold text-gray-500 dark:text-gray-400">⚙️ {{ __('Edit Workspace') }}</option>
                                            @endif
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-400">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif

                            <div class="navbar-items">
                                <a href="{{ route('user-mix') }}" class="navbar-item">
                                    {!! iconsprite('home-house') !!}

                                    <div class="navbar-name">{{ __('Home') }}</div>
                                </a>
                                <a href="{{ route('user-mix-audience-index') }}" class="navbar-item relative">
                                    {!! iconsprite('users') !!}

                                    <div class="navbar-name">{{ __('Audience') }}</div>
                                    <small class="absolute top-0 right-3 text-yellow-500 font-8 font-bold uppercase nav-tag">{{ __('coming soon') }}</small>
                                </a>
                                @if(Route::has('sandy-blocks-booking-mix-dashboard'))
                                <a href="{{ route('sandy-blocks-booking-mix-dashboard') }}" class="navbar-item relative">
                                    {!! iconsprite('book-open') !!}

                                    <div class="navbar-name">{{ __('Booking') }}</div>
                                    <small class="absolute top-0 right-3 text-green-500 font-8 font-bold uppercase nav-tag">{{ __('NEW BETA') }}</small>
                                </a>
                                @endif
                                @if(Route::has('sandy-blocks-course-mix-dashboard'))
                                    <a href="{{ route('sandy-blocks-course-mix-dashboard') }}"
                                        class="navbar-item">
                                        {!! iconsprite('blackboard') !!}

                                        <div class="navbar-name">{{ __('Courses') }}</div>
                                    </a>
                                @endif
                                @if(Route::has('sandy-blocks-shop-mix-view'))
                                    <a href="{{ route('sandy-blocks-shop-mix-view') }}"
                                        class="navbar-item">
                                            {!! iconsprite('shop') !!}

                                        <div class="navbar-name">{{ __('Store') }}</div>
                                    </a>
                                @endif
                                <a href="{{ route('user-mix-pages') }}" class="navbar-item relative">
                                    {!! iconsprite('fire') !!}

                                    <div class="navbar-name">{{ __('Pages') }}</div>
                                </a>
                                
                                <a href="{{ route('user-mix-membership-index') }}" class="navbar-item relative">
                                    {!! iconsprite('piggybank') !!}

                                    <div class="navbar-name">{{ __('Membership') }}</div>
                                    <small class="absolute top-0 right-3 text-green-500 font-8 font-bold uppercase nav-tag">{{ __('NEW') }}</small>
                                </a>
                                
                                <a href="{{ route('user-mix-analytics') }}" class="navbar-item relative">
                                    {!! iconsprite('bar-chart-up') !!}

                                    <div class="navbar-name">{{ __('Insight') }}</div>

                                    @php
                                        $live = \App\Models\MySession::current_live()
                                    @endphp
                                    
                                    <div class="absolute top-2 right-3 flex items-center {{ $live == 0 ? 'hidden' : '' }}">
                                        
                                        <small class="bg-white rounded-lg h-4 px-2 flex items-center justify-center font-8 font-bold uppercase gap-2">👀 {{ nr($live) }}</small>
                                    </div>
                                </a>

                                <a href="{{ route('user-mix-settings') }}" class="navbar-item">
                                    {!! iconsprite('settings-gear') !!}

                                    <div class="navbar-name">{{ __('Settings') }}</div>
                                </a>
                                
                                <a href="{{ route('user-mix-account') }}" class="navbar-item">
                                    {!! iconsprite('user') !!}

                                    <div class="navbar-name">{{ __('Account') }}</div>
                                </a>
                            </div>


                            @php
                                $activeWorkspaceId = session('active_workspace_id');
                                $activeWorkspace = null;
                                
                                if($activeWorkspaceId) {
                                    $activeWorkspace = \App\Models\Workspace::where('id', $activeWorkspaceId)
                                        ->where('user_id', auth()->id())
                                        ->first();
                                }
                                
                                // If no workspace in session or invalid, use default workspace
                                if(!$activeWorkspace) {
                                    $activeWorkspace = \App\Models\Workspace::where('user_id', auth()->id())
                                        ->where('is_default', 1)
                                        ->first();
                                    
                                    // If still no workspace, get first one
                                    if(!$activeWorkspace) {
                                        $activeWorkspace = auth()->user()->workspaces()->first();
                                    }
                                }
                                
                                $workspaceUrl = $activeWorkspace ? url($activeWorkspace->slug) : bio_url(user('id'));
                                $workspaceSlug = $activeWorkspace ? $activeWorkspace->slug : user('username');
                            @endphp
                            <a class="profile-page-card mt-0 md:mt-20" app-sandy-prevent href="{{ $workspaceUrl }}">
                                <div class="profile-page-card-inner flex items-center gap-4">
                                    
                                    <div class="h-avatar sm is-video remove-before rounded-full bg-transparent">
                                        <img src="{{ avatar() }}" class="h-full w-full" alt="">
                                    </div>
                                    <div class="item-name truncate">
                                        <div class="name">{{ user('username') }}</div>
                                        <div class="info flex items-baseline">
                                            <div class="url">{{ $workspaceSlug }}</div></div>
                                        </div>
                                </div>
                            </a>

                            <div class="flex w-full">
                                <a class="sign-out-btn flex cursor-pointer w-full" href="{{ route('user-logout') }}" app-sandy-prevent>
                                    <svg class="svg-icon icon-sprite-2 w-10 h-7"><use xlink:href="{{ url('assets/image/svg/icon-sprite-2.svg#logout') }}"></use></svg> 
                                    <span>{{ __('Logout') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-main">
                <div class="dashboard-main-content">

                    <div>@yield('content')</div>
                    
                </div>
            </div>
        </div>

        <a class="fixed left-5 bottom-20 text-sticker rounded-full z-50 h-10 w-10 flex items-center justify-center p-0 mix-back-button lg:hidden javascript-history-back cursor-pointer">
            {!! svg_i('angle-left-1', 'w-5 h-5') !!}

            <span class="font-10 font-bold uppercase">{{ __('Back') }}</span>
        </a>
        
        
        <div class="mt-20 lg:hidden block"></div>
        <aside class="floaty-bar flex lg:hidden">
            <div class="bar-actions">
                <div class="action-list dark">
                    <a class="action-list-item" href="{{ route('user-mix') }}">
                        {!! svg_i('media-content-1') !!}
                        <span>{{ __('Mix') }}</span>
                    </a>
                    <a class="action-list-item"
                        href="{{ route('user-mix-pages') }}">
                        {!! svg_i('lightning-bolt-1') !!}
                        <span>{{ __('Pages') }}</span>
                    </a>
                    <a class="action-list-item" app-sandy-prevent href="{{ $workspaceUrl ?? bio_url(user('id')) }}">
                        <div class="h-avatar sm is-video remove-before rounded-full bg-transparent">
                            <img src="{{ avatar() }}" class="h-full w-full" alt="">
                        </div>
                    </a>
                </div>
            </div>
        </aside>
    </div>
    <!-- Tosts -->
    
    @if (is_admin(user('id')))
    <a href="{{ route('admin-dashboard') }}" app-sandy-prevent="" class="text-sticker secondary-box cursor-pointer fixed bottom-10 md:bottom-0 right-0 box border rounded-xl w-26 h-12 flex items-center justify-center z-40 mb-10 mr-10 bg-gray-100">
        <div class="mr-4 text-slate-600 dark:text-slate-200 flex items-center gap-2">
          {!! orion('shield-2', 'w-5 h-5') !!}
          {{ __('Admin') }}
        </div>
      </a>
    @endif

    <div data-iframe-modal="" class="sandy-bio-element-dialog is-mix">
        <div class="iframe-header">
            <div class="icon iframe-trigger-close">
                <i class="flaticon2-cross"></i>
            </div>
                <a class="action-list-item" app-sandy-prevent href="{{ $workspaceUrl ?? bio_url(user('id')) }}">
                    <div class="icon">
                        {!! svg_i('eye-1') !!}
                    </div>
                    <div class="content">
                        <p>{{ __('Preview') }}</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

    <div data-popup=".share-profile-modal" class="small-floating">
        <div class="font-bold text-xl mb-1">{{ __('Share') }}</div>
        <div class="text-gray-400 text-xs mb-5">
            {{ __('Share your page to various platforms.') }}</div>
        <div class="social-links">
            <a href="{{ share_to_media('facebook', user('name'), $workspaceUrl ?? bio_url(user('id'))) }}" class="social-link facebook">
                <i class="o-facebook-1"></i>
            </a>
            <a href="{{ share_to_media('twitter', user('name'), $workspaceUrl ?? bio_url(user('id'))) }}" class="social-link twitter">
                <i class="o-twitter-1"></i>
            </a>
            <a href="{{ share_to_media('whatsapp', user('name'), $workspaceUrl ?? bio_url(user('id'))) }}" class="social-link whatsapp">
                <i class="o-whatsapp-1"></i>
            </a>
            <a href="{{ share_to_media('linkedin', user('name'), $workspaceUrl ?? bio_url(user('id'))) }}" class="social-link linkedin">
                <i class="o-linkedin-1"></i>
            </a>
            <a href="{{ share_to_media('pinterest', user('name'), $workspaceUrl ?? bio_url(user('id'))) }}" class="social-link pinterest">
                <i class="o-pinterest-1"></i>
            </a>
        </div>
        <div class="social-links mt-5">
            <a class="social-link mort-main-bg cursor-pointer share-profile-qr-code-open">
                <i class="la la-qrcode color-black"></i>
            </a>

            <div class="index-header-code">
                <a class="index-header-number text-xs" href="{{ $workspaceUrl ?? bio_url(user('id')) }}"
                    target="_blank">{{ $workspaceSlug ?? bio_url(user('id'), 'short') }}</a>
                <button class="index-header-copy copy-btn ml-3" data-copy="{{ $workspaceUrl ?? bio_url(user('id')) }}"
                    data-after-copy="{{ __('Copied') }}">
                    <i class="flaticon2-copy"></i>
                </button>
            </div>
        </div>

        <div class="flex mt-5 items-center share-profile-learn-open">
            <div class="social-links w-full">
                <a class="social-link instagram rounded-full">
                    <i class="o-instagram-1"></i>
                </a>
                <a class="social-link -ml-5 rounded-full tiktok">
                    <svg class="h-4 w-4 fill-current text-white">
                        <use xlink:href="{{ gs('assets/image/svg/sprite.svg#icon-tiktok') }}">
                        </use>
                    </svg>
                </a>
                <a class="social-link -ml-5 rounded-full youtube">
                    <i class="o-youtube-1"></i>
                </a>
            </div>
            <div class="text-xs text-gray-400">
                {{ __('Learn how to share on other social channels') }} <i
                    class="la la-arrow-right"></i> </div>
        </div>
    </div>
    <div data-popup=".share-profile-qr-code" class="small">

        <div class="qr">
            <img src="{!! get_qrcode($user->id) !!}" class="m-auto md:m-0" alt="">
        </div>
    </div>
    <div data-popup=".share-profile-learn" class="half-short">
        <div>
            <div class="font-bold text-lg">{{ __('How to share your link.') }}</div>
            <p class="text-xs text-gray-400">
                {{ __('Share to anywhere you can share a link.') }}</p>
            <p class="font-bold mt-4 mb-2 text-lg">{{ __('Instagram') }}</p>
            <ul>
                <li class="mb-1 text-gray-600 text-xs">
                    {{ __('Add the :site_name link as the link in your bio.', ['site_name' => config('app.name')]) }}</li>
            </ul>
            <p class="font-bold mt-4 mb-2 text-lg">{{ __('TikTok') }}</p>
            <ul>
                <li class="mb-1 text-gray-600 text-xs">{!! __t('Convert your TikTok account to a <a
                        href="https://www.tiktok.com/business/en-US/apps/business-account">Business Account</a>.') !!}
                </li>
                <li class="mb-1 text-gray-600 text-xs">
                    {{ __('Add the :site_name link as the link in your bio.', ['site_name' => config('app.name')]) }}</li>
            </ul>
            <p class="font-bold mt-4 mb-2 text-lg">{{ __('YouTube') }}</p>
            <ul>
                <li class="mb-1 text-gray-600 text-xs">
                    {{ __('Add the :site_name link as a link in your bio.', ['site_name' => config('app.name')]) }}</li>
                <li class="mb-1 text-gray-600 text-xs">
                    {{ __("Mention your page in your video and share the link in the video's description.") }}
                </li>
                <li class="mb-1 text-gray-600 text-xs">
                    {{ __('Share your :site_name page link in a post to your channel.', ['site_name' => config('app.name')]) }}
                </li>
            </ul>
        </div>
    </div>
    <!-- Input's -->
    <div data-delete-data="" data-title="{{ __('Delete') }}"
        data-cancel="{{ __('Cancel') }}"
        data-confirm-btn="{{ __('Yes, Delete') }}"></div>

        
    @livewireScripts()
    <script src="{{ gs('assets/js/livewire-sortable.js') }}"></script>

    
    @include('include.mix-tag.mix-footer-tag')
</body>

</html>
