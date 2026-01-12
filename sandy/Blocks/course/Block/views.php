<?php
$heading = ao($block, 'name');
$content = ao($block->blocks, 'content');
$courses = \Sandy\Blocks\course\Models\Course::where('user', $block->user)->orderBy('id', 'DESC')->get();
?>
<?php if (!plan('settings.block_course', $block->user)): ?>
    <style>
        .block-id-<?= $block->id ?>{
            display: none !important;
        }
    </style>
<?php endif ?>


<?php if (\Str::is('mix', request()->path()) && !plan('settings.block_course', $block->user)): ?>
    <p class="text-xs text-gray-400 mb-1"><?= __('Courses has been disabled due to plan.') ?></p>
    <a href="<?= Route::has('pricing-index') ? route('pricing-index') : '' ?>" app-sandy-prevent="" class="mb-5 text-sticker secondary-box"><?= __('Change Plan') ?></a>
<?php endif ?>

<div class="grid grid-cols-2 gap-4 relative z-10">
    <?php foreach ($courses as $item): ?>
        <?= \Sandy\Blocks\course\Helper\Catelog::catelog_item($item) ?>
    <?php endforeach ?>
</div>
<a href="<?= \Bio::route($block->user, 'sandy-blocks-course-home') ?>" class="mt-8 sandy-expandable-btn rounded-lg sandy-loader-flower"><span><?= clean(__('All Courses'), 'titles') ?></span></a>