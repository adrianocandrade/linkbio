@extends('mix::layouts.master')
@section('title', __('Edit Block'))
@section('footerJS')
<script>
if(app.utils.inIframe()){
window.parent.location.href = window.location.href;
}
</script>
@stop
@section('content')
<div class="card customize m-5 md:m-10 mb-5 md:mb-0 rounded-2xl">
    <div class="card-header">
        <div class="flex items-center mb-0">
            <div class="h-avatar sm mr-3 bg-white border-0 is-video">
                {!! svg_i(config('blocks.course.svg_i'), 'w-8 h-4') !!}
            </div>
            <h1 class="mb-0 title text-lg">{{ __('Edit Course') }}</h1>
        </div>
    </div>
</div>
<div class="p-5 md:p-10">
    
    <form method="post" class="links-accordion mb-5" action="{{ route('user-mix-block-edit', $block->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="sandy-accordion mort-main-bg">
            <div class="sandy-accordion-head flex">
                <span>{{ __('Heading') }}</span>
            </div>
            <div class="sandy-accordion-body mt-5 pb-0">
                <div class="form-input mb-5">
                    <label>{{ __('Heading') }}</label>
                    <input type="text" name="blocks[heading]" class="bg-w" value="{{ ao($block->blocks, 'heading') }}">
                </div>
                <div class="form-input">
                    <label>{{ __('Sub Heading') }}</label>
                    <textarea name="blocks[subheading]" cols="5" class="bg-w" rows="2">{{ ao($block->blocks, 'subheading') }}</textarea>
                </div>
                <button class="mt-5 text-sticker sandy-loader-flower">{{ __('Save') }}</button>
            </div>
        </div>
    </form>
    <?php
    $courses = \App\Models\Course::where('user', $block->user)->orderBy('id', 'DESC')->get();
    ?>
    <div class="grid grid-cols-2 gap-4 relative z-10">
        <?php foreach ($courses as $item): ?>
        
        <?php
        $rating = \App\Models\CoursesReview::where('course_id', $item->id)->avg('rating');
        $enrolled = \App\Models\CoursesEnrollment::where('course_id', $item->id)->count();
        ?>
        <div class="bio-courses-card-v1 card_widget card-inherit">
            <div class="course-star-rating">⭐ <?= round($rating, 2) ?></div>
            <a class="courses-preview" href="{{ route('user-mix-course-view', $item->id) }}">
                <?= media_or_url($item->banner, 'media/courses/banner', true) ?>
            </a>
            <div class="course-detials">
                <a class="course-name" href="{{ route('user-mix-course-view', $item->id) }}"><?= clean($item->name, 'clean_all') ?></a>
                <p class="mt-2 enrolled-text text-sm"><i class="sio network-icon-069-users text-sm sligh-thick mr-1"></i> <?= number_format($enrolled) ?> <?= __('Enrolled') ?></p>
                <div class="course-prices flex">
                    <a href="{{ route('user-mix-course-view', $item->id) }}" class="sandy-expandable-btn is-gray ml-0 mt-2 text-xs"><span>{{ __('Manage') }}</span></a>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
    <div class="add-new-link mt-10">
        <a class="el-btn" app-sandy-prevent="" href="{{ route('user-mix-course-new-course') }}"><i class="sni sni-plus"></i></a>
    </div>
</div>
@endsection