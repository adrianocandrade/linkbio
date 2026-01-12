@extends('mix::layouts.master')
@section('title', isset($plan) ? __('Edit Plan') : __('Create Plan'))
@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}" data-barba-script></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}" data-barba-script></script>
<script data-barba-script>
app.utils.Smalltinymce();
</script>
@stop
@section('content')

@includeIf('include.back-header', ['route' => route('user-mix-membership-index'), 'can_save' => true])

<form action="{{ isset($plan) ? route('user-mix-membership-update', $plan->id) : route('user-mix-membership-store') }}" method="POST" class="mix-padding-10 dy-submit-header">
    @csrf

    <div class="dashboard-header-banner relative mt-0 mb-5">
		<div class="card-container">
			
			<div class="text-lg font-bold">{{ isset($plan) ? __('Edit Plan') : __('Create Plan') }}</div>
            <div class="side-cta">
                <img src="{{ gs('assets/image/emoji/Yellow-1/Piggy-Bank.png') }}" alt="">
            </div>
		</div>
	</div>

    <div class="subtab-wrapper sandy-tabs mt-10">
		<div class="flex items-baseline justify-between">
			<div class="flex max-w-100 overflow-auto">
				<a class="subtab sandy-tabs-link active">{{ __('Basic') }}</a>
				<a class="subtab sandy-tabs-link">{{ __('Settings') }}</a>
			</div>
		</div>

		<div class="tab-title-divider"></div>
        <div class="tab-body">
            <!-- Basic Tab -->
            <div class="sandy-tabs-item">
                <div class="mort-main-bg p-5 rounded-2xl">
                    
                    <div class="form-input mb-5">
                        <label>{{ __('Plan Name') }}</label>
                        <input type="text" class="bg-w" name="name" value="{{ old('name', $plan->name ?? '') }}" required>
                    </div>
                    <div class="bio-tox is-white form-input">
                        <label>{{ __('Description') }}</label>
                        <textarea name="description" class="bg-w editor" id="" cols="30" rows="10">{{ old('description', $plan->description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="my-7">
                    <div class="text-lg font-bold">{{ __('Pricing') }}</div>
                    <p class="text-gray-400 text-xs">{{ __('Set the price and billing cycle for this plan.') }}</p>
                </div>

                <div class="mort-main-bg p-5 rounded-2xl relative z-10 mt-5">
                    <div class="form-input mb-5">
                        <label>{{ __('Price') }}</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $plan->price ?? '') }}" class="bg-w" required>
                    </div>
                    
                    <div class="form-input">
                        <label>{{ __('Billing Cycle') }}</label>
                        <select name="billing_cycle" class="bg-w">
                            <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle ?? '') == 'monthly' ? 'selected' : '' }} selected>{{ __('Monthly') }}</option>
                            <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle ?? '') == 'yearly' ? 'selected' : '' }}>{{ __('Yearly') }}</option>
                            <option value="lifetime" {{ old('billing_cycle', $plan->billing_cycle ?? '') == 'lifetime' ? 'selected' : '' }}>{{ __('One Time (Lifetime)') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Settings Tab -->
            <div class="sandy-tabs-item">
                <div class="my-7">
                    <div class="text-lg font-bold">{{ __('Status') }}</div>
                    <p class="text-gray-400 text-xs">{{ __('Manage the availability of this plan.') }}</p>
                </div>

                <div class="mort-main-bg p-5 rounded-2xl relative z-10 mt-5">
                    <div class="form-input">
                        <label>{{ __('Status') }}</label>
                        <select name="status" class="bg-w">
                            <option value="active" {{ (isset($plan) && $plan->status == 'active') ? 'selected' : '' }} selected>{{ __('Active') }}</option>
                            <option value="archived" {{ (isset($plan) && $plan->status == 'archived') ? 'selected' : '' }}>{{ __('Archived') }}</option>
                        </select>
                        <p class="text-xs text-gray-400 mt-2">{{ __('Archived plans cannot be purchased but existing subscriptions remain active.') }}</p>
                    </div>
                </div>

                @if(isset($plan))
                <div class="my-7">
                    <div class="text-lg font-bold text-red-500">{{ __('Danger Zone') }}</div>
                </div>
                <div class="mort-main-bg p-5 rounded-2xl relative z-10 mt-5 border border-red-100">
                    <button type="button" onclick="if(confirm('{{ __('Are you sure?') }}')) document.getElementById('delete-plan-form').submit();" class="text-red-500 font-bold hover:underline">
                        {{ __('Delete this plan') }}
                    </button>
                </div>
                @endif
            </div>

        </div>
        <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-10">{{ isset($plan) ? __('Update Plan') : __('Create Plan') }}</button>
    </div>
</form>

@if(isset($plan))
<form id="delete-plan-form" action="{{ route('user-mix-membership-delete', $plan->id) }}" method="POST" style="display: none;">
    @csrf
</form>
@endif

@endsection
