<div class="element-video">
    
    <div class="{{ empty($this->blocks) ? '' : 'hidden' }}">
        @include('include.empty-block-mix')
    </div>

    
    <div class="relative flex flex-col gap-4 {{ empty($this->blocks) ? 'hidden' : '' }}" wire:sortable="sort">
        @foreach($this->blocks as $index => $item)

        <div class="yetti-popup-wrapper" wire:sortable.item="{{ ao($item, 'id') }}" wire:key="embed-blocks-{{ ao($item, 'id') }}">
      
            <div class="flex">
                    
                <div class="w-auto flex p-2 rounded-xl mb-2 bg-gray-200 ml-auto">
                    
                    <p class="drag mr-0 handle cursor-pointer" wire:sortable.handle>
                        <i class="sni sni-move text-black"></i>
                    </p>
                    <a class="ml-auto px-5 pointer-events-auto cursor-pointer yetti-popup-opener">
                        <i class="sni sni-pen text-black"></i>
                    </a>
                    <button wire:click="delete_block({{ ao($item, 'id') }})">
                        <i class="sni sni-trash"></i>
                    </button>
                </div>
            </div>
            


            <div class="element-single-video">
                <div class="element-single-video-container" href="<?= getEmbedableLink(ao($item, 'content.type'), ao($item, 'content.link')) ?>">
                    <?php if (!ao($item, 'content.isIframe')): ?>
                    
                    <button class="play-button">
                    <i class="sni sni-play"></i>
                    </button>
                    <img src="<?= ao($item, 'content.thumbnail') ?>" alt="" class="banner">
                    <?php else: ?>
                    <iframe src="<?= getEmbedableLink(ao($item, 'content.type'), ao($item, 'content.link')) ?>" frameborder="0"></iframe>
                    <?php endif ?>
                </div>
            </div>
    
            <div class="yetti-popup">
                <div class="yetti-popup-body">
                    <div class="flex items-center mb-5">
                        <div class="text-lg font-bold mr-auto"><?= __('EDIT VIDEO') ?></div>
                        <button class="yetti-popup-close flex items-center justify-center">
                            <?= svg_i('close-1', 'icon') ?>
                        </button>
                    </div>

                    <p class="text-xs font-bold">{{ __('Slide to see more video platforms') }}</p>
                    
                    <div class="flex overflow-auto gap-4 mb-5">
                        @foreach ($skeleton as $key => $value)
                        <label class="sandy-big-checkbox">
                        <input type="radio" name="type[{{ ao($item, 'id') }}]" class="sandy-input-inner" data-placeholder-input="#video-link" data-placeholder="{{ ao($value, 'placeholder') }}" value="{{ $key }}" wire:model.defer="blocks.{{ $index }}.content.type" {{ ao($item, 'content.type') == $key ? 'checked' : '' }}>
                        <div class="checkbox-inner">
                            <div class="checkbox-wrap">
                            <div class="h-avatar sm is-video" style="background: {{ ao($value, 'color') }}">
                                <i class="{{ ao($value, 'icon') }}"></i>
                                {!! ao($value, 'svg') !!}
                            </div>
                            <div class="content ml-2 flex items-center">
                                <h1>{{ ao($value, 'name') }}</h1>
                            </div>
                            <div class="icon ml-3">
                                <div class="active-dot">
                                <i class="la la-check"></i>
                                </div>
                            </div>
                            </div>
                        </div>
                        </label>
                        @endforeach
                    </div>
    
    
                    <form class="m-0" wire:submit.prevent="edit({{ ao($item, 'id') }}, {{ $index }})">
                        <div class="form-input mt-5">
                            <label><?= __('Link') ?></label>
                            <input type="text" name="link" wire:model.defer="blocks.{{ $index }}.content.link" id="video-link">
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
