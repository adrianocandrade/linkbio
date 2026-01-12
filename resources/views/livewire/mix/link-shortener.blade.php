<div>
    
		
        <div class="card p-5 rounded-2xl block has-sweet-container border-4 border-solid border-gray-200">
            <div class="card-container bg-repeat-right" style="background-image: url({{ gs('assets/image/others/scribbbles/48.png') }})">
                <div class="mt-5 text-2xl font-bold">{{ __('Shorten Links') }}</div>
                <div class="my-2 text-xs is-info w-44 mb-5">{{ __('Shorten links by transforming any url to a shorter version.') }}</div>


                @if (!$generated)
                    
                <form wire:submit.prevent="shorten" class="mr-14">
                        @if(!$errors->isEmpty())
                            @foreach ($errors->all() as $error)
                                
                            <p class="text-xs text-red-400 mb-5">
                                <span class="error">{{ $error }}</span>
                            </p>
                            @endforeach
                        @endif

                    <div class="form-input z-10 relative">
                        <label>{{ __('Enter link') }}</label>
                        <input type="text" wire:model.defer="link" class="text-black bg-w">
                    </div>
                    <button class="sandy-expandable-btn px-10 text-black mt-5 z-10 relative"><span>{{ __('Generate') }}</span></button>
                </form>
                @endif
                
                @if ($generated)
                    <div class="mr-14">
                        <hr>
                        <div class="mt-5 mb-2 text-sm font-bold">{{ __('Your link is ready') }}</div>
                        <div class="index-header-code flex-col items-start m-0">
                            <a class="index-header-number text-xs">{{ $shortened }}</a>
                         </div>

                         
                        <div class="cursor-pointer sandy-expandable-btn px-10 text-black mt-5 z-10 relative" data-copy="{{ $shortened }}" data-after-copy="{{ __('Copied') }}"><span>{{ __('Copy') }}</span></div>

                        <div>
                            
                        <button wire:click="restart" class="p-3 sandy-expandable-btn text-black mt-5 z-10 relative rounded-xl"><span class="px-0 h-full flex items-center justify-center">{!! orion('edit-3', 'w-3 h-3') !!}</span></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <script>
            
          document.addEventListener('livewire:load', function () {
            @this.on('changed_state', () => {
                Object.values(app.utils).filter(s => typeof s === 'function').forEach(s => s());
            });
          });
        </script>
</div>
