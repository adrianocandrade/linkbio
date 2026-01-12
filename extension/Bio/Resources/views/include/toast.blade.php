<script>
    function close_payment_success(){
        return {
            close_it: function(){
                document.querySelector('.sandy-bio-toast').remove();
            }
        }
    }
</script>

@if ($message = Session::get('payment_success'))
    <div class="sandy-dialog-modal payment-successful sandy-bio-toast" x-data="close_payment_success()">
        <div class="rounded-3xl small sandy-dialog block">
            <div class="text-center flex justify-center flex-col items-center">
                <img data-src="{{ \Bio::emoji('Star_Struck') }}" class="lozad w-20" alt="">
                <div class="text-lg font-bold">{{ __('Payment Success') }}</div>
                
                <div class="w-3/4 mt-3">
                    <div class="text-xs text-gray-400">{{ ao($message, 'response') }}</div>
                </div>
                <div class="sandy-expandable-block mt-5 w-full">
                    <h4 class="sandy-expandable-header">
                    <div class="text-left">
                        <h4 class="sandy-expandable-title">{{ ao($message, 'item.name') }}</h4>
                        <p class="sandy-expandable-description">{!! ao($message, 'item.description') !!}</p>
                    </div>
                    </h4>
                </div>
                <a class="mt-5 shadow-none w-full button bg-gray-200 text-black toast-custom-close" @click="close_it()">{{ __('Done') }}</a>
            </div>
        </div>
    </div>
@endif


@if ($message = Session::get('bio_error'))
    <div class="sandy-dialog-modal payment-successful sandy-bio-toast">
        <div class="rounded-3xl small sandy-dialog block">
            <div class="text-center flex justify-center flex-col items-center">
                <img data-src="{{ \Bio::emoji('Sneezing_Face') }}" class="lozad w-20" alt="">
                <div class="text-lg font-bold">{{ ao($message, 'error') }}</div>
                
                <div class="w-3/4 mt-3">
                    <div class="text-xs text-gray-400">{{ ao($message, 'response') }}</div>
                </div>

                @if (ao($message, 'item'))
                <div class="sandy-expandable-block mt-5 w-full">
                    <h4 class="sandy-expandable-header">
                    <div class="text-left">
                        <h4 class="sandy-expandable-title">{{ ao($message, 'item.name') }}</h4>
                        <p class="sandy-expandable-description">{{ ao($message, 'item.description') }}</p>
                    </div>
                    </h4>
                </div>
                @endif
                <a class="mt-5 shadow-none w-full button bg-gray-200 text-black toast-custom-close">{{ __('Close') }}</a>
            </div>
        </div>
    </div>
@endif