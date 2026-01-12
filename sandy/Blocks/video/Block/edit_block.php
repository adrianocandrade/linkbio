<?php
$heading = ao($block, 'blocks.heading');
$content = ao($block->blocks, 'content');
$videoItem = function($item){
};
?>
<div class="element-video">
    <div class="heading theme-text-color">
        <?= clean(ao($heading), 'titles') ?>
    </div>
    <div class="sortable" data-route="<?= route('sandy-blocks-video-sort-item', $block->id) ?>" data-delay="200">
        <?php foreach (ao($block, 'elements') as $item): ?>
        <div class="element-single-video <?= ao($item->content, 'isIframe') ? 'is-iframe' : '' ?> sortable-item" data-id="<?= $item->id ?>">
            
            <div class="flex">
                
                <div class="w-auto flex p-2 rounded-lg mb-2" bg-style="#e2e3e4">
                    
                    <p class="drag mr-0 handle cursor-pointer pointer-events-auto">
                        <i class="sni sni-move text-black"></i>
                    </p>
                    <a href="<?= route('sandy-blocks-video-edit', ['id' => $item->id]) ?>" app-sandy-prevent="" class="ml-auto px-5 pointer-events-auto">
                        <i class="sni sni-pen text-black"></i>
                    </a>
                    <form action="<?= route('sandy-blocks-video-delete-item') ?>" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <input type="hidden" value="<?= $item->id ?>" name="id">
                        <button class="pointer-events-auto" data-delete="<?= __('Are you sure you want to delete this video block?') ?>">
                        <i class="sni sni-trash text-black"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="element-single-video-container" href="<?= getEmbedableLink(ao($item->content, 'type'), ao($item->content, 'link')) ?>">
                <?php if (!ao($item->content, 'isIframe')): ?>
                
                <button class="play-button">
                <i class="sni sni-play"></i>
                </button>
                <img src="<?= ao($item->content, 'thumbnail') ?>" alt="" class="banner">
                <?php else: ?>
                <iframe src="<?= getEmbedableLink(ao($item->content, 'type'), ao($item->content, 'link')) ?>" frameborder="0"></iframe>
                <?php endif ?>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>
<div class="add-new-link my-5 sm">
    <a class="el-btn m-0" app-sandy-prevent="" href="<?= route('sandy-blocks-video-skel', ['block' => $block->id]) ?>"><i class="sni sni-plus"></i></a>
</div>