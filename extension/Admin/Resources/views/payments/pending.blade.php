@extends('admin::layouts.master')
@section('title', __('All Payments'))
@section('namespace', 'admin-payments')
@section('content')
<div class="sandy-page-col pl-0 pb-0">
    <div class="page__head">
        <div class="step-banner remove-shadow">
            <div class="section-header">
                <div class="section-header-info">
                    <p class="section-pretitle">{{ __('Pending Payments') }} ({{ count($pending) }})</p>
                    <h2 class="section-title">{{ __('Payments') }}</h2>
                </div>
                <div class="section-header-actions">
                    <div class="notifications__tags">
                        <a class="notifications__link" href="{{ route('admin-payments') }}">{{ __('All Paid Payments') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-trans rounded-2xl">
    <form method="GET" class="remove-shadow flex items-center mb-10">
        <div class="dropdown ml-2 md:ml-0 mr-2">
            <button class="dropdown__head sorting__action shadow-none rounded-2xl mort-main-bg m-0">
            <i class="la la-filter"></i>
            </button>
            <div class="dropdown__body has-simplebar">
                <div data-simplebar="" class="h-full">
                    <div class="form-input mb-5">
                        <label class="initial">{{ __('Search by') }}</label>
                        <select name="search_by">
                            @foreach (['ref' => 'Ref', 'email' => 'Email', 'name' => 'Name'] as $key => $value)
                            <option value="{{$key}}" {{ request()->get('search_by') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-input mb-5">
                        <label class="initial">{{ __('Status') }}</label>
                        <select name="status">
                            <option value="">{{ __('All') }}</option>
                            @foreach (['confirmed' => 'Confirmed', 'unconfirmed' => 'Unconfirmed'] as $key => $value)
                            <option value="{{$key}}" {{ request()->get('status') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Results Per Page:END -->
                    <button class="button sandy-quality-button bg-blue2 is-loader-submit loader-white mt-auto mb-8">{{ __('Submit') }}</button>
                </div>
            </div>
        </div>
        <div class="search__form w-full shadow-none mr-auto">
            <input class="search__input bg-gray-100 h-14 text-sm" type="text" name="query" placeholder="{{ __('Search by :by', ['by' => $searchBy]) }}" value="{{ request()->get('query') }}">
            <button class="search__btn">
            <svg class="icon icon-search">
                <use xlink:href="{{ gs('assets/image/svg', 'sprite.svg#icon-search') }}"></use>
            </svg>
            </button>
        </div>
    </form>
    
    @if (!$pending->isEmpty())
    <div class="flex-table mt-4">
        <!--Table header-->
        <div class="flex-table-header">
            <span class="is-grow">{{ __('User') }}</span>
            <span>{{ __('Status') }}</span>
            <span>{{ __('Date') }}</span>
            <span>{{ __('Info') }}</span>
            <span>{{ __('Plan') }}</span>
            <span></span>
        </div>
        @foreach ($pending as $item)
        <div class="flex-table-item shadow-none">
            <div class="flex-table-cell is-media is-grow" data-th="">
                @if (\App\User::find($item->user))
                <div class="h-avatar md mr-4">
                    <img class="avatar is-squared" src="{{ avatar($item->user) }}" alt="">
                </div>
                @endif
                <div>
                    <span class="item-name dark-inverted is-font-alt is-weight-600">{{ $item->name }}</span>
                    <span class="item-meta text-xs mt-2">
                        <span>{{ $item->email }}</span>
                    </span>
                    <span class="m-0 c-gray text-xs">
                        <span>#{{$item->ref}}</span>
                    </span>
                </div>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Status') }}">
                <span class="light-text">{{ $item->status ? __('Confirmed') : __('Unconfirmed') }}</span>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Date') }}">
                <span class="light-text">{{ Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Proof') }}">
                <div class="h-avatar sm mr-4 ml-auto md:ml-0">
                    <div data-background-image="{{ gs('media/site/manual-payment', ao($item->info, 'proof')) }}" class="lozad image"></div>
                </div>
                <div>
                    <span class="item-name font-normal text-xs">{{ ao($item->info, 'bank_name') }}</span>
                    <span class="item-meta text-xs mt-2 block">
                        <a href="{{ gs('media/site/manual-payment', ao($item->info, 'proof')) }}" target="_blank" class="link">{{ __('Proof image') }}</a>
                    </span>
                </div>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Plan') }}">
                <div class="ml-auto md:ml-0">
                    <span class="item-name font-normal text-sm">{{ GetPlan('name', $item->plan) }}</span>
                    <span class="item-meta text-xs mt-2 block">
                        <span>{{ ucfirst($item->duration) }}</span>
                    </span>
                </div>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Actions') }}">
                
                @if (!$item->status)
                <div class="dropdown ml-auto md:ml-0">
                    <button class="dropdown__head sorting__action shadow-none rounded-2xl mort-main-bg m-0">
                    <i class="sio construction-icon-021-spanner text-xl"></i>
                    </button>
                    <div class="dropdown__body">
                        
                        <div class="mb-10 p-5 rounded-xl mort-main-bg text-center">
                            {{ __('Actions') }}
                        </div>
                        <div class="justify-between flex">
                            <form action="{{ route('admin-payments-pending-post', 'accept') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{$item->id}}" name="pending">
                                <button class="button bg-green sm shadow-none is-loader-submit loader-white">{{ __('Accept') }}</button>
                            </form>
                            <form action="{{ route('admin-payments-pending-post', 'decline') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{$item->id}}" name="pending">
                                <button class="button sm bg-red-500 text-white shadow-none is-loader-submit loader-white">{{ __('Decline') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="is-empty md:p-20 text-center mt-10 block">
        <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
        <p class="mt-10 text-lg font-bold">{{ __('Nothing Here!') }}</p>
    </div>
    @endif
</div>
@endsection