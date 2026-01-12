@extends('mix::layouts.master')
@section('title', __('Payments'))
@section('namespace', 'user-mix-settings-methods')
@section('content')
<div class="mix-padding-10">
	<div class="relative">
		<div class="card customize mb-5 rounded-2xl">
			<div class="card-header">
				<p class="title font-bold">{{ __('Plan') }}</p>
				<p class="subtitle">{{ __('View your current plan and also check history of purchased plans by you.') }}</p>
				<div class="index-header-wrap mt-5 p-5 bg-white block rounded-xl shadow-none">
					<div class="index-header-line mb-7">
						<div class="index-header-img">
							<img data-src="{{avatar()}}" class="lozad" alt=" ">
						</div>
						<div class="index-header-details">
							<div class="index-header-info">{{ __('Current Plan') }}</div>
							<div class="index-header-money">{{ plan('name') }}</div>
						</div>
					</div>
					<div class="item text-left my-7 flex items-center">
						<p class="text-sm c-gray mr-3">{{ __('Expiry') }}</p> -
						<span class="text-sm ml-3">{{ plan('plan_due_string') }}</span>
					</div>
					<a href="{{ route('pricing-index') }}" app-sandy-prevent="" class="this-button text-sticker w-full flex justify-center uppercase py-5 items-center">{{ __('Upgrade my Plan') }}</a>
				</div>
				<div class="flex gap-4 mb-5">
					<a href="{{ route('user-mix-settings-pending') }}" class="mt-5 text-sticker">{{ __('Manual payments') }}</a>
				</div>
			</div>
		</div>
		@if (!$history->isEmpty())
		<p class="title font-normal mt-10 text-xl">{{ __('Plan History') }}</p>
		<div class="flex-table mt-4">
			<!--Table header-->
			<div class="flex-table-header">
				<span class="is-grow">{{ __('User') }}</span>
				<span>{{ __('Date') }}</span>
				<span>{{ __('Amount') }}</span>
				<span>{{ __('Method') }}</span>
				<span>{{ __('Plan') }}</span>
			</div>
			@foreach ($history as $item)
			<div class="flex-table-item rounded-2xl">
				<div class="flex-table-cell is-media is-grow" data-th="">
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
		@else
		<div class="is-empty full text-center block mt-10 px-14">
			<img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="m-auto" alt="">
			<p class="mt-10 text-lg font-bold">{{ __('Nothing found.') }}</p>
		</div>
		@endif
	</div>
</div>
@endsection