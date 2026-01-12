@extends('mix::layouts.master')
@section('title', $contact->name)
@section('content')

<div class="mix-padding-10">
    
    <!-- Header -->
    <div class="dashboard-header-banner relative mb-5">
        <div class="card-container">
            <div class="flex items-center gap-3">
                 <a href="{{ route('user-mix-audience-index') }}" class="btn btn-sm bg-white/10 hover:bg-white/20 text-white rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="la la-arrow-left"></i>
                </a>
                <div class="text-lg font-bold">{{ $contact->name }}</div>
            </div>
            <div class="side-cta">
               <div class="text-xs uppercase opacity-70 mb-1">{{ __('Total Spent') }}</div>
               <div class="font-bold text-lg">{!! money($contact->total_spent) !!}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Profile Card -->
        <div class="md:col-span-1">
            <div class="p-5 bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="text-center mb-5">
                    <div class="w-24 h-24 rounded-full bg-gray-100 mx-auto flex items-center justify-center text-3xl font-bold text-gray-400 mb-3">
                        {{ substr($contact->name, 0, 1) }}
                    </div>
                    <h3 class="font-bold text-lg text-gray-800">{{ $contact->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ $contact->email }}</p>
                    <div class="mt-3">
                         <span class="tag is-success is-rounded uppercase text-[10px]">{{ __($contact->source) }}</span>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 mt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs text-gray-500">{{ __('First Seen') }}</span>
                        <span class="text-sm font-medium">{{ $contact->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                     <div class="flex justify-between items-center mb-2">
                        <span class="text-xs text-gray-500">{{ __('Last Interaction') }}</span>
                        <span class="text-sm font-medium">{{ $contact->last_interaction_at ? $contact->last_interaction_at->diffForHumans() : '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">{{ __('Interactions') }}</span>
                        <span class="text-sm font-medium">{{ $contact->total_interactions }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interactions Feed -->
        <div class="md:col-span-2">
            <div class="p-5 mort-main-bg rounded-2xl">
                <h4 class="font-bold text-gray-800 mb-4">{{ __('Interaction History') }}</h4>
                
                <div class="relative pl-4 border-l-2 border-gray-200">
                    @forelse($contact->interactions as $interaction)
                    <div class="mb-6 relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-primary border-2 border-white"></div>
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                            <div class="flex justify-between items-start mb-1">
                                <span class="font-bold text-sm text-gray-800 uppercase">{{ __($interaction->type) }}</span>
                                <span class="text-xs text-gray-400">{{ $interaction->created_at->translatedFormat('d M Y, h:i A') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ ucfirst(__($interaction->action)) }}</p>
                            
                            @if($interaction->value > 0)
                            <div class="inline-block bg-green-50 text-green-600 px-2 py-1 rounded text-xs font-bold">
                                + {!! money($interaction->value) !!}
                            </div>
                            @endif

                            @if(!empty($interaction->details))
                            <div class="mt-2 text-xs bg-gray-50 p-2 rounded text-gray-500">
                                @foreach($interaction->details as $key => $val)
                                    <div><span class="font-semibold">{{ ucfirst($key) }}:</span> {{ is_array($val) ? json_encode($val) : $val }}</div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <p class="text-gray-400 text-sm">{{ __('No interactions recorded yet.') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
