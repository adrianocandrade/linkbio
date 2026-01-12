@extends('mix::layouts.master')
@section('title', __('Booking View'))
@section('content')


<div class="mix-padding-10">
<div class="dashboard-header-banner relative mt-0 mb-5">
    <div class="card-container">

        <div class="text-lg font-bold">{{ __('Booking View') }}</div>

        <div class="side-cta top-8">
            {!! orion('hour-1', 'h-20') !!}
        </div>
    </div>
</div>


<div class="relative z-10 details block p-0">
    <div class="details__head mb-8 text-left card card_widget rounded-xl mx-0 max-w-full p-2 px-5">
        <div class="details__user m-0 flex w-full">
            @if ($customer = \App\User::find($booking->payee_user_id))
            <div class="details__avatar mr-2 w-14 h-14">
                {!! avatar($customer->id, true) !!}
            </div>
            <div class="details__wrap">
                <div class="details__man text-sm">{{ $customer->name }}</div>
                <div class="details__login text-xs">{{ $booking->status_text }} | {{ $booking->is_paid ? __('Paid') : __('Not Paid') }}</div>
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
    <div class="flex gap-4">
        <a class="text-sticker h-10 flex items-center justify-center bg-gray-200 shadow-none update-booking-open mt-5">{!! orion('edit-1', 'w-5 h-5 mr-1') !!} {{ __('Update') }}</a>
    </div>
    </div>
</div>


<div data-popup=".update-booking" class="small-floating">
    <div class="font-bold text-lg">{{ __('Update booking status') }}</div>
    <p class="text-sm font-bold text-gray-400">{{ __('Mark booking as completed, canceled, no-show.') }}</p>
    <hr class="my-5">
    <form action="{{ route('sandy-blocks-booking-mix-change-booking-status') }}" method="post">
        @csrf
        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
        <div class="form-input">
            <label class="initial">{{ __('Status') }}</label>
            <select name="status">
                <option value="1" {{ $booking->appointment_status == 1 ? 'selected' : '' }}>{{ __('Completed') }}</option>
                <option value="2" {{ $booking->appointment_status == 2 ? 'selected' : '' }}>{{ __('Cancel') }}</option>
                <option value="0" {{ $booking->appointment_status == 0 ? 'selected' : '' }}>{{ __('Pending') }}</option>
            </select>
        </div>
        <button class="mt-5 button w-full">{{ __('Save') }}</button>
    </form>
</div>
@endsection
