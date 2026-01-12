@extends('index::layouts.master')
@section('title', __t(''))
@if($seo = head_seo_tags())
    @section('seo')
    <meta property="og:type" content="website" />
    <meta property="twitter:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="twitter:url" content="{{ url()->current() }}" />
    {!! $seo !!}
    @stop
    @endif
    @section('content')

    @section('footerJS')
    <script>

    </script>
    @stop
        <div class="yetti-hero">
            <div class="hero-creator-images">
                <div class="creator-image-wrap ci-wrap-left">
                    <img src="{{ gs('assets/image/others/anthony-persegol-rDQLQg1L99A-unsplash.jpg') }}" class="hero-creator-image">
                </div>

                <div class="creator-image-wrap ci-wrap-center">
                    <img src="{{ gs('assets/image/others/1millidollars-pWt4Ga867MY-unsplash.jpg') }}"
                        class="hero-creator-image hci-center">
                </div>

                <div class="creator-image-wrap ci-wrap-right">
                    <img src="{{ gs('assets/image/others/charlota-blunarova-U7ud6KGrsRQ-unsplash.jpg') }}"
                        alt="artist" class="hero-creator-image">
                </div>
            </div>
            <div class="hero-copy">
                <h3 class="hero-h3 text-gray-400 bg-transparent">{{ __('A PLATFORM FOR CREATORS') }}</h3>
                <h1 class="hero-h1">{{ __('Links has never been this easy') }}</h1>
                <div class="hero-text">{{ __('We give power and tools to creators to showcase themselves in a unique way.') }}</div>
            </div>
            <div class="hero-button">
                <a href="{{ route('user-register') }}" class="cta w-button">{{ __('Get Started') }}</a>
            </div>
        </div>


        <div class="app-suite">
            <img src="{{ gs('assets/image/others/Flat-iPhone-2888.png') }}"
                alt=" " class="app-screen center-card screen-1">
            <img src="{{ gs('assets/image/others/Flat-iPhone-2432.png') }}"
                alt=" " class="app-screen phone-edge-card screen-2">
            <img src="{{ gs('assets/image/others/Flat-iPhone-3888.png') }}"
                alt=" " class="app-screen screen-3">
            <img src="{{ gs('assets/image/others/Flat-iPhone-2534.png') }}"
                alt=" " class="app-screen phone-edge-card screen-4">
            <img src="{{ gs('assets/image/others/Flat-iPhone-2232.png') }}"
                alt=" " class="app-screen center-card screen-5">
        </div>


        <div class="value-prop-cards">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="square-card">
                    <div class="vp-design">
                        <div class="vp-design-inner flex">
                            <div class="vp-design-card active">
                                <div class="vp-design-icon">🏗️</div>
                                <div class="vp-design-title">{{ __('Blocks') }}</div>
                                <div class="vp-design-sub">{{ __('10+ usable') }}</div>
                            </div>
                            <div class="vp-design-card">
                                <div class="vp-design-icon">⚡</div>
                                <div class="vp-design-title">{{ __('Pages') }}</div>
                                <div class="vp-design-sub">{{ __('creative templates') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="vp-text">
                        <h1 class="value-prop-h1">{{ __('Creative Blocks 🔥') }}</h1>
                        <div class="text-block-2">{{ __('Engage your visitors with interactive images, videos, links, booking sections.') }}</div>
                    </div>
                </div>

                <div class="square-card">
                    <div class="vp-design">
                        <div class="vp-design-inner flex flex-col">
                            <div class="vp-design-card active w-full">
                                <div class="vp-design-icon">📱</div>
                                <div class="vp-design-title">{{ __('Builder') }}</div>
                                <div class="vp-design-sub">{{ __('drag & drop') }}</div>
                            </div>
                            <div class="vp-design-card w-full">
                                <div class="vp-design-icon">🔥</div>
                                <div class="vp-design-title">{{ __('Page') }}</div>
                                <div class="vp-design-sub">{{ __('under 5 min') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="vp-text">
                        <h1 class="value-prop-h1">{{ __('Mobile first 📱') }}</h1>
                        <div class="text-block-2">{{ __('Get your page in no time with our mobile first builder.') }}</div>
                    </div>
                </div>

                <div class="square-card">

                    <div class="vp-design">
                        <div class="vp-design-inner flex">
                            <div class="vp-design-card active">
                                <div class="vp-design-icon">📈</div>
                                <div class="vp-design-title">{{ __('Visitors') }}</div>
                                <div class="vp-design-sub">{{ __('view live users') }}</div>
                            </div>
                            <div class="vp-design-card">
                                <div class="vp-design-icon">🪢</div>
                                <div class="vp-design-title">{{ __('Pixel') }}</div>
                                <div class="vp-design-sub">{{ __('track everything') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="vp-text">
                        <h1 class="value-prop-h1">{{ __('In depth insight 📈') }}</h1>
                        <div class="text-block-2">{{ __('Track links, live views, page visits with our advance analytics system.') }}</div>
                    </div>
                </div>

                <div class="full-width-card md:col-span-3">
                    <div class="card-surface">
                        <div class="creator-circles">
                            <img src="{{ gs('assets/image/others/group-unsplash-1.png') }}" alt=" " class="creator-circles-img"></div>
                        <div class="vp-text long-text">
                            <h1 class="value-prop-h1">{{ __('More ways to reach your audience.') }}</h1>
                            <div class="text-block-2 long-text">{{ __('Blocks, pages, products, courses, memberships and many more are available on our platform.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-features">
            <div class="feature-highlight-1 py-14">
                <div class="feature-prop">
                    <h1 class="splash-h1 text-black">{{ __('No code required') }}</h1>
                    <div class="splash-text text-black">{{ __('Start engaging your visitors with interactive images, videos, links sections among others. Choose from various pre-designed block sections & save lot of time writing codes.') }}</div>
                </div>
                <div class="feature-mockup dual-phone mb-9 md:mb-0">
                    <img src="{{ gs('assets/image/others/Rio-App-2.png') }}" alt=" " class="image-2">
                </div>
            </div>
            <div class="feature-highlight-2 py-14">
                <div class="feature-mockup mb-9 md:mb-0 mr-0 md:mr-8">
                    <img src="{{ gs('assets/image/others/Rio-App-3.png') }}" alt=" " class="explore-studio-mockup">
                </div>
                <div class="feature-prop">
                    <h1 class="splash-h1 text-black">{{ __('Lot of creative Elements') }}</h1>
                    <div class="splash-text text-black">{{ __('Start collecting money, feedbacks, emails, anonymous notes and more. Create and customize elements from tons of available apps on the platform and more to come!') }}</div>
                </div>
            </div>
            <div class="feature-highlight-3 py-14">
                <div class="feature-prop">
                    <h1 class="splash-h1 text-black">{{ __('Advance Analytics') }}</h1>
                    <div class="splash-text text-black">{{ __('Track links, live views, page visits with our advance analytics system. Connect pixels from various platform to gather more data from visitors.') }}</div>
                </div>
                <div class="feature-mockup mb-9 md:mb-0">
                    <img src="{{ gs('assets/image/others/Rio-App-1.png') }}" alt=" " class="profile-playlist-mockup"></div>
            </div>
            <div class="closer">
                <div class="closing-cta py-20 bg-white">
                    <div class="full-width-card bottom-cta-wrap h-auto bg-white p-16">
                        
                <div>
                    <div class="preview-ui">
                        <div class="section-block max-w-fulle mx-auto text-center">
                            <h2 class="h2-bolder">{{ __('Get started with your page.') }}</h2>
                            <p class="subtitle-s text-sm">
                                {{ __('Start collecting money, feedbacks, emails, anonymous notes and more.') }}
                            </p>
                        </div>
                        <ul class="pricing-lists mt-5 md:flex justify-center text-center">
                            <li>
                                <i class="flaticon2-checkmark icon mr-4 hidden md:inline-flex"></i>
                                <span>{{ __('Add your custom domain.') }}</span>
                            </li>
                            <li class="ml-3">
                                <i class="flaticon2-checkmark icon mr-4 hidden md:inline-flex"></i>
                                <span>{{ __('Expand with our extensive API.') }}</span>
                            </li>
                            <li class="ml-3">
                                <i class="flaticon2-checkmark icon mr-4 hidden md:inline-flex"></i>
                                <span>{{ __('Customize your bio to your taste.') }}</span>
                            </li>
                        </ul>
                        <div class="flex justify-center">
                            <a href="{{ route('pricing-index') }}"
                                class="text-link underline block mt-5 has-wth">{{ __('See Pricing') }}</a>
                        </div>
                        <div class="preview-ui-item p-1">
                            <div class="sandy-jump-animation">
                                <div class="layer relative" data-depth=".05">
                                    <img src="{{ emoji('Gestures-Yellow/OkRight', 'png') }}"
                                        alt="" class="up">
                                </div>
                            </div>
                        </div>
                        <div class="preview-ui-item p-2">
                            <div class="sandy-jump-animation">
                                <div class="layer relative" data-depth=".075">
                                    <img src="{{ gs('assets/image/3d/Preloader-1.png') }}"
                                        alt="" class="up">
                                </div>
                            </div>
                        </div>
                        <div class="preview-ui-item p-4 -top-2/4">
                            <div class="sandy-jump-2-animation">
                                <div class="layer relative" data-depth=".125">
                                    <img src="{{ emoji('Yellow-1/HeartEyes', 'png') }}"
                                        alt="" class="up">
                                </div>
                            </div>
                        </div>
                        <div class="preview-ui-item p-8">
                            <div class="sandy-jump-animation">
                                <div class="layer relative" data-depth=".1">
                                    <img src="{{ gs('assets/image/3d/Pencil-1.png') }}" alt=""
                                        class="up">
                                </div>
                            </div>
                        </div>
                        <div class="preview-ui-item p-9 hidden">
                            <div class="sandy-jump-animation">
                                <div class="layer relative" data-depth=".05">
                                    <img src="{{ gs('assets/image/3d/Preloader-1.png') }}"
                                        alt="" class="up">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                    </div>
                </div>
                
            </div>
        </div>


        <div class="hidden">

            <div class="hero">


                <div class="container_thin js-parallax pointer-events-auto">
                    <div class="two-colls">
                        <div class="two-colls__item flex flex-col">
                            <div class="vertically_centered">
                                <div class="hero__tag-container">
                                    <p class="tag">{{ __('Bio') }}</p>
                                    <p class="tag">{{ __('Page Builder') }}</p>
                                </div>
                                <h1 class="title_big">{{ __('Build Yourself Now!') }}</h1>
                                <p class="hero__subtitle">
                                    {{ __('We give power and tools to creators to showcase themselves in a unique way while focusing on growing themselves.') }}
                                </p>
                                <div class="hero__button-group z-50 relative">
                                    <a class="button"
                                        href="{{ route('user-register') }}">{{ __('Get Started') }}</a>
                                    <a class="button_black sandy-smooth-href"
                                        href="#start-exploring">{{ __('How it Works') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="two-colls__item layer relative mt-20 md:mt-0">
                            <div class="layouts-view relative lg:hidden">
                                <div class="layouts-preview">
                                    <div class="layer relative" data-depth=".05">
                                        <img class=""
                                            src="{{ gs('assets/image/3d/mobile-1.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="layouts-view relative hidden lg:flex">
                                <div class="layouts-preview">
                                    <div class="layer relative" data-depth=".05">
                                        <img class="" src="{{ gs('assets/image/3d/1.png') }}"
                                            alt="">
                                    </div>
                                </div>
                                <div class="layouts-preview">
                                    <div class="layer relative" data-depth=".075">
                                        <img class="sandy-down-2-animation"
                                            src="{{ gs('assets/image/3d/3.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="layouts-preview">
                                    <div class="layer relative" data-depth=".05">
                                        <img class="sandy-scale-up-1-animation"
                                            src="{{ gs('assets/image/3d/5.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="layouts-preview">
                                    <div class="layer relative" data-depth=".05">
                                        <img class="sandy-jump-2-animation"
                                            src="{{ gs('assets/image/3d/4.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="layouts-preview">
                                    <div class="layer relative" data-depth=".125">
                                        <img class="sandy-jump-animation"
                                            src="{{ gs('assets/image/3d/2.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="hero-preview hidden">
                                <div class="hero-shape"></div>
                                <div class="hero-preview-item b-1">
                                    <div class="layer relative" data-depth=".05">
                                        <img src="https://ui8-collab.herokuapp.com/img/layouts-pic-1.png"
                                            class="image-32" alt="">
                                    </div>
                                </div>
                                <div class="hero-preview-item b-2">
                                    <div class="layer relative" data-depth=".025">
                                        <img src="https://assets-global.website-files.com/60b9220d74f790a1191230c9/6139d3de1839927e560a1002_hero-mail.png"
                                            class="image-32" alt="" width="156">
                                    </div>
                                </div>
                                <div class="hero-preview-item b-3">
                                    <div class="layer relative" data-depth=".125">
                                        <img src="https://assets-global.website-files.com/60b9220d74f790a1191230c9/6139d3dee2504e0b82c79725_hero-pencil.png"
                                            class="image-32" alt="" width="141.5">
                                    </div>
                                </div>
                                <div class="hero-preview-item b-6 md:w-1/4">
                                    <div class="layer relative" data-depth=".125">
                                        <img src="{{ emoji('Yellow-1/HeartEyes', 'png') }}"
                                            class="image-32 sandy-jump-2-animation" alt="" height="209">
                                    </div>
                                </div>
                                <div class="hero-preview-item b-7">
                                    <div class="layer relative" data-depth=".025">
                                        <img src="https://ui8-collab.herokuapp.com/img/offer-pic-3.png" class="image-32"
                                            alt="" width="141.5">
                                    </div>
                                </div>
                                <div class="hero-preview-item b-4">
                                    <div class="layer relative" data-depth=".025">
                                        <img src="https://ui8-collab.herokuapp.com/img/offer-pic-3.png" class="image-32"
                                            alt="" width="141.5">
                                    </div>
                                </div>
                                <div class="hero-preview-item b-11 md:w-1/4">
                                    <div class="layer relative" data-depth=".125">
                                        <img src="https://ui8-collab.herokuapp.com/img/layouts-pic-5.png"
                                            class="image-32 sandy-jump-animation" alt="" height="209">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sandy-container home-section mx-auto md:grid grid-cols-2 js-parallax">
                <div class="flex items-center mb-5 md:mb-0">
                    <div class="section-block">
                        <h2 class="h2-bolder">{{ __('No code required') }}</h2>
                        <div class="subtitle-s">
                            {{ __('Start engaging your visitors with interactive images, videos, links sections among others. Choose from various pre-designed block sections & save lot of time writing codes.') }}
                        </div>
                    </div>
                </div>
                <div class="preview-ui">
                    <img src="{{ gs('assets/image/others/Rio-App-2.png') }}" alt=""
                        class="preview-ui-image" width="584">
                    <div class="preview-ui-item p-1">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".05">
                                <img src="{{ emoji('Gestures-Yellow/OkRight', 'png') }}"
                                    alt="" class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-3">
                        <div class="sandy-jump-2-animation">
                            <div class="layer relative" data-depth=".125">
                                <img src="{{ emoji('Yellow-1/Idea', 'png') }}"
                                    alt="" class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-4">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".125">
                                <img src="{{ emoji('Yellow-1/StarEyes', 'png') }}"
                                    alt="" class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-5">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".075">
                                <img src="{{ gs('assets/image/3d/Sphere-1.png') }}" alt=""
                                    class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-7">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".075">
                                <img src="{{ gs('assets/image/3d/Card-1.png') }}" alt=""
                                    class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-8">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".1">
                                <img src="{{ gs('assets/image/3d/Graph-1.png') }}" alt=""
                                    class="up">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sandy-container home-section mx-auto md:grid grid-cols-2 js-parallax">
                <div class="flex items-center mb-5 md:mb-0">
                    <div class="section-block">
                        <h2 class="h2-bolder">{{ __('Lot of creative Elements') }}</h2>
                        <div class="subtitle-s">
                            {{ __('Start collecting money, feedbacks, emails, anonymous notes and more. Create and customize elements from tons of available apps on the platform and more to come!') }}
                        </div>
                    </div>
                </div>
                <div class="preview-ui">
                    <img src="{{ gs('assets/image/others/Rio-App-3.png') }}" alt=""
                        class="preview-ui-image" width="584">
                    <div class="preview-ui-item p-1">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".05">
                                <img src="{{ gs('assets/image/3d/Pen-1.png') }}" alt=""
                                    class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-2">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".075">
                                <img src="{{ gs('assets/image/3d/Sphere-2.png') }}" alt=""
                                    class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-3">
                        <div class="sandy-jump-2-animation">
                            <div class="layer relative" data-depth=".125">
                                <img src="{{ emoji('Yellow-1/MoneyMouthFace', 'png') }}"
                                    alt="" class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-4">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".125">
                                <img src="{{ emoji('Gestures-Yellow/HandHoldingPencilLeft', 'png') }}"
                                    alt="" class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-7">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".075">
                                <img src="{{ gs('assets/image/3d/Preloader-1.png') }}" alt=""
                                    class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-8">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".1">
                                <img src="{{ gs('assets/image/3d/498.png') }}" alt=""
                                    class="up">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sandy-container home-section mx-auto md:grid grid-cols-2 js-parallax">
                <div class="flex items-center mb-5 md:mb-0">
                    <div class="section-block">
                        <h2 class="h2-bolder">{{ __('Advance Analytics') }}</h2>
                        <div class="subtitle-s">
                            {{ __('Track links, live views, page visits with our advance analytics system. Connect pixels from various platform to gather more data from visitors.') }}
                        </div>
                    </div>
                </div>

                <div class="preview-ui">
                    <img src="{{ gs('assets/image/others/Rio-App-1.png') }}" alt=""
                        class="preview-ui-image" width="584">
                    <div class="preview-ui-item p-1">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".05">
                                <img src="{{ emoji('Yellow-1/Idea', 'png') }}"
                                    alt="" class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-3">
                        <div class="sandy-jump-2-animation">
                            <div class="layer relative" data-depth=".125">
                                <img src="{{ emoji('Gestures-Yellow/ThumbsUp', 'png') }}"
                                    alt="" class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-4">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".125">
                                <img src="{{ emoji('Yellow-1/Like', 'png') }}"
                                    alt="" class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-7">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".075">
                                <img src="{{ gs('assets/image/3d/Layers-1.png') }}" alt=""
                                    class="up">
                            </div>
                        </div>
                    </div>
                    <div class="preview-ui-item p-8">
                        <div class="sandy-jump-animation">
                            <div class="layer relative" data-depth=".1">
                                <img src="{{ gs('assets/image/3d/Graph-2.png') }}" alt=""
                                    class="up">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section details mb-20" id="start-exploring">
                <div class="details__center center">
                    <div class="details__list">
                        <div class="details__item">
                            <div class="details__icon">
                                {!! feather('pen-tool', 'w-10 h-10') !!}
                            </div>
                            <div class="details__category">{{ __('Drag & Drop') }}</div>
                            <div class="details__content">
                                {{ __('Get started with our easy drag & drop interface that lets you organise your bio content into sections.') }}
                            </div>
                        </div>
                        <div class="details__item">
                            <div class="details__icon">
                                {!! feather('tool', 'w-10 h-10') !!}
                            </div>
                            <div class="details__category">{{ __('No coding skill.') }}</div>
                            <div class="details__content">
                                {{ __('We provide a working maintenance free system that does not require any coding skill & gives a smart layout.') }}
                            </div>
                        </div>
                        <div class="details__item">
                            <div class="details__icon">
                                {!! feather('credit-card', 'w-10 h-10') !!}
                            </div>
                            <div class="details__category">{{ __('Flexible pricing') }}</div>
                            <div class="details__content">
                                {{ __('We provide flexible & transparent pricing tailored to your need. Check it out!') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sandy-container home-section has-patternp min-h-full rounded-xl" bg-style="#f0f0f0">
                <div>
                    <div class="preview-ui">
                        <div class="section-block max-w-fulle mx-auto text-center">
                            <h2 class="h2-bolder">{{ __('Get started with your page.') }}</h2>
                            <p class="subtitle-s text-sm">
                                {{ __('Start collecting money, feedbacks, emails, anonymous notes and more.') }}
                            </p>
                        </div>
                        <ul class="pricing-lists mt-5 md:flex justify-center text-center">
                            <li>
                                <i class="flaticon2-checkmark icon mr-4 hidden md:inline-flex"></i>
                                <span>{{ __('Add your custom domain.') }}</span>
                            </li>
                            <li class="ml-3">
                                <i class="flaticon2-checkmark icon mr-4 hidden md:inline-flex"></i>
                                <span>{{ __('Expand with our extensive API.') }}</span>
                            </li>
                            <li class="ml-3">
                                <i class="flaticon2-checkmark icon mr-4 hidden md:inline-flex"></i>
                                <span>{{ __('Customize your bio to your taste.') }}</span>
                            </li>
                        </ul>
                        <div class="flex justify-center">
                            <a href="{{ route('pricing-index') }}"
                                class="text-link underline block mt-5 has-wth">{{ __('See Pricing') }}</a>
                        </div>
                        <div class="preview-ui-item p-1">
                            <div class="sandy-jump-animation">
                                <div class="layer relative" data-depth=".05">
                                    <img src="{{ emoji('Gestures-Yellow/OkRight', 'png') }}"
                                        alt="" class="up">
                                </div>
                            </div>
                        </div>
                        <div class="preview-ui-item p-2">
                            <div class="sandy-jump-animation">
                                <div class="layer relative" data-depth=".075">
                                    <img src="{{ gs('assets/image/3d/Preloader-1.png') }}"
                                        alt="" class="up">
                                </div>
                            </div>
                        </div>
                        <div class="preview-ui-item p-4 -top-2/4">
                            <div class="sandy-jump-2-animation">
                                <div class="layer relative" data-depth=".125">
                                    <img src="{{ emoji('Yellow-1/HeartEyes', 'png') }}"
                                        alt="" class="up">
                                </div>
                            </div>
                        </div>
                        <div class="preview-ui-item p-8">
                            <div class="sandy-jump-animation">
                                <div class="layer relative" data-depth=".1">
                                    <img src="{{ gs('assets/image/3d/Pencil-1.png') }}" alt=""
                                        class="up">
                                </div>
                            </div>
                        </div>
                        <div class="preview-ui-item p-9 hidden">
                            <div class="sandy-jump-animation">
                                <div class="layer relative" data-depth=".05">
                                    <img src="{{ gs('assets/image/3d/Preloader-1.png') }}"
                                        alt="" class="up">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endsection
