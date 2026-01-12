
    <?php 
        $rating = \Sandy\Blocks\course\Models\CoursesReview::where('course_id', $item->id)->avg('rating');
        $enrolled = \Sandy\Blocks\course\Models\CoursesEnrollment::where('course_id', $item->id)->count();
        $lessons = \Sandy\Blocks\course\Models\CoursesLesson::where('course_id', $item->id)->count();
    ?>
    <div class="bio-courses-card-v1">
        <div class="course-star-rating">⭐ <?= round($rating, 2) ?></div>
        <a class="courses-preview" href="<?= \Bio::route($item->user, 'sandy-blocks-course-single-course', ['id' => $item->id]) ?>">
            <?= media_or_url($item->banner, 'media/courses/banner', true) ?>
        </a>
        <div class="course-detials">
            <a class="course-name" href="<?= \Bio::route($item->user, 'sandy-blocks-course-single-course', ['id' => $item->id]) ?>"><?= clean($item->name, 'clean_all') ?></a>


            
            <div class="course-prices my-3">
                <p class="price text-sm"><?= \Bio::price($item->price, $item->user) ?></p>
            </div>

            <div class="flex justify-between">
                <p class="mt-2 enrolled-text text-sm flex items-center"><i class="sio music-icon-043-play-button mr-1"></i> <?= nr($lessons) ?></p>

                <p class="mt-2 enrolled-text text-sm flex items-center"><i class="mr-1 sio network-icon-069-users"></i> <?= nr($enrolled) ?></p>
            </div>
        </div>
    </div>