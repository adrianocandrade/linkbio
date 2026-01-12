<?php
$heading = ao($block, 'name');
$content = ao($block->blocks, 'content');
?>
<div class="bio-titles">
    <div class="heading theme-text-color">
        <?= clean(ao($block->blocks, 'heading'), 'titles') ?>
    </div>
</div>
<div class="bio-swiper-container">
    <div class="bio-swiper-wrapper">
        <div class="bio-swiper-slide sortable" data-route="<?= route('sandy-blocks-slider-sort-item', $block->id) ?>" data-delay="200">
            <?php foreach (ao($block, 'elements') as $item): ?>
            <div class="swiper-item sortable-item" data-id="<?= $item->id ?>">
                <div class="flex">
                    
                    <div class="w-auto flex p-2 rounded-lg mb-2" bg-style="#e2e3e4">
                        
                        <p class="drag mr-0 handle cursor-pointer pointer-events-auto">
                            <i class="sni sni-move text-black"></i>
                        </p>

                        <a href="<?= route('sandy-blocks-slider-edit-skel', ['id' => $item->id]) ?>" app-sandy-prevent="" class="ml-auto px-5 pointer-events-auto">
                            <i class="sni sni-pen text-black"></i>
                        </a>
                        <form action="<?= route('sandy-blocks-slider-delete-item') ?>" method="post">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                            <input type="hidden" value="<?= $item->id ?>" name="id">
                            <button class="pointer-events-auto" data-delete="<?= __('Are you sure you want to delete this slider?') ?>">
                            <i class="sni sni-trash text-black"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="">
                    <div class="is-card">
                        <?= media_or_url($item->thumbnail, 'media/blocks', true) ?>
                        <div class="card-infos">
                            <h2><?= clean(ao($item->content, 'heading'), 'titles') ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
        <div class="bio-slider-arrows">
            <div class="slide-left hidden">
                <i class="sni sni-arrow-left-c"></i>
            </div>
            <div class="slide-right hidden">
                <i class="sni sni-arrow-right-c"></i>
            </div>
        </div>
    </div>
</div>
<div class="add-new-link my-5 sm">
  <a class="el-btn m-0" app-sandy-prevent="" href="<?= route('sandy-blocks-slider-skel', ['block' => $block->id]) ?>"><i class="sni sni-plus"></i></a>
</div>