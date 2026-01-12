@extends('install::layouts.master')
@section('title', 'Database')
@section('content')
<div class="m-auto">
    <div class="relative z-50">
        
        <div class="card is-install-card card_widget mx-5 md:mx-20 p-0 card-shadow">
            <div class="card-container">

                <div class="side-cta is-small">
                    <img src="{{ gs('assets/image/others/Asset-555.png') }}" alt="">
                </div>
            <div class="flex items-center mb-5">
                <i class="text-4xl sio database-and-storage-023-cloud-network mr-3"></i>
            </div>
            <p class="mb-7 text-base font-bold">Your database is ready.</p>
            <div class="mb-5 text-sm relative z-50">
                Database connected & migrated successfully. If this is a new instance you would need to create a default "admin" user. 
            </div>
            <div class="flex relative z-50">
                <a class="ml-auto text-sticker" href="{{ route('install-steps-user') }}">{{ __('Create User') }}</a>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection