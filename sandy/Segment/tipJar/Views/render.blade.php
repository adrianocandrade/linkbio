@extends('bio::layouts.master')
@section('content')
@section('head')
<style>
.tip h1{
font-size: 22px;
font-style: normal;
font-weight: bold;
margin-bottom: 4px;
color: inherit;
}
.context-body{
border-radius: 0 !important;
background: transparent !important;
position: relative;
}
.context-body .tip{
padding: 20px 32px;
border-radius: 10px;
display: block;
position: absolute;
bottom: 0;
width: 100%;
background: rgba(255, 255, 255, 0.62);
}
@@supports ((-webkit-backdrop-filter: none) or (backdrop-filter: none)) {
    .context-body .tip {
        -webkit-backdrop-filter: blur(4px);
        backdrop-filter: blur(4px);
    }
}
</style>
@stop

@section('footerJS')
    <script>
        function suggest_price() {
            return {
                amount: '0',
                
                change_amount: function(price){
                    this.amount = price;
                }
            }
        }
        
    </script>
@stop
@section('is_element', true)
<!--
<div class="sm:grid sm:grid-cols-1 gap-4 hidden">
    
    <div class="form-input is-link mb-5 always-active active">
        <label>{{ __('Amount') }}</label>
        <div class="is-link-inner">
            <div class="side-info">
                <p>$</p>
            </div>
            <input type="number" class="bg-white" :value="amount" name="amount">
        </div>
    </div>
</div> -->
<div class="context bio is-element is-element-wrapper {!! radius_and_align_class($bio->id, 'align') !!}">
    <div class="context-head pt-10">
        <div class="avatar-thumb relative z-10 mb-5">
            <div class="avatar-container">
                <a href="/<?= e(config('app.bio_prefix')) ?><?= $bio->username ?>">
                    <div class="thumb" style="background: {{ao($bio->settings, 'avatar_color')}}">
                        {!! avatar($bio->id, true) !!}
                    </div>
                </a>
            </div>
            <div class="bio-info-container">
                <div class="bio-name-text theme-text-color flex">
                    {{ $bio->name }}
                    {!! user_verified($bio->id) !!}
                </div>
                <div class="bio-username-text theme-text-color">
                    {{ '@' . $bio->username }}
                </div>
            </div>
        </div>
    </div>
    <div class="context-element-body w-full mt-10 pb-0 relative" x-data="suggest_price()">
        <form class="tip" method="post" action="{{ route('sandy-app-tipJar-tip-user', $element->slug) }}">
            @csrf
            <h1 class="font-bold mb-2">{{ $element->name }}</h1>
            <div class="mb-10 text-sm text-gray-400">{{ ao($element->content, 'description') }}</div>
            <div class="grid grid-cols-2 gap-4 mb-10">
                @if (is_array(ao($element->content, 'amounts')))
                @foreach (ao($element->content, 'amounts') as $key => $item)
                <a class="button h-12 rounded-xl text-black" @click="change_amount('{{ ao($item, 'price') }}')" bg-style="#f7f6f6">{!! Currency::symbol(ao($bio->payments, 'currency')) . ao($item, 'price') !!}</a>
                @endforeach
                @endif
            </div>
            <div class="currency-payment is-price mb-5">
                <div class="currency-sign h4"><?= Currency::symbol(ao($bio->payments, 'currency')) ?></div>
                <div class="currency-field w-full">
                    <div class="currency-value" x-text="amount">0</div>
                    <input class="currency-input" type="text" autofocus="" name="amount" value="0" :value="amount">
                </div>
            </div>
            <div class="form-input">
                <label>{{ __('Leave a Note') }}</label>
                <textarea name="note" rows="5" class="bg-w"></textarea>
            </div>
            <div class="form-input mb-5">
                <label>{{ __('Your Email *') }}</label>
                <input type="text" name="email" class="bg-w">
            </div>

            <div class="font-bold text-sm my-5">{{ __('Payment Type') }}</div>

            <div class="grid mt-5 grid-cols-2 gap-4">
                <label class="sandy-big-radio">
                    <input type="radio" name="payment_type" value="onetime" checked class="custom-control-input">
                    <div class="radio-select-inner min-h-full rounded-xl flex items-center" bg-style="#f7f6f6">
                        <div class="active-dot"></div>
                        <h1 class="text-lg">{{ __('One time') }}</h1>
                    </div>
                </label>
                <label class="sandy-big-radio">
                    <input type="radio" name="payment_type" value="recurring" class="custom-control-input">
                    <div class="radio-select-inner min-h-full rounded-xl flex items-center" bg-style="#f7f6f6">
                        <div class="active-dot"></div>
                        <h1 class="text-lg">{{ __('Monthly') }}</h1>
                    </div>
                </label>
            </div>
            
            <button class="button sandy-loader-flower w-full mt-5">{{ __('Send tip') }}</button>
        </form>
    </div>
</div>
@endsection