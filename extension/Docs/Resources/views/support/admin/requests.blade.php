@extends('admin::layouts.master')
@section('title', __('Support Requests'))
@section('headJS')
<style type="text/css">
@media screen and ( max-width: 600px ){
li.page-item {
display: none !important;
}
.page-item:first-child,
.page-item:nth-child( 2 ),
.page-item:nth-last-child( 2 ),
.page-item:last-child,
.page-item.active,
.page-item.disabled {
display: block !important;
}
}
</style>
@stop
@section('content')
<div class="sandy-page-row">
   <div class="sandy-page-col pl-0">
      <div class="page__head">
         <div class="step-banner remove-shadosw">
            <div class="section-header">
               <div class="section-header-info">
                  <p class="section-pretitle">{{ __('Support Center') }} ({{ number_format(\App\Models\SupportConversation::count()) }})</p>
                  <h2 class="section-title">{{ __('All Requests') }}</h2>
               </div>
            </div>
            <form class="w-full mt-5">
               <div class="search__form shadow-none w-full">
                  <input class="search__input mort-main-bg" type="text" name="query" value="{{ request()->get('query') }}" placeholder="{{ __('Search for subjects') }}">
                  <button class="search__btn">
                  <svg class="icon icon-search">
                     <use xlink:href="{{ gs('assets/image/svg/sprite.svg#icon-search') }}"></use>
                  </svg>
                  </button>
               </div>
            </form>
         </div>
      </div>
      <div class="inbox p-0">
         @if (!$support->isEmpty())
         <div class="inbox-container mt-10">
            <div class="flex justify-between items-center mb-5">
               <div class="inbox-title">{{ __('Requests') }}</div>
            </div>
            <div class="inbox-list">
               @foreach ($support as $item)
               <div class="inbox-item rounded-2xl">
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
                     </div>
                     <div class="inbox-title">{{ $item->topic }}</div>
                     <div class="inbox-text">"{{ $item->description }}"</div>
                     <div class="flex">
                        <a href="{{ route('admin-support-view', $item->id) }}" class="text-sticker" app-sandy-prevent="">{{ __('View') }}</a>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
         @else
         <div class="is-empty p-10 text-center">
            <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
            <p class="mt-10 text-lg font-bold">{{ __('No Request Found.') }}</p>
         </div>
         @endif
         
         <div class="mt-10">
            {!! $support->links() !!}
         </div>
      </div>
   </div>
   <div class="sandy-page-col sandy-page-col_pt100">
      <div class="card card_widget">
         <div class="card__head card__head_mb32">
            <div class="card__title h6">{{ __('Filter') }}</div>
         </div>
         <div class="card__filters">
            <form class="notifications__search flex flex-col" method="GET">
               <input class="notifications__input mb-5" type="text" name="query" value="{{ request()->get('query') }}" placeholder="{{ __('Search for subjects') }}">
               <div class="form-input mb-5">
                  <label class="initial">{{ __('User') }}</label>
                  <select name="user">
                     <option value="">{{ __('All') }}</option>
                     @foreach (\App\User::get() as $key => $value)
                     <option value="{{$value->id}}" {{ request()->get('user') == $value->id ? 'selected' : '' }}>{{ $value->name }} - {{ '@' . $value->username }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="mb-5">
                  <div class="checkbox-wrap">
                     <input type="radio" name="status" {{ request()->get('status') == 'opened' ? 'checked' : '' }} value="opened" id="radio-status-open">
                     <div class="checkbox-box round"></div>
                     <label class="font-normal" for="radio-status-open">{{ __('Opened') }}</label>
                  </div>
                  
                  <div class="checkbox-wrap mt-5">
                     <input type="radio" name="status" value="closed" id="radio-status-closed" {{ request()->get('status') == 'closed' ? 'checked' : '' }}>
                     <div class="checkbox-box round"></div>
                     <label class="font-normal" for="radio-status-closed">{{ __('Closed') }}</label>
                  </div>
               </div>
               <div class="form-input mb-5">
                  <label class="initial">{{ __('Order by') }}</label>
                  <select name="order_by">
                     @foreach (['created_at' => 'Created On', 'id' => 'ID'] as $key => $value)
                     <option value="{{$key}}" {{ request()->get('order_by') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                     @endforeach
                  </select>
               </div>
               <!-- OrderType:START -->
               <div class="form-input mb-5">
                  <label class="initial">{{ __('Order type') }}</label>
                  <select name="order_type">
                     @foreach (['DESC' => 'Descending', 'ASC' => 'Ascending'] as $key => $value)
                     <option value="{{$key}}" {{ request()->get('order_type') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                     @endforeach
                  </select>
               </div>
               <!-- OrderType:END -->
               <!-- Results Per Page:START -->
               <div class="form-input mb-5">
                  <label class="initial">{{ __('Per Page') }}</label>
                  <select name="per_page">
                     @foreach ([10, 25, 50, 100, 250] as $key => $value)
                     <option value="{{$value}}" {{ request()->get('per_page') == $value ? 'selected' : '' }}>{{ $value }}</option>
                     @endforeach
                  </select>
               </div>
               <!-- Results Per Page:END -->
               <div>
                  
                  <button class="text-sticker bg-gray-200 is-loader-submit loader-white mt-0 mb-0">{{ __('Filter') }}</button>
               </div>
            </form>
         </div>
         
         <a class="card__reset" href="{{ route('admin-support-requests') }}">{{ __('Reset all filters') }}</a>
      </div>
   </div>
</div>
@endsection