<div>
    <div class="{{ empty($this->blocks) ? '' : 'hidden' }}">
        @include('include.empty-block-mix')
    </div>

    <div class="yetti-links-wrapper {{ empty($this->blocks) ? 'hidden' : '' }}" wire:sortable="sort">
        @foreach ($this->blocks as $index => $item)

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
        
        <div class="yetti-popup-wrapper" x-data="mixing" wire:sortable.item="{{ ao($item, 'id') }}" wire:key="link-blocks{{ ao($item, 'id') }}">

        

            <div class="yetti-links-v2 transition-none flex">
                @if (!empty(ao($item, 'thumbnail.upload')) && mediaExists('media/blocks', ao($item, 'thumbnail.upload')))
                    
                <div class="thumbnail-preview">
                    {!! media_or_url(ao($item, 'thumbnail'), 'media/blocks', true) !!}
                </div>
                @endif
                <div class="yetti-links-v2-inner is-edit">
                    <span>{{ ao($item, 'content.heading') }}</span>
                    <div class="flex items-center">

                        <p class="drag mr-5 cursor-pointer" wire:sortable.handle>
                            <i class="sni sni-move"></i>
                        </p>
                        <a class="ml-auto mr-5" x-on:click="open">
                            <i class="sni sni-pen"></i>
                        </a>
                        <button wire:click="delete_block({{ ao($item, 'id') }})">
                            <i class="sni sni-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="yetti-popup" :class="popup ? 'active' : ''">
                <div class="yetti-popup-body">
                    <div class="flex items-center mb-5">
                        <div class="text-lg font-bold mr-auto"><?= __('EDIT LINK') ?></div>
                        <button class="yetti-popup-close flex items-center justify-center" x-on:click="close">
                            <?= svg_i('close-1', 'icon') ?>
                        </button>
                    </div>


                    <form class="m-0" wire:submit.prevent="edit({{ ao($item, 'id') }}, {{ $index }})" enctype="multipart/form-data">
                        @error("thumbnail")
                            <p class="text-xs text-red-400 mb-5">
                                <span class="error">{{ $message }}</span>
                            </p>
                        @enderror

                        <div class="wj-image-selector-w is-avatar relative active">
                            <a class="wj-image-selector-trigger rounded-xl flex items-center relative">
                                <div class="wj-image-container inline-flex items-center justify-center">
                                    @php
                                        $thumb = media_or_url(ao($item, 'thumbnail'), 'media/blocks');

                                        if($thumbnail){
                                        $thumb = $thumbnail->temporaryUrl();
                                        }
                                    @endphp

                                    <img src="{!! $thumb !!}" alt="">
                                </div>
                                <div class="wj-image-selector-text ml-3 flex flex-col">
                                    <span
                                        class="wj-text-holder text-sm font-bold">{{ __('Upload a thumbnail') }}</span>
                                    <span class="font-8 font-bold uppercase">{{ __(':mb Max', ['mb' => '2mb']) }}</span>
                                </div>

                                <div wire:loading wire:target="thumbnail"
                                    class="text-xs font-bold m-0 absolute -bottom-6 left-0">
                                    {{ __('Updating image...') }}</div>
                            </a>

                            <input type="file" wire:model="thumbnail" wire:change="changed_thumb({{ ao($item, 'id') }})">
                        </div>

                        <div class="form-input">
                            <label><?= __('Name') ?></label>
                            <input type="text" name="name" wire:model.defer="blocks.{{ $index }}.content.heading">
                        </div>

                        <div class="grid grid-cols-12 gap-3">
                            
                            <div class="form-input mt-5 col-span-10">
                                <label><?= __('Link') ?></label>
                                <input type="text" name="link" wire:model.defer="blocks.{{ $index }}.content.link">
                            </div>
                            
                            <div class="col-span-2 flex items-end" wire:ignore>
                                
                                <div class="element-pickr-trigger sandy-expandable-btn w-full rounded-xl" data-event-id="link-block-{{ ao($item, 'id') }}"><span class="flex items-center justify-center">{!! orion('lightning-strike-1', 'w-5 h-5') !!}</span></div>
                            </div>
                        </div>

                        <button class="sandy-expandable-btn mt-5 no-disabled-btn"><span><?= __('Save') ?></span></button>
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