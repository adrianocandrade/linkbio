@extends('install::layouts.master')
@section('title', 'Database')
@section('content')
<div class="m-auto">
    <div class="relative z-50">
        
        <form class="card is-install-card p-0 card_widget card-shadow mx-5 md:mx-20" action="{{ route('install-steps-database-save') }}" method="POST">
            <div class="card-container">
                <div class="side-cta is-small">
                    <img src="{{ gs('assets/image/others/Asset-555.png') }}" alt="">
                </div>
                @csrf
                <div class="flex items-center mb-5">
                    <i class="text-4xl sio database-and-storage-023-cloud-network mr-3"></i>
                </div>
                <p class="mb-7">Enter your database information below.</p>
                <div>
                    <div class="grid grid-cols-2 gap-4">
                        
                        <div class="form-input mb-5">
                            <label>Database Host</label>
                            <input type="text" name="database_host" value="{{ env('DB_HOST') }}">
                        </div>
                        <div class="form-input mb-5">
                            <label>Database Port</label>
                            <input type="text" name="database_port" value="{{ env('DB_PORT') }}">
                        </div>
                    </div>
                    <div class="form-input mb-5">
                        <label>Database Name</label>
                        <input type="text" name="database_name" value="{{ env('DB_DATABASE') }}">
                    </div>
                    <div class="form-input mb-5">
                        <label>Database Username</label>
                        <input type="text" name="database_username" value="{{ env('DB_USERNAME') }}">
                    </div>
                    <div class="form-input mb-5">
                        <label>Database Password</label>
                        <input type="text" name="database_password" value="{{ env('DB_PASSWORD') }}">
                    </div>
                </div>
                <div class="mb-5 text-sm relative z-50">
                    Contact your host if you are not sure of these information
                </div>
                <div class="flex relative z-50">
                    <button class="ml-auto text-sticker">{{ __('Proceed') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection