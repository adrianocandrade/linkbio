@extends('mix::layouts.master')
@section('title', __('Courses'))
@section('content')
@includeIf('include.back-header', ['route' => url()->previous()])

<div class="wallet-page relative mix-padding-10">
    @if (!plan('settings.block_course'))
        <style>
            .not-plan .content{
                padding: 1rem;
            }
        </style>
        @include('include.no-plan')
    @endif
    @if (!$courses->isEmpty() && !\App\Models\Block::where('user', $user->id)->where('block', 'course')->first())
    <form method="post" action="{{ route('user-mix-block-element-post', 'course') }}">
        @csrf
        <input type="hidden" name="blocks[all_course]" value="1">
        <h1 class="font-bold text-lg">{{ __('Block') }}</h1>
        <p class="text-xs text-gray-400 mb-2">{{ __('You have courses but no course block found.') }}</p>
        <button class="button w-full mb-5" type="submit"><span>{{ __('Add Block') }}</span></button>
    </form>
    @endif
    <div class="dashboard-header-banner relative mt-0 mb-5">
		<div class="card-container">
			
			<div class="text-lg font-bold">{{ __('Courses') }}</div>
            <div class="side-cta">
                <img src="{{ gs('assets/image/emoji/Yellow-1/Nerdy.png') }}" alt="">
            </div>
		</div>
	</div>
    <div class="dashboard-fancy-card-v1 border border-gray-100 border-solid rounded-xl grid grid-cols-2">
        <div class="dashboard-fancy-card-v1-single active">
            <div class="details-item w-full">
                <div class="details-head">
                    <div class="details-preview">
                        <i class="sio office-093-money-sack sligh-thick text-black text-lg"></i>
                    </div>
                    <div class="details-text caption-sm">{{ __('Earned') }}</div>
                </div>
                <div class="details-counter text-2xl md:text-4xl truncate font-bold">{!! \Bio::price(ao($analytics, 'totalEarnings'), $user->id) !!}</div>
                <div class="details-indicator">
                    <div class="details-progress bg-red w-half"></div>
                </div>
            </div>
        </div>
        <div class="dashboard-fancy-card-v1-single">
            <div class="details-item w-full border-0">
                <div class="details-head">
                    <div class="details-preview">
                        <i class="sio media-icon-065-video-camera sligh-thick text-black text-lg"></i>
                        
                    </div>
                    <div class="details-text caption-sm">{{ __('Courses') }}</div>
                </div>
                <div class="details-counter text-2xl md:text-4xl truncate font-bold">{{ nr($courses->count(), true) }}</div>
                <div class="details-indicator">
                    <div class="details-progress bg-sea w-half"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="quick-actions grid grid-cols-2 gap-4 mt-5">
        <a class="quick-action" href="{{ route('sandy-blocks-course-mix-sales') }}">

            <div class="quick-action-inner">{{ __('Orders') }}<span class="arrow-go">→</span>
            </div>
            
            {!! svg_i('pie-chart-1') !!}
        </a>

        <a class="quick-action" href="{{ route('sandy-blocks-course-mix-settings') }}">

            <div class="quick-action-inner">{{ __('Settings') }}<span class="arrow-go">→</span>
            </div>
            {!! svg_i('cogwheel-1') !!}
        </a>

        <a class="quick-action col-span-2" href="{{ route('sandy-blocks-course-mix-new-course') }}">

            <div class="quick-action-inner">{{ __('Create Course') }}<span class="arrow-go">→</span>
            </div>
            {!! svg_i('add-1') !!}
        </a>
    </div>

    <h1 class="my-7 font-bold">{{ __('My Courses') }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-7 relative z-10">
        <div class="flex items-center">
            <div class="bio-courses-card-v1 card_widget w-full is-upload md:h-full">
                <a class="courses-preview text-xl h-full" app-sandy-prevent="" href="{{ route('sandy-blocks-course-mix-new-course') }}">
                    <div class="absolute top-0 left-0 h-full w-full flex items-center justify-center">
                        <i class="plus-icon la la-plus relative flex items-center justify-center"></i>
                    </div>
                </a>
            </div>
        </div>
        @foreach ($courses as $item)
        <div class="bio-courses-card-v1 card_widget">
            <a class="courses-preview" href="{{ route('sandy-blocks-course-mix-view', $item->id) }}">
                <?= media_or_url($item->banner, 'media/courses/banner', true) ?>
            </a>
            <div class="course-detials">
                <a class="course-name" href="">{{ $item->name }}</a>
                <div class="course-prices flex">
                    <a class="text-sticker flex items-center justify-center is-gray" href="{{ route('sandy-blocks-course-mix-view', $item->id) }}"><i class="sio science-and-fiction-037-computer-mouse text-xl"></i></a>
                    <a href="{{ route('sandy-blocks-course-mix-lessons', $item->id) }}" class="text-sticker is-gray ml-2">{{ __('Lessons') }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection