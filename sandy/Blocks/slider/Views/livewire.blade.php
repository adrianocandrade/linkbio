<div>

    <style>
        .yetti-popup{
            top: 15% !important;
        }

        .bio-swiper-container .card-infos{
            height: initial !important;
        }
    </style>

    <div class="{{ empty($this->blocks) ? '' : 'hidden' }}">
        @include('include.empty-block-mix')
    </div>

    <div class="bio-swiper-container {{ empty($this->blocks) ? 'hidden' : '' }}">
        <div class="bio-swiper-wrapper overflow-initial-">
            <div class="bio-swiper-slide overflow-initial-" wire:sortable="sort">
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
        
                    </script>
                    @php
                        $item = json_decode(json_encode($item));
                    @endphp
        
                    <div class="yetti-popup-wrapper swiper-item" x-data="mixing" wire:sortable.item="{{ ao($item, 'id') }}"
                    wire:key="slider-blocks-{{ ao($item, 'id') }}">
                        <div class="flex">
                            
                            <div class="w-auto flex p-2 rounded-lg mb-2 bg-gray-200">
                                

                                <p class="drag mr-0 handle pointer-events-auto cursor-pointer px-3" wire:sortable.handle>
                                    <i class="sni sni-move text-black"></i>
                                </p>
                                <a class="ml-auto pointer-events-auto cursor-pointer px-3" x-on:click="open">
                                    <i class="sni sni-pen text-black"></i>
                                </a>
                                <button class="pointer-events-auto cursor-pointer px-3" wire:click="delete_block({{ ao($item, 'id') }})">
                                    <i class="sni sni-trash text-black"></i>
                                </button>
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
                                    <div class="grid grid-cols-1 gap-4 mb-5">

                                        <div class="form-input active">
                                            <label>{{ __('Image Caption') }}</label>
                                            <input type="text" wire:model.defer="blocks.{{ $index }}.content.heading">
                                        </div>
                                    </div>

                                    <button class="sandy-expandable-btn mt-5 no-disabled-btn"><span><?= __('Save') ?></span></button>
                                </form>
                            </div>
                            <div class="yetti-popup-overlay" x-on:click="close"></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="bio-slider-arrows hidden">
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
        <button type="button" class="el-btn m-0" wire:click="add_new"><i class="sni sni-plus"></i></button>
    </div>
</div>
