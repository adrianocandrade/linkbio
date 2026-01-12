<?php
$heading = ao($block, 'name');
$content = ao($block->blocks, 'content');
$courses = \Sandy\Blocks\course\Models\Course::where('user', $block->user)->orderBy('id', 'DESC')->get();
?>
<div class="grid grid-cols-2 gap-4 relative z-10">
    <?php foreach ($courses as $item): ?>
    <?php
    $rating = \Sandy\Blocks\course\Models\CoursesReview::where('course_id', $item->id)->avg('rating');
    $enrolled = \Sandy\Blocks\course\Models\CoursesEnrollment::where('course_id', $item->id)->count();
    ?>
    <div class="bio-courses-card-v1 card_widget card-inherit">
        <div class="course-star-rating">⭐ <?= round($rating, 2) ?></div>
        <a class="courses-preview" href="<?= route('sandy-blocks-course-mix-view', $item->id) ?>">
            <?= media_or_url($item->banner, 'media/courses/banner', true) ?>
        </a>
        <div class="course-detials">
            <a class="course-name" href="<?= route('sandy-blocks-course-mix-view', $item->id) ?>"><?= clean($item->name, 'clean_all') ?></a>
            <p class="mt-2 enrolled-text text-sm"><i class="sio network-icon-069-users text-sm sligh-thick mr-1"></i> <?= number_format($enrolled) ?> <?= __('Enrolled') ?></p>
            <div class="course-prices flex">
                <a href="<?= route('sandy-blocks-course-mix-view', $item->id) ?>" class="sandy-expandable-btn is-gray ml-0 mt-2 text-xs rounded-xl w-full"><span><?= __('Manage') ?></span></a>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>
<div class="add-new-link my-5 sm">
    <a class="el-btn m-0" app-sandy-prevent="" href="<?= route('sandy-blocks-course-mix-new-course') ?>"><i class="sni sni-plus"></i></a>
</div>