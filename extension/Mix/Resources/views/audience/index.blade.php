@extends('mix::layouts.master')
@section('title', __('Audience'))
@section('content')

<div class="mix-padding-10">
    
    <div class="dashboard-header-banner relative mb-5">
        <div class="card-container">
            <div class="text-lg font-bold">{{ __('Audience') }}</div>
            <div class="side-cta">
                <img src="{{ gs('assets/image/emoji/Yellow-1/Star.png') }}" alt="">
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4 mb-10">
        <div class="insight-card shadow-none">
            <div class="icon">
                <i class="sni sni-user"></i>
            </div>
            <h2>{{ $totalContacts }}</h2>
            <h5>{{ __('Total Contacts') }}</h5>
            <div class="text-xs text-gray-400">{{ __('Lifetime') }}</div>
        </div>
        <div class="insight-card shadow-none">
            <div class="icon">
                <i class="la la-chart-line"></i>
            </div>
            <h2>{{ $newThisMonth }}</h2>
            <h5>{{ __('New This Month') }}</h5>
            <div class="text-xs text-gray-400">{{ __('Growth') }}</div>
        </div>
        <div class="insight-card col-span-2 md:col-span-1 shadow-none">
            <div class="icon">
                <i class="sni sni-wallet"></i>
            </div>
            <h2>{!! money($totalRevenue) !!}</h2>
            <h5>{{ __('Total Revenue') }}</h5>
            <div class="text-xs text-gray-400">{{ __('From audience') }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="p-5 mort-main-bg rounded-2xl">
        <div class="bg-white p-3 flex flex-wrap justify-between items-center mb-5 rounded-xl gap-4">
            <p class="title text-sm m-0">{{ __('Contacts') }}</p>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <form action="" method="GET" class="flex items-center gap-2 w-full md:w-auto">
                    <select name="source" class="bg-gray-50 border border-gray-200 text-sm rounded-lg p-2 focus:ring-0 w-full md:w-auto" onchange="this.form.submit()">
                        <option value="">{{ __('All Sources') }}</option>
                        <option value="booking" {{ $filters['source'] == 'booking' ? 'selected' : '' }}>{{ __('Bookings') }}</option>
                        <option value="tipjar" {{ $filters['source'] == 'tipjar' ? 'selected' : '' }}>{{ __('Tips') }}</option>
                        <option value="shop" {{ $filters['source'] == 'shop' ? 'selected' : '' }}>{{ __('Shop') }}</option>
                        <option value="giveaway" {{ $filters['source'] == 'giveaway' ? 'selected' : '' }}>{{ __('Giveaways') }}</option>
                    </select>
                    
                    <div class="relative w-full md:w-auto">
                         <input type="search" name="search" value="{{ $filters['search'] }}" 
                               class="bg-gray-50 border border-gray-200 text-sm rounded-lg pl-8 p-2 w-full focus:ring-0" 
                               placeholder="{{ __('Search...') }}">
                        <i class="la la-search absolute left-2.5 top-2.5 text-gray-400"></i>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex-table is-insight">
            <!--Table header-->
            <div class="flex-table-header">
                <span class="is-grow">{{ __('Contact') }}</span>
                <span>{{ __('Source') }}</span>
                <span>{{ __('Interactions') }}</span>
                <span>{{ __('Spent') }}</span>
                <span>{{ __('Action') }}</span>
            </div>
            
            <!--Table item-->
            @forelse($contacts as $contact)
            <div class="flex-table-item rounded-xl">
                <div class="flex-table-cell is-media is-grow" data-th="{{ __('Contact') }}">
                    <div class="h-avatar sm is-trans rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold uppercase">
                       {{ substr($contact->name, 0, 1) }}
                    </div>
                    <div>
                        <span class="item-name text-xs">{{ $contact->name }}</span>
                        <span class="item-meta text-xs">{{ $contact->email }}</span>
                    </div>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Source') }}">
                    <span class="tag is-success is-rounded uppercase text-[10px]">{{ __($contact->source) }}</span>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Interactions') }}">
                    <span class="light-text">{{ $contact->total_interactions }}</span>
                </div>
                <div class="flex-table-cell" data-th="{{ __('Spent') }}">
                     <span class="font-bold text-green-600">{!! money($contact->total_spent) !!}</span>
                </div>
                <div class="flex-table-cell text-xs" data-th="{{ __('Action') }}">
                    <a class="text-sticker ml-auto text-xs m-0 flex items-center" href="{{ route('user-mix-audience-contact', $contact->id) }}">{{ __('View') }}</a>
                </div>
            </div>
            @empty
            <div class="text-center py-10">
                <div class="mb-3">
                    <img src="{{ gs('assets/image/empty.svg') }}" class="w-32 mx-auto opacity-50" alt="">
                </div>
                <p class="text-gray-500 text-sm">{{ __('No contacts found.') }}</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $contacts->appends(request()->query())->links() }}
        </div>
    </div>

</div>
@endsection
