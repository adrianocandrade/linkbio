<div class="relative flex flex-col gap-4">
    
    <?php foreach ($sections as $item): ?>
            <?php
                $fetch = ao($item->content, 'fetch');
                $js_function = "sandy_embed_id_$item->id";
                $extra_attr = 'target="_blank" href="'. linker(ao($fetch, 'fw'), $block->user) .'"';
            
                if ($iframe = ao($fetch, 'h')) {
                    $extra_attr = "data-sandy-embed=\"$js_function\" data-sandy-embed-open=\"sandy-embed-dialog\"";
                }
            ?>
            <div class="sandy-compact-embed">
                <?php $urlDomain = ao($fetch, 'w');
                    $urlFullDomain = ao($fetch, 'fw');

                    $url_components = parse_url($urlFullDomain);
                    $height = '380px';
                    $playerType = '';

                    if (ao($url_components, 'query') == 'player=mini'){
                       parse_str($url_components['query'], $params);
                       $playerType = $params['player'];
                    }

                    if ($playerType == 'mini') {
                        $height = '80px';
                    }
                    if ('open.spotify.com' == $urlDomain) {
                        if ($url = ao($fetch, 'fw')) { ?>
                            <iframe
                                src="<?= $url ?>" 
                                width="100%"
                                height="<?= $height ?>"
                                frameborder="0"
                                style="border-radius: 12px;"
                                allowtransparency="true"
                                allow="encrypted-media">
                            </iframe>
                        <?php } } else { ?>
                            <div class="sandy-compact-embed-thumb">
                                <?php if ($seo_image = ao($fetch, 's')): ?>
                                <img class="lozad" data-src="<?= $seo_image ?>" alt="">
                                <?php elseif ($favicon = ao($fetch, 'f')): ?>
                                <img class="lozad" data-src="<?= $favicon ?>" alt="">
                                <?php endif ?>
                            </div>
                            <a class="sandy-compact-embed-content cursor-pointer" <?= $extra_attr ?>>
                                <?php if ($website_title = ao($fetch, 't')): ?>
                                <span class="sandy-compact-embed-title"><?= $website_title ?></span>
                                <?php endif ?>
                                <?php if ($website_description = ao($fetch, 'd')): ?>
                                <div class="sandy-compact-embed-description"><?= $website_description ?></div>
                                <?php endif ?>
                                <div class="sandy-compact-embed-site">
                                    <div class="sandy-compact-embed-site-thumb">
                                        <?php if ($favicon = ao($fetch, 'f')): ?>
                                        <img class="lozad" data-src="<?= $favicon ?>" alt="">
                                        <?php endif ?>
                                    </div>
                                    <?php if ($website_link = ao($fetch, 'w')): ?>
                                    <span><?= $website_link ?></span>
                                    <?php endif ?>
                                </div>
                            </a>
                        <?php } ?>
            </div>
        <?php if ($iframe = ao($fetch, 'h')): ?>
        <script>
        var <?= $js_function ?> = <?= json_encode($fetch) ?>
        </script>
        <?php endif ?>
    <?php endforeach ?>

</div>