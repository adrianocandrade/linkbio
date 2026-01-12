<div>
    @error('photos.*')
        
    <p class="text-xs text-red-400 mb-5">
        <span class="error">{{ $message }}</span>
    </p>
    @enderror


    <div class="flex overflow-x-auto gap-4 py-3">
        <div class="wj-image-selector-w is-120 is-overflow is-avatar relative" x-data="{ isUploading: false }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false">
            <a class="wj-image-selector-trigger rounded-xl m-0 py-5">
                <template x-if="!isUploading">
                    <div class="flex flex-col justify-between ">
                        
                        <div class="wj-image-container inline-flex items-center justify-center">
                            {!! orion('user-1', 'w-5 h-5') !!}
                            <img src="" alt="">
                        </div>
                        
                        <div class="wj-image-selector-text m-0">
                            <span
                                class="wj-text-holder text-xs font-bold">{{ __('Upload Portfolio') }}</span>
                        </div>
                    </div>
                </template>

                <template x-if="isUploading">
                    <div class="flex flex-col justify-between ">
                        
                        <div class="sandy-ball-loader load-icon">
                            <div class="ball ball-1"></div>
                            <div class="ball ball-2"></div>
                            <div class="ball ball-3"></div>
                            <div class="ball ball-4"></div>
                            <div class="ball ball-5"></div>
                            <div class="ball ball-6"></div>
                            <div class="ball ball-7"></div>
                            <div class="ball ball-8"></div>
                        </div>
                        
                        <div class="wj-image-selector-text m-0">
                            <span class="wj-text-holder text-xs font-bold">{{ __('Uploading Images...') }}</span>
                        </div>
                    </div>
                </template>
            </a>
            <input type="file" wire:model="photos" multiple accept="image/*">
        </div>

        @if (is_array($gallery = ao($this->user->booking, 'gallery')))
            @foreach ($gallery as $key => $value)
                
            <div class="small-card-images is-overflow">
                <a class="action-right cursor-pointer" wire:click="delete('{{ $value }}')">
                    {!! orion('bin-1', 'h-3 w-3 stroke-current') !!}
                </a>
                <div class="small-card-images-inner p-0 rounded-xl">
                    <img alt="" src="{{ gs('media/booking', $value) }}">
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>
