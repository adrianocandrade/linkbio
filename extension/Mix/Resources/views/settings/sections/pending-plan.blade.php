@extends('mix::layouts.master')
@section('title', __('Pending'))
@section('namespace', 'user-mix-settings-pending')
@section('content')
<div class="mix-padding-10">
	<div class="relative">
		<div class="card customize mb-5">
			<div class="card-header">
				<p class="mb-0 title font-bold">{{ __('All Manual Payments') }}</p>
			</div>
		</div>
		@if (!$pending->isEmpty())
		<div class="flex-table mt-4">
			<!--Table header-->
			<div class="flex-table-header">
				<span class="is-grow">{{ __('User') }}</span>
				<span>{{ __('Date') }}</span>
				<span>{{ __('Plan') }}</span>
			</div>
			@foreach ($pending as $item)
			<div class="flex-table-item rounded-2xl">
				<div class="flex-table-cell is-media is-grow" data-th="">
					@if (\App\User::find($item->user))
					<div class="h-avatar md mr-4">
						<img class="avatar is-squared" src="{{ avatar($item->user) }}" alt="">
					</div>
					@endif
					<div>
						<span class="light-text mb-2">{{ $item->status ? __('Confirmed') : __('Unconfirmed') }}</span>
						<span class="m-0 c-gray text-xs">
							<span>#{{$item->ref}}</span>
						</span>
					</div>
				</div>
				<div class="flex-table-cell" data-th="{{ __('Date') }}">
					<span class="light-text">{{ Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
				</div>
				<div class="flex-table-cell" data-th="{{ __('Plan') }}">
					<div class="ml-auto md:ml-0">
						<span class="item-name font-normal text-sm">{{ GetPlan('name', $item->plan) }}</span>
						<span class="item-meta text-xs mt-2 block">
							<span>{{ ucfirst($item->duration) }}</span>
						</span>
					</div>
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
</div>
@endsection