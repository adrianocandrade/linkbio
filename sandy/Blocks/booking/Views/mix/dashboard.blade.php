@extends('mix::layouts.master')
@section('title', __('Booking'))
@section('content')
<div class="mix-padding-10">
    
    <div class="dashboard-header-banner relative mt-0 mb-5">
        <div class="card-container">

            <div class="text-lg font-bold">{{ __('Booking') }}</div>
            <p class="hidden">
                {{ __('Manage your booking and setup your booking services and working time for your audience to work with while making an appointment.') }}
            </p>
            <div class="side-cta">
                <img src="{{ gs('assets/image/emoji/Yellow-1/Idea.png') }}" alt="">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 relative z-10">

        <div class="card p-5 rounded-xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
            <div class="card-container bg-repeat-right"
                data-bg="{{ gs('assets/image/others/scribbbles/36.png') }}">


                <div class="icon ">
                    {!! orion('hour-1', 'w-20 h-20') !!}
                </div>
                <div class="mt-5 text-2xl font-bold">{{ __('Manage Calendar') }}</div>
                <div class="my-2 text-xs is-info w-44">{{ __('View & manage previously booked appointments.') }}</div>

                <a app-sandy-prevent="" href="{{ route('sandy-blocks-booking-mix-calendar') }}" class="sandy-expandable-btn px-10"><span>{{ __('Manage') }}</span></a>
            </div>
        </div>


        <div class="card p-5 rounded-xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
            <div class="card-container bg-repeat-right"
                data-bg="{{ gs('assets/image/others/scribbbles/18.png') }}">


                <div class="icon ">
                    {!! orion('cogwheel-1', 'w-20 h-20') !!}
                </div>
                <div class="mt-5 text-2xl font-bold">{{ __('Booking Settings') }}</div>
                <div class="my-2 text-xs is-info w-44">{{ __('Manage your booking working hour and services and more.') }}</div>

                <a app-sandy-prevent="" href="{{ route('sandy-blocks-booking-mix-settings') }}" class="sandy-expandable-btn px-10"><span>{{ __('Manage') }}</span></a>
            </div>
        </div>
    </div>
</div>
@endsection
