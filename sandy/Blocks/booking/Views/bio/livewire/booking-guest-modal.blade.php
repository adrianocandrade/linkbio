{{-- Modal de Cadastro Rápido para Clientes --}}
@if($showGuestModal)
<div class="fixed inset-0 z-40 overflow-y-auto" style="display: block;">
    
    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" 
         wire:click="$set('showGuestModal', false)"></div>
    
    {{-- Modal Content --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-3xl shadow-xl max-w-md w-full p-8 transform transition-all z-50 dialog-content"
             onclick="event.stopPropagation()">
            
            {{-- Close Button --}}
            <button wire:click="$set('showGuestModal', false)" 
                    class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 z-10">
                <i class="la la-times text-2xl"></i>
            </button>
            
            {{-- Header --}}
            <div class="mb-8 text-center relative">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                    {{ __('Complete your Reservation') }}
                </h3>
            </div>
            
            {{-- Form --}}
            <form wire:submit.prevent="completeBookingAsGuest" class="form space-y-4">
                
                {{-- Name --}}
                <div class="form-row">
                    <div class="form-item">
                        <div class="form-input">
                            <label for="guestName">{{ __('Full Name') }}</label>
                            <input type="text" 
                                   id="guestName"
                                   wire:model.defer="guestName" 
                                   class="@error('guestName') is-invalid @enderror"
                                   required>
                            @error('guestName')
                                <span class="invalid-feedback text-left" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                {{-- Email --}}
                <div class="form-row">
                    <div class="form-item">
                        <div class="form-input">
                            <label for="guestEmail">{{ __('Email') }}</label>
                            <input type="email" 
                                   id="guestEmail"
                                   wire:model.defer="guestEmail" 
                                   class="@error('guestEmail') is-invalid @enderror"
                                   required>
                            @error('guestEmail')
                                <span class="invalid-feedback text-left" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                {{-- Phone --}}
                <div class="form-row">
                    <div class="form-item">
                        <div class="form-input">
                            <label for="guestPhoneInput">{{ __('Phone') }}</label>
                            <input type="tel" 
                                   id="guestPhoneInput"
                                   wire:model.defer="guestPhone" 
                                   class="@error('guestPhone') is-invalid @enderror"
                                   maxlength="15"
                                   required
                                   x-data
                                   x-mask="(99) 99999-9999">
                            @error('guestPhone')
                                <span class="invalid-feedback text-left" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                {{-- Submit Button --}}
                <div class="form-row mt-8">
                    <div class="form-item">
                        <button type="submit" 
                                class="shadow-none w-full button bg-gray-200 text-black sandy-loader-flower h-14 rounded-xl font-bold text-lg pl-5 pr-5"
                                wire:loading.attr="disabled"
                                wire:target="completeBookingAsGuest">
                            <span wire:loading.remove wire:target="completeBookingAsGuest">
                                {{ __('Confirm Reservation') }}
                            </span>
                            <span wire:loading wire:target="completeBookingAsGuest" style="display: none;" class="flex items-center justify-center">
                                <i class="la la-spinner la-spin mr-2"></i>
                                {{ __('Processing...') }}
                            </span>
                        </button>
                    </div>
                </div>

                {{-- Cancel Link --}}
                <div class="flex justify-center mt-6">
                    <a href="#" wire:click.prevent="$set('showGuestModal', false)" class="auth-link text-sm font-bold text-gray-500 hover:text-gray-800">
                        {{ __('Cancel') }}
                    </a>
                </div>

            </form>
            
        </div>
    </div>
</div>

<script>
// Máscara de telefone brasileira
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('guestPhoneInput');
    
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length <= 10) {
                // Formato: (11) 2222-2222
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
            } else {
                // Formato: (11) 99999-9999
                value = value.replace(/^(\d{2})(\d{5})(\d{0,4}).*/, '($1) $2-$3');
            }
            
            e.target.value = value;
        });
    }
});

// Reaplica máscara quando Livewire atualiza
document.addEventListener('livewire:load', function() {
    Livewire.hook('message.processed', (message, component) => {
        const phoneInput = document.getElementById('guestPhoneInput');
        if (phoneInput) {
            phoneInput.dispatchEvent(new Event('input'));
        }
    });
});
</script>
@endif
