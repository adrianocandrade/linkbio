<div>

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


                init(){

                    var _this = this;
                    
                    this.$nextTick(() => {
                        var month_picker = this.$refs.month_picker;
                        
                        jQuery(month_picker).datepicker({
                            language: 'en',
                            dateFormat: 'yyyy-mm-dd',
                            autoClose: true,
                            timepicker: false,
                            toggleSelected: false,
                            inline: false,
                            range: true,
                            startDate: new Date(),
                            onSelect: (formatted_date, date) => {
                                if (date.length > 1) {
                                    let [start_date, end_date] = formatted_date.split(',');
                                    if (typeof end_date == 'undefined') {
                                        end_date = start_date
                                    }
                                    /* Redirect */
                                }
                                
                                this.$wire.break_date = formatted_date;
                            }
                        });

                    });
                },
            }
        }

    </script>


    @php
        print_r($mee);
    @endphp

    <div class="custom-day-work-periods yetti-popup-wrapper" x-data="mixing">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div>

                <a class="add-custom-day-w w-full cursor-pointer breaks-opesn" x-on:click="open">
                    <div class="add-custom-day-i">
                        <div class="add-day-graphic-w">
                            <div class="add-day-plus items-center justify-center flex">
                                <svg class="svg-icon orion-svg-icon w-5 h-5 stroke-current text-white">
                                    <use xlink:href="https://barber.test/assets/image/svg/orion-svg-sprite.svg#add-1">
                                    </use>
                                </svg>
                            </div>
                        </div>
                        <div class="add-day-label">{{ __('Add Break') }}</div>
                    </div>
                </a>
            </div>
        </div>






        <div class="yetti-popup" :class="popup ? 'active' : ''">
            <div class="yetti-popup-body">
                <div class="flex items-center mb-5">
                    <div class="text-lg font-bold mr-auto"><?= __('ADD BREAK') ?></div>
                    <button class="yetti-popup-close flex items-center justify-center" x-on:click="close">
                        <?= svg_i('close-1', 'icon') ?>
                    </button>
                </div>

                <form wire:submit.prevent="create" method="post">
                    @csrf


                    @if(!$errors->isEmpty())
                        @foreach($errors->all() as $error)
                            <p class="text-xs text-red-400 mb-5">
                                <span class="error">{{ $error }}</span>
                            </p>
                        @endforeach
                    @endif

                    <div class="form-input" wire:ignore>
                        <label for="" class="initial">{{ __('Date') }}</label>

                        <input type="text" autocomplete="off" wire:model.defer="break_date" x-ref="month_picker">
                    </div>

                    <div class="ws-period mt-5 mb-0">
                        <div class="wj-time-group wj-time-input-w as-period">
                            <label for="break-start">{{ __('Start') }}</label>

                            <div class="wj-time-input-fields">
                                <input type="text" placeholder="HH:MM" id="break-start"
                                    class="wj-form-control wj-mask-time hourpicker w-44 max-w-full"
                                    wire:model.defer="break_start_time">
                            </div>
                        </div>

                        <div class="wj-time-group wj-time-input-w as-period">
                            <label for="break-end">{{ __('Finish') }}</label>

                            <div class="wj-time-input-fields">
                                <input type="text" placeholder="HH:MM" id="break-end"
                                    class="wj-form-control wj-mask-time hourpicker w-44 max-w-full"
                                    wire:model.defer="break_end_time">
                            </div>
                        </div>
                    </div>

                    <button class="sandy-expandable-btn mt-5 no-disabled-btn"><span><?= __('Save') ?></span></button>
                </form>
                </form>
            </div>
            <div class="yetti-popup-overlay" x-on:click="close"></div>
        </div>
    </div>


    

    <div class="add-new-link sm">
        <button type="button" class="el-btn m-0 secondary-boxshadow bg-gray-50" wire:click="create"><i
                class="sni sni-plus"></i></button>
    </div>
</div>
