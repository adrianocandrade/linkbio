<div>
    
    <div class="{{ $this->services->isEmpty() ? '' : 'hidden' }}">
        <div class="flex flex-col mb-5">
          <img class="lozad w-20" alt="" src="{{ gs('assets/image/emoji/Yellow-1/Idea.png') }}">
          <div class="text-xl font-bold mt-5-">{{ __('No Service') }}</div>
          <div class="w-3/4 mt-3">
            <div class="text-sm text-gray-400">{{ __('Click the + icon to add a service.') }}</div>
          </div>
      </div>
    </div>


    <div class="gap-4 flex flex-col book-services mb-10 {{ $this->services->isEmpty() ? 'hidden' : '' }}" wire:sortable="sort">

        @foreach ($this->services as $index => $item)
        
            <script>
                function mixing() {
                    return {
                        popup: false,
                        open() {
                            this.popup = true;
                        },
                        close() {
                            this.popup = false;
                        },
                    }
                }

            </script>
            <div class="yetti-popup-wrapper" x-data="mixing"
            wire:sortable.item="{{ ao($item, 'id') }}"
            wire:key="services-mix-booking-{{ ao($item, 'id') }}">
                <div class="flex">
                    
                    <div class="flex mb-5 w-auto bg-gray-100 p-2 top-2 right-2 rounded-xl">

                        <p class="drag mr-0 handle pointer-events-auto cursor-pointer px-4" wire:sortable.handle>
                            <i class="sni sni-move text-black"></i>
                        </p>
                        <a class="ml-auto pointer-events-auto cursor-pointer px-4" x-on:click="open">
                            <i class="sni sni-pen text-black"></i>
                        </a>
                        <button class="pointer-events-auto cursor-pointer px-4" wire:click="delete({{ ao($item, 'id') }})">
                            <i class="sni sni-trash text-black"></i>
                        </button>
                    </div>
                </div>

                <div class="sandy-big-checkbox relative product-variation">
                    <div class="product-variation-inner m-0 border-0 book-service-group flex bg-gray-100">
                    <div class="flex flex-col">
                        
                        <div class="book-service-name text-black truncate">{{ $item->name }}</div>
                        <div class="text-xs font-bold">{!! Currency::symbol(ao($user->payments, 'currency')) . $item->price !!} + <span>{{ $item->duration }}</span> {{ __('min') }}</div>
                    </div>
                    </div>
                </div>

                
                <div class="yetti-popup" :class="popup ? 'active' : ''">
                    <div class="yetti-popup-body">
                        <div class="flex items-center mb-5">
                            <div class="text-lg font-bold mr-auto"><?= __('EDIT SERVICE') ?></div>
                            <button class="yetti-popup-close flex items-center justify-center" x-on:click="close">
                                <?= svg_i('close-1', 'icon') ?>
                            </button>
                        </div>
                        <form class="m-0"
                            wire:submit.prevent="edit({{ ao($item, 'id') }}, {{ $index }})">
                            <div class="mt-5 grid grid-cols-1 gap-4">
                                <div class="form-input active always-active">
                                    <label>{{ __('Service Name') }}</label>
                                    <input type="text" wire:model="services.{{ $index }}.name">
                                    @error("services.{$index}.name") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-input active always-active">
                                    <label>{{ __('Duration (minutes)') }}</label>
                                    <input type="number" wire:model="services.{{ $index }}.duration" min="1">
                                    @error("services.{$index}.duration") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-input active always-active">
                                    <label>{{ __('Service Price') }}</label>
                                    <input type="number" step="0.01" wire:model="services.{{ $index }}.price">
                                    @error("services.{$index}.price") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    <small class="text-gray-500 block mt-1">{{ __('Use -1 to display "Budget on-site" instead of price') }}</small>
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
      <div class="add-new-link sm">
        <button type="button" class="el-btn m-0 secondary-boxshadow bg-gray-50" wire:click="create"><i class="sni sni-plus"></i></button>
    </div>
</div>