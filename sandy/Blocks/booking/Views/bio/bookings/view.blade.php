@extends('bio::layouts.master')
@section('content')
@section('head')

<style>
    .bio-menu {
        display: none !important;
    }

    #zuck-modal #zuck-modal-content .story-viewer .slides .item>.media {
        object-fit: contain !important;
    }

    #zuck-modal #zuck-modal-content .story-viewer .head .left .time {
        display: none !important;
    }

</style>
@stop
        <div class="px-5 md:px-0">


            <div class="inner-pages-header mb-10">
                <div class="inner-pages-header-container">
                    <a class="previous-page" app-sandy-prevent="" href="{{ $sandy->route('sandy-blocks-booking-bookings') }}">
                        <p class="back-button"><i class="la la-arrow-left"></i></p>
                        <h1 class="inner-pages-title ml-3">{{ __('Back') }}</h1>
                    </a>
                </div>
            </div>
            

<div class="relative z-10 details block p-0 md:px-10">
    <div class="details__head mb-8 text-left card card_widget rounded-xl mx-0 max-w-full p-2 px-5">
        <div class="details__user m-0 flex w-full">
            @if ($customer = \App\User::find($booking->payee_user_id))
            <div class="details__avatar mr-2 w-14 h-14">
                {!! avatar($customer->id, true) !!}
            </div>
            <div class="details__wrap">
                <div class="details__man text-sm">{{ $customer->name }}</div>
                <div class="details__login text-xs">{{ $booking->status_text }} | {{ $booking->is_paid ? __('Paid') : 'Not-Paid' }}</div>
            </div>
            @endif

            <div class="flex flex-col items-center text-center ml-auto">
                <span class="uppercase text-xs font-bold">{{ \Carbon\Carbon::parse($booking->date)->format('M') }}</span>
                <span class="uppercase text-base font-bold">{{ \Carbon\Carbon::parse($booking->date)->format('d') }}</span>
                <span class="uppercase text-xs font-bold">{{ $booking->nice_start_time }}</span>
            </div>
        </div>
    </div>

    <div class="card_widget rounded-xl border-0 relative">
        <div class="settings-page flex flex-col gap-4">
            <div class="settings-card relative pt-0 min-h-full pb-0">
                <div class="settings-card-avatar bg-transparent">
                    <span>
                        {!! orion('hour-1', 'w-6 h-6') !!}
                    </span>
                </div>
                <div class="settings-card-info">
                    <h4 class="text-base">{{ __('Appointment') }}</h4>
                    <p>{{ \Carbon\Carbon::parse($booking->date)->toFormattedDateString() }}, {{ $booking->nice_start_time }} - {{ $booking->nice_end_time }}</p>
                </div>
            </div>
            <div class="settings-card relative pt-0 min-h-full pb-0">
                <div class="settings-card-avatar bg-transparent">
                    <span>
                        {!! orion('credit-card-1', 'w-6 h-6') !!}
                    </span>
                </div>
                <div class="settings-card-info">
                    <h4 class="text-base">{{ __('Price') }}</h4>
                    <p>{!! $sandy->price($booking->price) !!}</p>
                </div>
            </div>
            <div class="settings-card relative pt-0 min-h-full pb-0">
                <div class="settings-card-avatar bg-transparent">
                    <span>
                        {!! orion('invoice-1', 'w-6 h-6') !!}
                    </span>
                </div>
                <div class="settings-card-info">
                    <h4 class="text-base">{{ __('Services') }}</h4>
                    <p>{{ $booking->services_name }}</p>
                </div>
            </div>
        </div>
    </div>

</div>
        <div class="pb-20"></div>
@endsection
