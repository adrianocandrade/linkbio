@extends('install::layouts.master')
@section('content')
<div class="m-auto">
    <div class="relative z-50">
        
        <div class="card is-install-card card_widget mx-5 md:mx-20 p-0 card-shadow">
            <div class="card-container">

                <div class="side-cta is-small">
                    <img src="{{ gs('assets/image/others/Asset-555.png') }}" alt="">
                </div>
                <div class="flex items-center mb-3">
                    <i class="text-3xl sio project-management-020-text-document mr-3"></i>
                </div>
                <p class="mb-3">Before you get started with this script, we would need the following items.</p>
                <div class="tiny-content-init mb-5">
                    
                    <ol>
                        <li class="font-bold">Database host</li>
                        <li class="font-bold">Database name</li>
                        <li class="font-bold">Database username</li>
                        <li class="font-bold">Database password</li>
                    </ol>
                </div>
                <div class="mb-5 text-sm relative z-50">
                    Note: This installation just update the info in the .env file found in your base dir. If for any reason the installation fails, just fill your database info in the .env file and proceed to visit <a href="{{ route('install-steps-database-migrate') }}" class="text-link">here</a> to migrate the database & <a href="{{ route('install-steps-user') }}" class="text-link">here</a> to create a default user.
                </div>
                <div class="mb-5 text-sm relative z-50">
                    Note: If you installed manually, update the values in the .env : <b>SESSION_DRIVER="database"</b> & <b>APP_INSTALL="1"</b>
                </div>
                <div class="mb-5 text-sm">
                    Wanna check the server <a href="#" class="text-link requirements-open">requirements?</a>
                </div>
                <div class="flex z-50 relative">
                    @if ($passed)
                    
                    <a class="ml-auto text-sticker" href="{{ route('install-steps-database') }}">{{ __('Proceed') }}</a>
                    @else
                    <a class="ml-auto text-sticker requirements-open disabled" disabled href="#">{{ __('Requirements') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div data-popup=".requirements" class="p-0">
    <div class="sandy-dialog-body sandy-dialog-overflow dialog-overflow-all-height">
        <div class="mort-main-bg p-5 flex items-center rounded-2xl mb-5">
            
            <div class="heading has-icon">
                <i class="sio database-and-storage-002-server text-3xl mr-2"></i>
                {{ __('Requirements') }}
            </div>
        </div>
        <table class="custom-table">
            <tbody>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Message') }}</th>
                    <th>{{ __('Status') }}</th>
                </tr>
                @foreach ($requirements as $key => $item)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ ao($item, 'message') }}</td>
                    <td>{{ ao($item, 'current') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mort-main-bg p-5 flex items-center rounded-2xl my-5">
            
            <div class="heading has-icon">
                <i class="sio database-and-storage-002-server text-3xl mr-2"></i>
                {{ __('Permissions') }}
            </div>
        </div>
        <table class="custom-table">
            <tbody>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Message') }}</th>
                    <th>{{ __('Status') }}</th>
                </tr>
                @foreach ($writable as $key => $item)
                <tr>
                    <td>{{ ao($item, 'dir') }}</td>
                    <td>{{ ao($item, 'message') }}</td>
                    <td>{{ ao($item, 'writable') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <button type="button" class="requirements-close" data-close-popup><i class="flaticon-close"></i></button>
</div>
@endsection