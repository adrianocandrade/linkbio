<?php foreach ($sections as $item): ?>
    <div class="element-list">
            <a <?= !empty(ao($item->content, 'link')) ? 'href="'. ao($item->content, 'link') .'"' : '' ?> target="<?= \Str::contains(ao($item->content, 'link'), '/elements') ? '_self' : '_blank' ?>" class="list-container">
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
            </a>
    </div>
<?php endforeach ?>