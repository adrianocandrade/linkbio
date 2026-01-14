<div>
    @php
        //print_r($service);
    @endphp

    <form wire:submit.prevent="createBooking" >
        
  
        @if(!$errors->isEmpty())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-600 mb-1 flex items-center">
                        <i class="la la-exclamation-circle mr-2"></i>
                        <span>{{ $error }}</span>
                    </p>
                @endforeach
            </div>
        @endif

        @if (session()->has('success'))
            <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-600 flex items-center">
                    <i class="la la-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </p>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-sm text-red-600 flex items-center">
                    <i class="la la-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </p>
            </div>
        @endif

        @if($this->services->isEmpty())
            <div class="mb-5 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-600 flex items-center">
                    <i class="la la-exclamation-triangle mr-2 text-lg"></i>
                    <span>{{ __('No services available. Please contact the service provider.') }}</span>
                </p>
            </div>
        @endif

        @foreach($this->services as $item)

            <label class="sandy-big-checkbox relative product-variation mt-5">

                <input type="checkbox" wire:model.defer="service" value="{{ $item->id }}" class="sandy-input-inner">
                <div class="product-variation-inner m-0 border-0 book-service-group flex">
                    <div class="flex flex-col">

                        <div class="book-service-name truncate">{{ $item->name }}</div>
                        <div class="text-xs font-bold">
                            @if($item->price == -1)
                                {{ __('Budget on-site') }}
                            @else
                                {!! $sandy->price($item->price) !!}
                            @endif
                             + <span>{{ $item->duration }}</span>
                            {{ __('min') }}</div>
                    </div>
                </div>
            </label>
        @endforeach


        <div class="daily-agent-monthly-calendar-w horizontal-calendar mb-0 md:mb-5 mt-5" 
             x-data="{ 
                scrollAmt: 0,
                canScrollLeft: false,
                canScrollRight: true, 
                scroll(amount) {
                    $refs.container.scrollBy({ left: amount, behavior: 'smooth' });
                    setTimeout(() => this.updateScrollState(), 500);
                },
                updateScrollState() {
                    this.canScrollLeft = $refs.container.scrollLeft > 0;
                    this.canScrollRight = $refs.container.scrollLeft + $refs.container.clientWidth < $refs.container.scrollWidth;
                }
             }" 
             x-init="updateScrollState(); $refs.container.addEventListener('scroll', () => updateScrollState())"
             style="position: relative;">

            <!-- Arrow Left -->
            <button type="button" 
                    @click="scroll(-200)" 
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-lg rounded-full p-2 hover:bg-gray-100 transition-all focus:outline-none hidden md:flex"
                    style="left: -15px;"
                    x-show="canScrollLeft"
                    x-transition>
                <i class="la la-chevron-left"></i>
            </button>

            <!-- Arrow Right -->
            <button type="button" 
                    @click="scroll(200)" 
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-lg rounded-full p-2 hover:bg-gray-100 transition-all focus:outline-none hidden md:flex"
                    style="right: -15px;"
                    x-show="canScrollRight"
                    x-transition>
                <i class="la la-chevron-right"></i>
            </button>


            <div x-ref="container" class="snd-months overflow-x-auto mx-0 bg-transparent no-scrollbar" style="overflow-x: auto !important; overflow-y: hidden !important; -webkit-overflow-scrolling: touch; scrollbar-width: none;">
                <div class="snd-monthly-calendar-days-w block" style="overflow: visible; width: 100%;">
                    <div class="snd-monthly-calendar-days" style="min-width: max-content; display: flex; flex-wrap: nowrap;">
                        @foreach($this->dates as $key => $value)
                            @php
                                $dateValue = ao($value, 'date');
                                $isPast = \Carbon\Carbon::parse($dateValue)->isPast() && !\Carbon\Carbon::parse($dateValue)->isToday();
                                $isSelected = $date->format('Y-m-d') == $dateValue;
                                $isDisabled = ao($value, 'date_status') || $isPast;
                            @endphp
                            
                            <div class="snd-day snd-day-current week-day-5 is-f rounded-xl {{ $isSelected ? 'selected' : '' }} {{ $isDisabled ? 'disabled cursor-default opacity-50': '' }}" 
                                 @if(!$isDisabled) wire:click="setTimes('{{ $dateValue }}')" @endif
                                 @if($isPast) title="{{ __('Past dates are not available') }}" @endif>
                                <div class="snd-day-weekday no-disabled-btn">{{ ao($value, 'week') }}</div>
                                <div class="snd-day-box w-full no-disabled-btn outline-none outline-0">
                                    <div class="snd-day-number">{{ ao($value, 'day') }}</div>
                                    <div class="day-status snd-day-status w-1 rounded-full m-auto"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @if(!$date_status)

            <div class="flex flex-col">
                {!! orion('clock-1', 'w-20 h-20 mb-3') !!}

                <div class="text-xl font-bold mt-5-">{{ __('This date is not active') }}</div>
            </div>

        @else
            @if(empty($this->times))
                <div class="mb-5 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-600 flex items-center">
                        <i class="la la-clock mr-2 text-lg"></i>
                        <span>{{ __('No time slots available for this date.') }}</span>
                    </p>
                </div>
            @else
                <div class="relative" 
                     x-data="{ 
                        scrollAmt: 0, 
                        canScrollLeft: false, 
                        canScrollRight: true,
                        scroll(amount) {
                            $refs.container.scrollBy({ left: amount, behavior: 'smooth' });
                            setTimeout(() => this.updateScrollState(), 500);
                        },
                        updateScrollState() {
                            this.canScrollLeft = $refs.container.scrollLeft > 0;
                            this.canScrollRight = $refs.container.scrollLeft + $refs.container.clientWidth < $refs.container.scrollWidth;
                        }
                     }" 
                     x-init="updateScrollState(); $refs.container.addEventListener('scroll', () => updateScrollState())">
                     
                    <!-- Arrow Left -->
                    <button type="button" 
                            @click="scroll(-200)" 
                            class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-lg rounded-full p-2 hover:bg-gray-100 transition-all focus:outline-none hidden md:flex"
                            style="left: -15px;"
                            x-show="canScrollLeft"
                            x-transition>
                        <i class="la la-chevron-left"></i>
                    </button>

                    <!-- Arrow Right -->
                    <button type="button" 
                            @click="scroll(200)" 
                            class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-lg rounded-full p-2 hover:bg-gray-100 transition-all focus:outline-none hidden md:flex"
                            style="right: -15px;"
                            x-show="canScrollRight"
                            x-transition>
                        <i class="la la-chevron-right"></i>
                    </button>

                    <div x-ref="container" class="time-slots-flex flex overflow-x-auto gap-2 no-scrollbar" style="scrollbar-width: none;">
                        @foreach($this->times as $key => $value)
                            @php
                                $isDisabled = ao($value, 'check');
                                $tooltipText = $isDisabled ? __('This time slot is not available') : '';
                            @endphp
                            <div class="time_group my-0 pt-0" style="flex: 0 0 auto;">
                                <div class="btn-group w-full">
                                    <label class="sandy-big-checkbox relative is-sandy-datepicker" 
                                           @if($isDisabled) title="{{ $tooltipText }}" @endif>
                                        <input type="radio" name="booking_time" class="sandy-input-inner" wire:model.defer="time"
                                            value="{{ ao($value, 'time_value') }}"
                                            {{ $isDisabled ? 'disabled' : '' }}>
                                        <div class="sandy-expandable-btn m-0 time-btn rounded-full w-full {{ $isDisabled ? 'disabled' : '' }}">
                                            <span>{{ ao($value, 'start_time') }}</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif





        <button type="submit" class="button mt-5 rounded-lg h-10 pl-5 pr-5">
    <span wire:loading.remove wire:target="createBooking">{{ __('Book Now') }}</span>

    <span wire:loading wire:target="createBooking">
        <span class="flex items-center">
            <i class="la la-spinner la-spin mr-2"></i>
            {{ __('Processing...') }}
        </span>
    </span>
</button>

    </form>
    
    {{-- Modal de Cadastro de Cliente --}}
    @include('Blocks-booking::bio.livewire.booking-guest-modal')
</div>
