@extends('mix::layouts.master')
@section('title', __('Orders'))
@section('content')
@includeIf('include.back-header', ['route' => route('sandy-blocks-shop-mix-view')])
<div class="mix-padding-10">
    <div class="inner-page-banner rounded-2xl">
        <div class="flex flex-col mb-3">
            <h1 class="mb-0 font-bold text-lg">{{ __('Product Orders') }}</h1>
            <p class="text-gray-400 text-xs">{{ __('Manage purchased orders. Change order status ') }}</p>
        </div>
        <form>
            <div class="search__form shadow-none w-full">
                <input class="search__input text-xs" type="text" name="query_id" value="{{ request()->get('query_id') }}" placeholder="{{ __('Search by order ID') }}">
                <button class="search__btn text-2xl">
                <i class="sio maps-and-navigation-047-global-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="mt-5">
        @if (!$orders->isEmpty())
        <div class="flex-table mt-10">
            <!--Table header-->
            <div class="flex-table-header">
                <span class="is-grow">{{ __('Customer') }}</span>
                <span>{{ __('Price') }}</span>
                <span>{{ __('Status') }}</span>
                <span>{{ __('Date') }}</span>
                <span class="cell-end">{{ __('Action') }}</span>
            </div>
            @foreach ($orders as $item)
            <div class="flex-table-item rounded-2xl shadow-none mort-main-bg">
                <div class="flex-table-cell is-media is-grow" data-th="">
                    <div class="h-avatar md is-trans">
                        {!! avatar($item->payee_user_id, true) !!}
                    </div>
                    <div>
                        <span class="item-name mb-2">{{ user('name', $item->payee_user_id) }}</span>
                        <span class="item-meta">
                            <span>#{{ $item->id }}</span>
                        </span>
                    </div>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Price') }}">
                    <span>
                        {!! \Bio::price($item->price, $user->id) !!}
                    </span>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Status') }}">
                    <span class="my-0">{{ $order_status($item->status) }}</span>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Date') }}">
                    <span class="my-0">{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
                </div>
                <div class="flex-table-cell cell-end" data-th="{{ __('Action') }}">
                    <a href="{{ route('sandy-blocks-shop-mix-single-order', $item->id) }}" class="sandy-expandable-btn ml-auto bg-white"><span>{{ __('Manage') }}</span></a>
                </div>
            </div>
            @endforeach
            
            <div class="mt-10">
                {!! $orders->links() !!}
            </div>
        </div>
        @else
        <div class="p-10 py-20">
            @include('include.is-empty')
        </div>
        @endif
    </div>
</div>
@endsection