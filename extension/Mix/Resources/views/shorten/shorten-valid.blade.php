@extends('mix::layouts.master')
@section('content')
<div class="mix-padding-10">
    <div class="rounded-2xl card-shadow p-5 has-cta-bg-shade mt-32" bg-style="rgb(215 218 220)">
        <div class="cta-background-shade">
            <img src="{{ gs('assets/image/others/index-cta-bg.png') }}" alt="">
        </div>
        <div class="z-10 relative">
            
            
            <div class="px-5 text-center">
                
                <p class="text-base mb-4">{{ __('Your link is ready!') }}</p>
                <div class="the-link mt-4">
                    {{ $linker }}
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-5">
                <a class="button shadow-none text-black bg-white rounded-xl" data-copy="{{ $linker }}" data-after-copy="{{ __('Copied') }}">{{ __('Copy') }}</a>
                <a class="button rounded-xl shadow-none" href="{{ $linker }}" target="_blank">{{ __('Open') }}</a>
            </div>
        </div>
    </div>
    
</div>
@endsection