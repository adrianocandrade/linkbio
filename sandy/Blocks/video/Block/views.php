<div class="element-video">
        <?php foreach ($sections as $item): ?>
            <div class="element-single-video <?= ao($item->content, 'isIframe') ? 'is-iframe' : '' ?>">
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