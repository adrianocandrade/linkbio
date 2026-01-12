   <div class="multi-image-container">
        <?php foreach ($sections as $item): ?>
            <div class="inner-image-container">
                <a class="inner-image" <?= !empty(ao($item->content, 'link')) ? 'href="'. ao($item->content, 'link') .'"' : '' ?> target="<?= \Str::contains(ao($item->content, 'link'), '/elements') ? '_self' : '_blank' ?>">
                    <div class="thumbnail">
                        <?= media_or_url($item->thumbnail, 'media/blocks', true) ?>
                    </div>
                    
                    <?php if (!empty(ao($item->content, 'caption'))): ?>
                    <h2 class="image-title"><?= clean(ao($item->content, 'caption'), 'titles') ?></h2>
                    <?php endif ?>
                    <?php if ($item->is_element): ?>
                        <div class="link-out">
                            <i class="sni sni-spark"></i>
                        </div>
                    <?php elseif(!empty($item->link)): ?>
                        <div class="link-out">
                            <?= svg_i('arrow-right-up-1', 'w-8 h-5') ?>
                        </div>
                    <?php endif ?>
                    <span class="fancy-drop"></span>
                </a>
            </div>
        <?php endforeach ?>
    </div>