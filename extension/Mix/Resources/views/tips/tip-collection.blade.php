@extends('mix::layouts.master')
@section('title', __('Tips'))
@section('content')
<div class="flex justify-between align-end items-center p-8 md:p-14 mort-main-bg">
    <div class="flex align-center">
        <div class="color-primary flex flex-col">
            <span class="font-bold text-lg mb-1">{{ __('Tips') }}</span>
            <span class="text-xs text-gray-400">{{ __('View all tip collections and notes.') }}</span>
        </div>
    </div>
</div>
<div class="wallet-transactions mt-10 mix-padding-10 pt-0">
    @foreach ($tips as $item)
    <div class="mort-main-bg rounded-2xl mb-5">
        <div class="wallet-transactions-item cursor-default p-5">
            <div class="wallet-transactions-details truncate">
                @if ($payee = \App\User::find($item->payee_user_id))
                <div class="transaction-avatar rounded-xl">
                    {!! avatar($payee->id, true) !!}
                </div>
                <div class="transaction-title flex flex-col justify-between truncate">
                    <span class="transaction-name truncate"> {{ $payee->name }}</span>
                    <span class="transaction-date text-gray-500 uppercase truncate">{{ $payee->email }}</span>
                </div>
                @endif
            </div>
            <div class="transaction-amount flex items-center">
                <div class="transaction-price negative">{!! price_with_cur($item->currency, $item->amount) !!}</div>
            </div>
        </div>
        @if (!empty(ao($item->info, 'note')))
        <div class="px-5 pt-0">
            <div class="divider my-5 mt-3"></div>
            <span class="text-xs text-gray-400 mt-4">{{ ao($item->info, 'note') }}</span>
        </div>
        @endif

    
        <div class="px-5 pb-5">
            <span class="font-10 uppercase">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
            
        </div>        
    </div>
    @endforeach
</div>
@endsection