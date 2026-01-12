@extends('docs::layouts.master')
@section('title', __('Support Requests'))
@section('content')
<div class="docs-search-header">
   <div class="search-image-container">
      <img src="{{ gs('assets/image/others/Asset-22@4x.png') }}" class="search-image object-contain" alt="">
      <div class="search-image-text text-left md:p-24 p-10">
         <h1 class="search-heading-text">{{ __('How can we help you?') }}</h1>
         <p class="search-heading-desc">{{ __('Having issue with your account or you have some questions? Do not hesitate to reach out to our ready support team.') }}</p>
         <a href="{{ route('user-support-create') }}" class="text-sticker text-black">{{ __('Submit Ticket') }}</a>
      </div>
   </div>
   <div class="search-results">
      <form class="search__form w-full" action="{{ route('docs-index') }}" method="GET">
         <input class="search__input" type="text" name="query" placeholder="{{ __('Type your search word') }}">
         <button class="search__btn">
         <svg class="icon icon-search">
            <use xlink:href="{{ gs('assets/image/svg', 'sprite.svg#icon-search') }}"></use>
         </svg>
         </button>
      </form>
   </div>
</div>
<div class="inbox">
   <div class="inbox-container mt-10">
      <div class="flex justify-between items-center mb-5">
         
         <div class="inbox-title title">{{ __('My Requests') }}</div>
         <a href="{{ route('user-support-create') }}" class="text-sticker text-black m-0">{{ __('Submit Ticket') }}</a>
      </div>
      <div class="inbox-list">
         @forelse ($support as $item)
         <div class="inbox-item">
            <div class="inbox-ava">
               <div class="h-avatar md">
                  <img class="object-cover" src="{{ avatar($item->user) }}" alt="">
               </div>
            </div>
            <div class="inbox-details">
               <div class="inbox-head">
                  <div class="inbox-author caption">{{ user('name', $item->user) }}</div>
                  <div class="inbox-time caption">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
                  <div class="inbox-time text-xs">{{ $item->status ? __('Opened') : __('Closed') }}</div>
                  <div class="ml-auto inbox-counter bg-gray-500">{{ \App\Models\SupportMessage::where('conversation_id', $item->id)->where('from', 'support')->where('seen', 0)->count() }}</div>
               </div>
               <div class="inbox-title title">{{ $item->topic }}</div>
               <div class="inbox-text">"{{ $item->description }}"</div>
               <div class="actions">
                  <a href="{{ route('user-support-view', $item->id) }}" class="text-sticker" app-sandy-prevent="">{{ __('Respond') }}</a>
               </div>
            </div>
         </div>
         @empty
         @include('include.is-empty')
         @endforelse
      </div>
   </div>
</div>
@endsection