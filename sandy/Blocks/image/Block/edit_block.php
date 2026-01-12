<?php
$heading = ao($block, 'name');
$content = ao($block->blocks, 'content');
?>
<div class="bio-titles">
    <div class="heading theme-text-color">
        <?= clean(ao($block->blocks, 'heading'), 'titles') ?>
    </div>
    <div class="subheading theme-text-color">
        <?= clean(ao($block->blocks, 'subheading'), 'titles') ?>
    </div>
</div>
<div class="multi-image-container sortable" data-route="<?= route('sandy-blocks-image-sort-item', $block->id) ?>" data-delay="200">
    <?php foreach (ao($block, 'elements') as $item): ?>
    <div class="inner-image-container sortable-item" data-id="<?= $item->id ?>">
        <div class="inner-image" <?= elemOrLink($item->id, $block->user) ?>>
            <div class="thumbnail">
                <?= media_or_url($item->thumbnail, 'media/blocks', true) ?>
            </div>
            <h2 class="image-title"><?= clean(ao($item->content, 'caption'), 'titles') ?></h2>
            
            
            <div class="link-out w-auto mort-main-bg p-2 top-2 right-2">
                
                <p class="drag mr-5 handle cursor-pointer pointer-events-auto">
                    <i class="sni sni-move text-black"></i>
                </p>
                <a href="<?= route('sandy-blocks-image-edit-skel', ['id' => $item->id]) ?>" app-sandy-prevent="" class="ml-auto mr-5 pointer-events-auto">
                    <i class="sni sni-pen text-black"></i>
                </a>
                <form action="<?= route('sandy-blocks-image-delete-item') ?>" method="post">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <input type="hidden" value="<?= $item->id ?>" name="id">
                    <button class="pointer-events-auto" data-delete="<?= __('Are you sure you want to delete this image?') ?>">
                    <i class="sni sni-trash text-black"></i>
                    </button>
                </form>
            </div>
            <span class="fancy-drop"></span>
        </div>
    </div>
    <?php endforeach ?>
</div>
<div class="add-new-link my-5 sm">
  <a class="el-btn m-0" app-sandy-prevent="" href="<?= route('sandy-blocks-image-skel', ['block' => $block->id]) ?>"><i class="sni sni-plus"></i></a>
</div>