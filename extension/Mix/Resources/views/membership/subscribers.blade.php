@extends('mix::layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">{{ __('Subscribers') }} - {{ $membership->name }}</h2>
                <p class="text-muted">{{ __('Manage active subscriptions for this plan') }}</p>
            </div>
            <a href="{{ route('user-mix-membership-index') }}" class="btn btn-secondary">
                <i class="la la-arrow-left"></i> {{ __('Back to Plans') }}
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Contact') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Started At') }}</th>
                                <th>{{ __('Expires At') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscriptions as $sub)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm mr-3">
                                                <span class="avatar-title rounded-circle bg-primary">{{ substr($sub->contact->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $sub->contact->name }}</h6>
                                                <small class="text-muted">{{ $sub->contact->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($sub->payment_status === 'active')
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @elseif($sub->payment_status === 'pending')
                                            <span class="badge badge-warning">{{ __('Pending') }}</span>
                                        @elseif($sub->payment_status === 'cancelled')
                                            <span class="badge badge-danger">{{ __('Cancelled') }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $sub->payment_status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $sub->started_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if($sub->expires_at)
                                            {{ $sub->expires_at->format('d/m/Y') }}
                                        @else
                                            <span class="text-success">&infin; {{ __('Lifetime') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" type="button" data-toggle="dropdown">
                                                <i class="la la-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item text-danger" href="#">{{ __('Cancel Subscription') }}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="la la-users la-3x mb-3"></i>
                                            <p>{{ __('No active subscribers found.') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $subscriptions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
