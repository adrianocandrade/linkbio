@extends('admin::layouts.master')
@section('title', __('All Payments'))
@section('namespace', 'admin-payments')
@section('content')
<div class="step-banner">
    <div class="section-header">
        <div class="section-header-info">
            <p class="section-pretitle">{{ __('Payments') }} ({{ count($payments) }})</p>
            <h2 class="section-title">{{ __('All Payments') }}</h2>
        </div>
        <div class="section-header-actions">
            <div class="notifications__tags">
                <a class="notifications__link active" href="{{ route('admin-payments-pending') }}">{{ __('View Pending Payment') }} ({{ $pendingCount }})</a>
            </div>
        </div>
        
    </div>
    <form class="search__form w-full mt-5" method="GET">
        <input class="search__input" type="text" name="email" placeholder="{{ __('Search by email') }}" value="{{ request()->get('email') }}">
        <button class="search__btn">
        <svg class="icon icon-search">
            <use xlink:href="{{ gs('assets/image/svg', 'sprite.svg#icon-search') }}"></use>
        </svg>
        </button>
    </form>
</div>
@if (!$payments->isEmpty())
<div class="page-trans">
    
    <div class="flex-table mt-4">
        <!--Table header-->
        <div class="flex-table-header">
            <span class="is-grow">{{ __('User') }}</span>
            <span>{{ __('Date') }}</span>
            <span>{{ __('Amount') }}</span>
            <span>{{ __('Method') }}</span>
            <span>{{ __('Plan') }}</span>
        </div>
        @foreach ($payments as $item)
        <div class="flex-table-item">
            <div class="flex-table-cell is-media is-grow" data-th="">
                @if (\App\User::find($item->user))
                <div class="h-avatar is-medium mr-4">
                    <img class="avatar is-squared lozad" data-src="{{ avatar($item->user) }}" alt="">
                </div>
                @endif
                <div>
                    <span class="item-name dark-inverted is-font-alt is-weight-600">{{ !empty(user('name', $item->user)) ? user('name', $item->user) : $item->name }}</span>
                    <span class="item-meta text-xs mt-2">
                        <span>{{ $item->email }}</span>
                    </span>
                </div>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Date') }}">
                <span class="light-text">{{ Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Amount') }}">
                <span class="dark-inverted is-weight-600">{!! Currency::symbol($item->currency) . $item->price !!}</span>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Method') }}">
                <span class="tag is-green is-rounded">{{ $item->gateway }}</span>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Plan') }}">
                <div class="ml-auto md:ml-0">
                    <span class="item-name font-normal text-base">{{ !empty(GetPlan('name', $item->plan)) ? GetPlan('name', $item->plan) : $item->plan_name }}</span>
                    <span class="item-meta text-xs mt-2 block">
                        <span>{{ ucfirst($item->duration) }}</span>
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<div class="is-empty md:p-20 text-center mt-10 block">
    <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
    <p class="mt-10 text-lg font-bold">{{ __('No Payments Found.') }}</p>
</div>
@endif
@endsection