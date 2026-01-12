<div class="image-block-class">
    
    <div class="{{ empty($this->blocks) ? '' : 'hidden' }}">
        @include('include.empty-block-mix')
    </div>

    <style>
        @media(max-width: 640px){
            .image-block-class .yetti-popup-body{
            }

            .image-block-class .multi-image-container .yetti-popup-wrapper:nth-of-type(2n+1) .yetti-popup-body{
                width: 340px !important;
                left: 100% !important;
            }
            
            .image-block-class .multi-image-container .yetti-popup-wrapper:nth-last-child(-n+2){
                //background: #000;
            }

            .image-block-class .multi-image-container .yetti-popup-wrapper:nth-last-child(-n+2) .yetti-popup-body{
                width: 100% !important;
                left: 50% !important;
            }

            .image-block-class .multi-image-container .yetti-popup-wrapper:nth-of-type(2n) .yetti-popup-body{
                width: 340px !important;
                left: -7px !important;
            }
        }
    </style>
    <div class="multi-image-container {{ empty($this->blocks) ? 'hidden' : '' }}" wire:sortable="sort">
        @foreach($this->blocks as $index => $item)

            <script>
                function mixing() {
                    return {
                        popup: false,
                        open() {
                            this.$wire.clear_thumb();
                            this.popup = true;
                        },
                        close() {
                            this.$wire.clear_thumb();
                            this.popup = false;
                        },
                    }
                }

                document.addEventListener("link-block-{{ ao($item, 'id') }}", function (e) {
                    window.livewire.emit('useElement', {
                        'id': e.detail.id,
                        'index': {{ $index }},
                        'block_id': {{ $this->block_id }}
                    });
                });

            </script>
            @php
                $item = json_decode(json_encode($item));
            @endphp

            <div class="yetti-popup-wrapper inner-image-container" x-data="mixing"
                wire:sortable.item="{{ ao($item, 'id') }}"
                wire:key="image-blocks-{{ ao($item, 'id') }}">


                <div class="inner-image">
                    <div class="thumbnail">
                        <?= media_or_url($item->thumbnail, 'media/blocks', true) ?>
                    </div>
                    @if (!empty(ao($item->content, 'caption')))
                        <h2 class="image-title"><?= clean(ao($item->content, 'caption'), 'titles') ?></h2>
                    @endif


                    <div class="link-out w-auto mort-main-bg p-2 top-2 right-2 gap-4">

                        <p class="drag mr-0 handle pointer-events-auto cursor-pointer" wire:sortable.handle>
                            <i class="sni sni-move text-black"></i>
                        </p>
                        <a class="ml-auto pointer-events-auto cursor-pointer" x-on:click="open">
                            <i class="sni sni-pen text-black"></i>
                        </a>
                        <button class="pointer-events-auto cursor-pointer" wire:click="delete_block({{ ao($item, 'id') }})">
                            <i class="sni sni-trash text-black"></i>
                        </button>
                    </div>
                    <span class="fancy-drop"></span>
                </div>
                
                <div class="yetti-popup" :class="popup ? 'active' : ''">
                    <div class="yetti-popup-body">
                        <div class="flex items-center mb-5">
                            <div class="text-lg font-bold mr-auto"><?= __('EDIT LIST') ?></div>
                            <button class="yetti-popup-close flex items-center justify-center" x-on:click="close">
                                <?= svg_i('close-1', 'icon') ?>
                            </button>
                        </div>
                        <form class="m-0"
                            wire:submit.prevent="edit({{ ao($item, 'id') }}, {{ $index }})"
                            enctype="multipart/form-data">
                            @error("thumbnail")
                                <p class="text-xs text-red-400 mb-5">
                                    <span class="error">{{ $message }}</span>
                                </p>
                            @enderror

                            <div class="wj-image-selector-w is-avatar relative active">
                                <a class="wj-image-selector-trigger rounded-xl flex items-center relative">
                                    <div class="wj-image-container inline-flex items-center justify-center">
                                        @php
                                            $thumb = media_or_url($item->thumbnail, 'media/blocks');

                                            if($thumbnail){
                                            $thumb = $thumbnail->temporaryUrl();
                                            }
                                        @endphp

                                        <img src="{!! $thumb !!}" alt="">
                                    </div>
                                    <div class="wj-image-selector-text ml-3 flex flex-col">
                                        <span
                                            class="wj-text-holder text-sm font-bold">{{ __('Upload a thumbnail') }}</span>
                                        <span
                                            class="font-8 font-bold uppercase">{{ __(':mb Max', ['mb' => '2mb']) }}</span>
                                    </div>

                                    <div wire:loading wire:target="thumbnail"
                                        class="text-xs font-bold m-0 absolute -bottom-6 left-0">
                                        {{ __('Processing image...') }}</div>
                                </a>

                                <input type="file" wire:model="thumbnail">
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-5">

                                <div class="form-input active">
                                    <label>{{ __('Image Caption') }}</label>
                                    <input type="text" wire:model.defer="blocks.{{ $index }}.content.caption">
                                </div>
                                <div class="form-input">
                                    <label>{{ __('Describe') }}</label>
                                    <input type="text" wire:model.defer="blocks.{{ $index }}.content.alt">
                                </div>
                            </div>


                            <div class="grid grid-cols-12 gap-3">
                            
                                <div class="form-input mt-5 col-span-10">
                                    <label><?= __('Link') ?></label>
                                    <input type="text" name="link" wire:model.defer="blocks.{{ $index }}.content.link" placeholder="{{ config('app.url') }}">
                                </div>
                                
                                <div class="col-span-2 flex items-end" wire:ignore>
                                    
                                    <div class="element-pickr-trigger sandy-expandable-btn w-full rounded-xl" data-event-id="link-block-{{ ao($item, 'id') }}"><span class="flex items-center justify-center">{!! orion('lightning-strike-1', 'w-5 h-5') !!}</span></div>
                                </div>
                            </div>

                            <button
                                class="sandy-expandable-btn mt-5 no-disabled-btn"><span><?= __('Save') ?></span></button>
                        </form>
                    </div>
                    <div class="yetti-popup-overlay" x-on:click="close"></div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="add-new-link my-5 sm">
        <button type="button" class="el-btn m-0" wire:click="add_new"><i class="sni sni-plus"></i></button>
    </div>
</div>
