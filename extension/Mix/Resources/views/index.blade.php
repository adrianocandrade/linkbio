@extends('mix::layouts.master')
@section('title', __('Mix'))
@section('content')
<style>
    #content {
        padding-bottom: 0 !important;
    }
    
    /* Social Links Card Styles */
    .social-link-card {
        background: rgba(255, 255, 255, 0.5);
        border: 2px solid #e5e7eb;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        min-height: 100px;
    }

    .social-link-card.configured {
        background: rgba(255, 255, 255, 0.9);
        border-color: #10b981;
    }

    .social-link-card.not-configured {
        opacity: 0.6;
    }

    .social-link-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }
    
    .social-links-grid {
        margin-bottom: 1rem;
    }
</style>

<div class="main-content">

    <div class="dashboard-header-banner relative mt-5 mb-5">
		<div class="card-container">
            
            <div class="dashboard-header-banner relative mt-0 mb-5">
                <div class="card-container">
                    
                    <div class="text-lg font-bold">{{ __('My Page Builder') }}</div>
                    <p>{!! __t('Make your <br> page awesome!') !!}</p>
                    <div class="side-cta">
                        <img src="{{ gs('assets/image/emoji/Yellow-1/Nerdy.png') }}" alt="">
                    </div>
                </div>
            </div>
            
            
		<div class="opener-box rounded-2xl p-0 bg-transparent border-0">
                <div class="w-full">
                    <div class="index-header-code grid grid-cols-12 gap-1">
                        @php
                            $workspaceSlug = $active_workspace->slug ?? user('username');
                            $workspaceUrl = bio_url($workspaceSlug);
                        @endphp
                        <a class="index-header-number text-xs m-0 col-span-8" app-sandy-prevent="" href="{{ $workspaceUrl }}" target="_blank">{{ bio_url($workspaceSlug, 'short') }}</a>
                        <button class="index-header-copy copy-btn col-span-4" data-copy="{{ $workspaceUrl }}" data-after-copy="{{ __('Copied') }}">
                        <i class="icon flaticon2-copy text-sm"></i>
                        </button>
                    </div>
                    <a class="w-full flex justify-center gap-2" app-sandy-prevent="" href="{{ $workspaceUrl }}" >
                        {!! orion('edit-1', 'w-5 h-5') !!} {{ __('Start Mixing! 🤩') }}
                    </a>
                </div>
            </div>
        </div>
	</div>

    <div class="can-divide with-divider hidden">
        <div class="grid grid-cols-2 gap-4">
            <div class="overflow-hidden rounded-2xl w-24 h-24 flex p-1">
                <div  class="news-media-card overflow-hidden w-full h-full flex items-end rounded-lg" data-bg="">
                    <div class="news-media-title px-2 pb-2 text-neutral-800">SEO settings</div>
                </div>
            </div>
        </div>
    </div>

    <div class="can-divide with-divider">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-bold text-xl">{{ __('Social Links') }}</h2>
            <a href="{{ route('user-mix-settings-social') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                {{ __('Manage') }} <i class="la la-arrow-right"></i>
            </a>
        </div>
        
        <div class="social-links-grid grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
            @foreach (socials() as $key => $items)
                @php
                    $socialValue = user('social.'.$key);
                    $isConfigured = !empty($socialValue);
                @endphp
                
                <a href="{{ route('user-mix-settings-social') }}" 
                   class="social-link-card {{ $isConfigured ? 'configured' : 'not-configured' }} rounded-xl p-4 flex flex-col items-center justify-center transition-all hover:scale-105 relative">
                    <div class="icon-wrapper mb-2" style="color: {{ ao($items, 'color') == 'linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d)' ? '#c13584' : ao($items, 'color') }}">
                        <i class="{{ ao($items, 'icon') }} text-3xl"></i>
                    </div>
                    <div class="social-name text-xs font-medium text-center">{{ ao($items, 'name') }}</div>
                    @if($isConfigured)
                        <div class="status-badge absolute top-2 right-2">
                            <i class="la la-check-circle text-green-500 text-lg"></i>
                        </div>
                    @else
                        <div class="status-badge absolute top-2 right-2 opacity-50">
                            <i class="la la-plus-circle text-gray-400 text-lg"></i>
                        </div>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
    
    <div class="can-divide with-divider">
        <h2 class="font-bold text-xl mb-6">{{ __('Hightlights') }}</h2>
        <section class="stories-section pl-0">
            <!-- DISPLAY STRORIES -->
            <div class="display-stories">
                <!-- SWIPER -->
                <div class="swiper myStories">
                    <div class="swiper-wrapper wrapper-stories flex overflow-x-auto py-0" id="storiesBox">
                        <!-- MY STORY -->
                        <div class="swiper-slide spaceBox">
                            <a href="{{ route('user-mix-highlight-create') }}" class="boxStories block">
                                <div class="btn add-my-story">
                                    <div class="my_img">
                                        <img src="{{ gs('assets/image/emoji/Yellow-1/Selfie.png') }}" alt="my story">
                                        <div class="icon">
                                            <i class="flaticon2-plus"></i>
                                        </div>
                                    </div>
                                    <div class="display-text">
                                        <span>{{ __('Create Story') }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- HERE -> ITEMS -> AUTOMATICALLY BY JAVASCRIPT -->
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="can-divide with-divider">
        <h2 class="font-bold text-xl mb-6">{{ __('Quick Insight') }}</h2>
        <div class="quick-charts grid grid-cols-1 md:grid-cols-2 gap-4">
            
            <div class="quick-chart" style="--div-color: #ec660d;">
                <div class="header-row">
                    <div>
                        <h3>{{ __('Profile Views') }}</h3>
                        <div class="all flex items-baseline">
                            <div class="label">{{ __('All Time:') }}</div>
                            <div>{!! nr(ao($visitor_chart, 'views')) !!}</div>
                        </div>
                    </div>
                    <div class="stats">
                        <div class="number">{!! nr(ao($visitor_chart, 'thisMonthViews')) !!}</div>
                    </div>
                </div>

                <div class="quick-chart-body relative" data-color="#ec660d" data-quick-chart="visitor_chart"></div>

                <div class="quick-chart-footer">
                    <div>{{ \Carbon\Carbon::now()->startOfMonth()->format('M d') }}</div>
                    <div class="title">{{ __('Views') }}</div>
                    <div>{{ __('Today') }}</div>
                </div>
            </div>
            
            @if (Route::has('sandy-blocks-shop-mix-view'))
            <div class="quick-chart" style="--div-color: #ad0dec;">
                <div class="header-row">
                    <div>
                        <h3>{{ __('Product Earnings') }}</h3>
                        <div class="all flex items-baseline">
                            <div class="label">{{ __('All Time:') }}</div>
                            <div>{!! nr(ao($products_chart, 'totalEarnings')) !!}</div>
                        </div>
                    </div>
                    <div class="stats">
                        <div class="number">{!! nr(ao($products_chart, 'totalEarningsMonth')) !!}</div>
                    </div>
                </div>

                <div class="quick-chart-body relative" data-color="#ad0dec" data-quick-chart="sales_chart"></div>

                <div class="quick-chart-footer">
                    <div>{{ \Carbon\Carbon::now()->startOfMonth()->format('M d') }}</div>
                    <div class="title">{{ __('Sales') }}</div>
                    <div>{{ __('Today') }}</div>
                </div>
            </div>
            @endif
            
            <div class="quick-chart" style="--div-color: #e69431;">
                <div class="header-row">
                    <div>
                        <h3>{{ __('Audience Insight') }}</h3>
                        <div class="all flex items-baseline">
                            <div class="label">{{ __('All Time') }}:</div>
                            <div>0</div>
                        </div>
                    </div>
                    <div class="stats">
                        <div class="number">0</div>
                    </div>
                </div>

                <div class="quick-chart-body relative" data-color="#e69431" data-quick-chart="audience_chart"></div>

                <div class="quick-chart-footer">
                    <div class="hidden">Jun 3</div>
                    <div class="title">{{ __('New') }}</div>
                    <div>{{ __('Today') }}</div>
                </div>
            </div>
            <div class="quick-chart" style="--div-color: #288efd;">
                <div class="header-row">
                    <div>
                        <h3>{{ __('Membership Insight') }}</h3>
                        <div class="all flex items-baseline">
                            <div class="label">{{ __('All Time') }}:</div>
                            <div>0</div>
                        </div>
                    </div>
                    <div class="stats">
                        <div class="number">0</div>
                    </div>
                </div>

                <div class="quick-chart-body relative" data-color="#288efd" data-quick-chart="membership_chart"></div>

                <div class="quick-chart-footer">
                    <div class="hidden">Jun 3</div>
                    <div class="title">{{ __('New') }}</div>
                    <div>{{ __('Today') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="can-divide with-divider">
        <h2 class="font-bold text-xl mb-6">{{ __('Quick Actions') }}</h2>
        <div class="quick-actions grid grid-cols-2 gap-4">

            @if (Route::has('sandy-blocks-shop-mix-view'))
            <a class="quick-action" href="{{ route('sandy-blocks-shop-mix-view') }}">

                <div class="quick-action-inner">
                    {{ __('Create Product') }}
                    <span class="arrow-go">→</span>
                </div>
                {!! svg_i('store-1') !!}
            </a>
            @endif

            @if (Route::has('sandy-blocks-booking-mix-dashboard'))
            <a class="quick-action" href="{{ route('sandy-blocks-booking-mix-dashboard') }}">

                <div class="quick-action-inner">
                    {{ __('Booking') }}
                    <span class="arrow-go">→</span>
                </div>
                {!! svg_i('hour-1') !!}
            </a>
            @endif

            <a class="quick-action share-profile-modal-open">

                <div class="quick-action-inner">
                    {{ __('Share Page') }}
                    <span class="arrow-go">→</span>
                </div>
                {!! svg_i('share-1') !!}
            </a>

            <a class="quick-action" href="{{ route('user-mix-settings') }}">

                <div class="quick-action-inner">
                    {{ __('Settings') }}
                    <span class="arrow-go">→</span>
                </div>
                {!! svg_i('cogwheel-1') !!}
            </a>
        </div>
    </div>
</div>


<script>
    var visitor_chart = {!! ao($visitor_chart, 'visitors.visits') !!};
    var sales_chart = {!! ao($products_chart, 'payments.earnings') !!};

    
    var audience_chart = [10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10];
    var membership_chart = [10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10];
</script>

@section('footerJS')

<script>
    var stories = new Zuck('storiesBox', {
        autoFullScreen: true,
        skin: 'Snapssenger',
        avatars: false,
        list: false,
        openEffect: true,
        cubeEffect: true,
        backButton: false,
        backNative: false,
        localStorage: true,
        paginationArrows: true,
        stories: {!! json_encode(yetti_highlight_stories($user->id, 'mix', session('active_workspace_id'))) !!},
    });
</script>
@stop
@endsection
