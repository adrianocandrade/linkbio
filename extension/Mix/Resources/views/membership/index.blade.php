@extends('mix::layouts.master')
@section('title', __('Memberships'))
@section('content')
@includeIf('include.back-header', ['route' => url()->previous()])

<div class="wallet-page relative mix-padding-10">
    
    <div class="dashboard-header-banner relative mt-0 mb-5">
		<div class="card-container">
			
			<div class="text-lg font-bold">{{ __('Memberships') }}</div>
            <div class="side-cta">
                <img src="{{ gs('assets/image/emoji/Yellow-1/Piggy-Bank.png') }}" alt="">
            </div>
		</div>
	</div>

    <div class="dashboard-fancy-card-v1 border border-gray-100 border-solid rounded-xl grid grid-cols-2">
        <div class="dashboard-fancy-card-v1-single active">
            <div class="details-item w-full">
                <div class="details-head">
                    <div class="details-preview">
                        <i class="sio office-093-money-sack sligh-thick text-black text-lg"></i>
                    </div>
                    <div class="details-text caption-sm">{{ __('Total Revenue') }}</div>
                </div>
                {{-- Placeholder data for revenue, needs Implementation --}}
                <div class="details-counter text-2xl md:text-4xl truncate font-bold">{!! money(0) !!}</div>
                <div class="details-indicator">
                    <div class="details-progress bg-red w-half"></div>
                </div>
            </div>
        </div>
        <div class="dashboard-fancy-card-v1-single">
            <div class="details-item w-full border-0">
                <div class="details-head">
                    <div class="details-preview">
                        <i class="sio business-and-finance-086-id-card sligh-thick text-black text-lg"></i>
                        
                    </div>
                    <div class="details-text caption-sm">{{ __('Active Plans') }}</div>
                </div>
                <div class="details-counter text-2xl md:text-4xl truncate font-bold">{{ nr($plans->count(), true) }}</div>
                <div class="details-indicator">
                    <div class="details-progress bg-sea w-half"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="quick-actions grid grid-cols-2 gap-4 mt-5">
        <a class="quick-action" href="{{ route('user-mix-audience-index') }}">
            <div class="quick-action-inner">{{ __('Subscribers') }}<span class="arrow-go">→</span>
            </div>
            {!! svg_i('network-1') !!}
        </a>

        <!-- Settings - Hidden until implemented
        <a class="quick-action" href="#"> 
            <div class="quick-action-inner">{{ __('Settings') }}<span class="arrow-go">→</span>
            </div>
            {!! svg_i('cogwheel-1') !!}
        </a>
        -->

        <a class="quick-action col-span-1" href="{{ route('user-mix-membership-create') }}">
            <div class="quick-action-inner">{{ __('Create Plan') }}<span class="arrow-go">→</span>
            </div>
            {!! svg_i('add-1') !!}
        </a>
    </div>

    <h1 class="my-7 font-bold">{{ __('My Plans') }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 relative z-10">
        <div class="flex items-center">
            <div class="bio-courses-card-v1 card_widget w-full is-upload h-40 md:h-full min-h-[160px]">
                <a class="courses-preview text-xl h-full" app-sandy-prevent="" href="{{ route('user-mix-membership-create') }}">
                    <div class="absolute top-0 left-0 h-full w-full flex items-center justify-center">
                        <i class="plus-icon la la-plus relative flex items-center justify-center"></i>
                    </div>
                </a>
            </div>
        </div>
        @foreach($plans as $plan)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col justify-between hover:border-primary transition-colors min-h-[160px]">
             <div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-lg text-gray-800">{{ $plan->name }}</h3>
                    <span class="text-xs font-bold px-2 py-1 rounded {{ $plan->status == 'active' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                        {{ __($plan->status) }}
                    </span>
                </div>
                <div class="text-2xl font-bold text-primary mb-1">
                    {!! money($plan->price) !!}
                </div>
                <div class="text-xs text-gray-400 uppercase tracking-wider mb-4">{{ __($plan->billing_cycle) }}</div>
             </div>

             <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                 <a href="{{ route('user-mix-membership-edit', $plan->id) }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-primary">
                     <i class="la la-edit text-lg"></i> {{ __('Edit') }}
                 </a>
                 <a href="{{ route('user-mix-membership-subscribers', $plan->id) }}" class="text-xs text-gray-400 hover:text-primary transition-colors">
                     {{ $plan->subscriptions_count ?? 0 }} {{ __('Subscribers') }}
                 </a>
             </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $plans->links() }}
    </div>

</div>
@endsection
