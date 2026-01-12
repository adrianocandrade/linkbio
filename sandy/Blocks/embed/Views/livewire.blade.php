<div>
    <div class="{{ empty($this->blocks) ? '' : 'hidden' }}">
        @include('include.empty-block-mix')
    </div>

    <div class="relative flex flex-col gap-4 {{ empty($this->blocks) ? 'hidden' : '' }}" wire:sortable="sort">
        @foreach($this->blocks as $index => $item)
            <?php
                $fetch = ao($item, 'content.fetch');
            ?>
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
            if ('open.spotify.com' == $urlDomain) { ?>
                <div class="flex flex-row">
                    <p class="font-9 italic mt-3">
                        <?= __('It was Add a Spotify URL if you want the mini format add at the end of the url ?player=mini example: https://open.spotify.com/embed/track/1LF8IUjHfiXEbTOjpxMULN?utm_source=generator&player=mini') ?>
                    </p>
                </div>
            <?php } ?>
            <div class="yetti-popup-wrapper sandy-compact-embed" wire:sortable.item="{{ ao($item, 'id') }}"
            wire:key="embed-blocks-{{ ao($item, 'id') }}">
                
                <div class="flex items-center bg-white p-3 absolute rounded-lg right-1 top-1">
                    <p class="drag mr-5 cursor-pointer" wire:sortable.handle>
                        <i class="sni sni-move"></i>
                    </p>
                    <a class="ml-auto mr-5 yetti-popup-opener">
                        <i class="sni sni-pen"></i>
                    </a>
                    <button wire:click="delete_block({{ ao($item, 'id') }})">
                        <i class="sni sni-trash"></i>
                    </button>
                </div>

                <?php $urlDomain = ao($fetch, 'w');
                if ('open.spotify.com' == $urlDomain) { ?>
                <?php if ($url = ao($fetch, 'fw')): ?>
                    <iframe
                        src="<?= $url ?>" 
                        width="100%"
                        height="<?= $height ?>"
                        frameborder="0"
                        style="border-radius: 12px;"
                        allowtransparency="true"
                        allow="encrypted-media">
                    </iframe>
                <?php endif ?>
                <?php } else { ?>
                <div class="sandy-compact-embed-thumb">
                    <?php if ($seo_image = ao($fetch, 's')): ?>
                    <img src="<?= $seo_image ?>" alt="">
                    <?php elseif ($favicon = ao($fetch, 'f')): ?>
                    <img src="<?= $favicon ?>" alt="">
                    <?php endif ?>
                </div>
                <a class="sandy-compact-embed-content cursor-pointer">
                    <?php if ($website_title = ao($fetch, 't')): ?>
                    <span class="sandy-compact-embed-title"><?= $website_title ?></span>
                    <?php endif ?>
                    <?php if ($website_description = ao($fetch, 'd')): ?>
                    <div class="sandy-compact-embed-description"><?= $website_description ?></div>
                    <?php endif ?>
                    <div class="sandy-compact-embed-site">
                        <div class="sandy-compact-embed-site-thumb">
                            <?php if ($favicon = ao($fetch, 'f')): ?>
                            <img src="<?= $favicon ?>" alt="">
                            <?php endif ?>
                        </div>
                        <?php if ($website_link = ao($fetch, 'w')): ?>
                        <span><?= $website_link ?></span>
                        <?php endif ?>
                    </div>
                </a>
                <?php } ?>        
                
                <div class="yetti-popup">
                    <div class="yetti-popup-body">
                        <div class="flex items-center mb-5">
                            <div class="text-lg font-bold mr-auto"><?= __('EDIT LINK') ?></div>
                            <button class="yetti-popup-close flex items-center justify-center">
                                <?= svg_i('close-1', 'icon') ?>
                            </button>
                        </div>


                        <form class="m-0" wire:submit.prevent="edit({{ ao($item, 'id') }}, {{ $index }})">
                            <div class="form-input mt-5">
                                <label><?= __('Link') ?></label>
                                <input type="text" name="link" wire:model.defer="blocks.{{ $index }}.content.link">
                            </div>

                            <button class="sandy-expandable-btn mt-5 no-disabled-btn"><span><?= __('Save') ?></span></button>
                        </form>
                    </div>
                    <div class="yetti-popup-overlay"></div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="add-new-link my-5 sm">
        <button type="button" class="el-btn m-0" wire:click="add_new"><i class="sni sni-plus"></i></button>
    </div>
</div>
