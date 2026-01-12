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
<div class="sortable" data-route="<?= route('sandy-blocks-lists-sort-item', $block->id) ?>" data-delay="200">
    
    <?php foreach (ao($block, 'elements') as $item): ?>
    <div class="element-list sortable-item" data-id="<?= $item->id ?>">
        <div class="list-container">
            
            <div class="flex">
                
                <div class="w-auto flex mort-main-bg p-2 bg-white rounded-lg mb-2">
                    
                    <p class="drag mr-0 handle cursor-pointer pointer-events-auto">
                        <i class="sni sni-move text-black"></i>
                    </p>
                    <a href="<?= route('sandy-blocks-lists-edit-skel', ['id' => $item->id]) ?>" app-sandy-prevent="" class="ml-auto px-5 pointer-events-auto">
                        <i class="sni sni-pen text-black"></i>
                    </a>
                    <form action="<?= route('sandy-blocks-lists-delete-item') ?>" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <input type="hidden" value="<?= $item->id ?>" name="id">
                        <button class="pointer-events-auto" data-delete="<?= __('Are you sure you want to delete this list?') ?>">
                        <i class="sni sni-trash text-black"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="list-content">
                <div class="list-inner">
                    <div class="list-title">
                        <?= clean(ao($item->content, 'heading'), 'titles') ?>
                    </div>
                    <div class="list-desc">
                        <?= clean(ao($item->content, 'subheading'), 'titles') ?>
                    </div>
                </div>
                <div class="list-thumbnail">
                    <?= media_or_url($item->thumbnail, 'media/blocks', true) ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>
<div class="add-new-link my-5 sm">
  <a class="el-btn m-0" app-sandy-prevent="" href="<?= route('sandy-blocks-lists-skel', ['block' => $block->id]) ?>"><i class="sni sni-plus"></i></a>
</div>