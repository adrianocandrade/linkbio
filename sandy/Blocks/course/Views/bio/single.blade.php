@extends('bio::layouts.master')
@section('content')
<style>
    .bio-menu{
        display: none !important;
    }
</style>
<div class="relative z-10">
    
    <div class="inner-pages-header mb-0">
        <div class="inner-pages-header-container">
            <a class="previous-page" href="{{ bio_url($bio->id) }}">
                <p class="back-button"><i class="la la-arrow-left"></i></p>
                <h1 class="inner-pages-title ml-3">{{ __('Back') }}</h1>
            </a>
            @if (!$has_course)
            <form action="{{ \Bio::route($bio->id, 'sandy-blocks-course-pay', ['id' => $course->id]) }}" class="w-half h-full m-0" method="post">
                @csrf
                {!! \Bio::button_with_auth($bio->id, ['is-button' => true, 'class' => 'buy-now-button w-full sandy-loader-flower', 'text' => 'Unlock']) !!}
            </form>
            @else
            {!! \Bio::button_with_auth($bio->id, ['link' => \Bio::route($bio->id, 'sandy-blocks-course-take-course', ['id' => $course->id]), 'class' => 'buy-now-button sandy-loader-flower', 'text' => 'Take Course']) !!}
            @endif
        </div>
    </div>
    <?php
    $rating = \Sandy\Blocks\course\Models\CoursesReview::where('course_id', $course->id)->avg('rating');
    $enrolled = \Sandy\Blocks\course\Models\CoursesEnrollment::where('course_id', $course->id)->count();
    ?>
    <div class="bio-single-shop-product is-course">
        <div class="single-banner mb-8">
            {!! media_or_url($course->banner, 'media/courses/banner', true) !!}
        </div>
        <div class="center course-body">
            @if (!$has_course)
            <div class="flex items-center">
                <div class="text-stage text-gray-400">⭐ {{ round($rating, 2) }}</div>
                <div class="text-stage text-gray-400 text-sm ml-5"><i class="sio network-icon-069-users text-sm sligh-thick mr-1"></i> {{ $enrolled }} {{ __('Enrolled') }}</div>
            </div>
            @if (!empty($course->course_level) && is_array($course->course_level))
            <div class="text-stage c-orange"><i class="sio office-021-bar-chart mr-2"></i> {{ ucwords(implode(', ', $course->course_level)) }}</div>
            
            @endif
            
            @if (\Auth::check())
            <div class="text-stage c-currency-p ml-auto flex items-center">{{ __('Unlock with') }} <b class="ml-2"> {{ user('name') }}</b> <div class="tiny-avatar"><img src="{{ avatar() }}" alt="{{ user('name') }}"></div></div>
            @endif
            <h1 class="product-title mb-2">{{ $course->name }}</h1>
            <div class="flex items-center">
                <div class="product-prices text-sm mb-5">
                    <div class="actual italic">{!! \Bio::price($course->price, $bio->id) !!}</div>
                </div>
            </div>
            <div class="text-base mb-10"><div class="details__text">{!! clean($course->description, 'titles') !!}</div></div>
            <hr>
            <h1 class="product-title mt-5 mb-3 text-lg">{{ __('Course Includes') }}</h1>
            @if (!empty($course->course_includes) && is_array($course->course_includes))
            <div class="course-includes">
                <ul class="pricing-lists mb-7">
                    @foreach ($course->course_includes as $key => $value)<li>
                        <li class="mt-3">
                            <a class="text-xs flex items-center">
                                <span class="underline">{{ $value }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @else
                <a href="{{ \Bio::route($bio->id, 'sandy-blocks-course-take-course', ['id' => $course->id]) }}" class="button bg-black text-white w-full shadow-none mt-2">{{ __('Take Course') }}</a>
                @endif
                <div class="sandy-tabs">
                    <div class="lession-or-review">
                        <a class="active sandy-tabs-link">{{ __('Lession') }}</a>
                        <a class="sandy-tabs-link">{{ __('Review') }}</a>
                    </div>
                    <div class="sandy-tabs-item">
                        @forelse ($lessons as $item)
                        <div class="lessions flex items-center justify-between">
                            <div class="lession-detail">
                                <h1 class="text-base">{{ $item->name }}</h1>
                                <p class="duration text-gray-400 text-sm">{{ $item->lesson_duration }}</p>
                            </div>
                            <div class="icon">
                                <i class="{{ $types_icon($item->lesson_type) }} sligh-thick text-lg"></i>
                            </div>
                        </div>
                        @empty
                        <h1 class="product-title mt-5 mb-3 text-lg text-center p-10">{{ __('No Lesson Found. 😥') }}</h1>
                        @endforelse
                    </div>
                    <div class="sandy-tabs-item">
                        <div class="p-5 mb-5 rounded-2xl course-review-wrapper">
                            
                            @if ($has_course)
                            
                            <form class="comment-form m-0" action="{{ \Bio::route($bio->id, 'sandy-blocks-course-review', ['id' => $course->id]) }}" method="post">
                                @csrf
                                <div class="comment-title">{{ __('Leave a Review') }}</div>
                                <div class="comment-head">
                                    <div class="comment-text">{{ __('Leave a review on how this course was.') }}</div>
                                </div>
                                <p class="mt-3 mb-2 text-base">{{ __('Rating') }}</p>
                                <div class="mb-5">
                                    <input type="hidden" value="2" name="rating" id="rating-input">
                                    
                                    <div class="rating js-rating m-0 p-0" data-rating="2" data-input-id="#rating-input" data-read="false"></div>
                                </div>
                                <div class="form-input text-count-limit" data-limit="500">
                                    <span class="text-count-field"></span>
                                    <textarea name="review" cols="30" rows="10"></textarea>
                                </div>
                                <button class="text-sticker mt-4">{{ __('Post') }}</button>
                            </form>
                            @else
                            <p class="text-lg">{{ __('Unlock course to leave review.') }}</p>
                            @endif
                        </div>
                        <div class="rounded-2xl course-review-wrapper flex-col m-0 p-6 md:p-10">
                            <div>
                                <div class="comment">
                                    <div class="comment-head">
                                        <div class="comment-title">{{ number_format($review->count()) }} {{ __('Review(s)') }}</div>
                                    </div>
                                    <div class="comment-list">
                                        @foreach ($review as $item)
                                        
                                        <div class="comment-item">
                                            <div class="comment-details">
                                                <div class="comment-top">
                                                    <div class="comment-author">
                                                        <div class="tiny-avatar ml-0 mr-2">
                                                            <img src="{{ avatar($item->reviewer_id) }}" alt=" ">
                                                        </div>
                                                        {{ user('name', $item->reviewer_id) }}
                                                    </div>
                                                    <div class="rating js-rating" data-rating="{{ !empty($item->rating) ? $item->rating : '0' }}" data-read="true"></div>
                                                </div>
                                                <div class="comment-content">{{ $item->review }}</div>
                                                <div class="comment-foot">
                                                    <div class="comment-time">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-32"></div>
        </div>
    </div>
    
@endsection