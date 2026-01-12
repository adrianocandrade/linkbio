@extends('admin::layouts.master')
@section('title', __('Edit Docs'))
@section('content')
<div class="sandy-page-row">
    <div class="sandy-page-col pl-0">
        <div class="page__head">
            <div class="section-header mb-10">
                <div class="section-header-info">
                    <p class="section-pretitle">{{ __('Edit Documentation') }}</p>
                    <h2 class="section-title">{{ __('Edit Category') }}</h2>
                </div>
                <div class="section-header-actions">
                    <a href="{{ route('admin-docs-index') }}" class="section-header-action">{{ __('All Docs') }}</a>
                </div>
            </div>
        </div>

    <form method="post" action="{{ route('admin-docs-edit', $docs->id) }}">
        @csrf
        <div class="col-span-2">
            <div class="card-shadow p-5 rounded-2xl">
                <div class="card cuztomize mb-0 p-5 mort-main-bg rounded-2xl">
                    <div class="form-input">
                        <label for="">{{ __('Name') }}</label>
                        <input type="text" class="bg-w" value="{{ $docs->name }}" name="name">
                    </div>
                </div>
                <div class="promotion__body px-0 pb-0">
                    <button class="promotion__btn button">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </form>
    </div>
    <div class="sandy-page-col sandy-page-col_pt100">
        <div class="card card_widget">
            <div class="card__head card__head_mb32">
                <div class="card__title h6">{{ __('Info') }}</div>
            </div>


            <div class="flex items-center">
                <i class="text-2xl sio banking-finance-flaticon-097-information-sign mr-3"></i>
                <p>{{ __('Use the field to add a new Documentation Category. Please fill in the required information.') }}</p>
            </div>

            <a class="button sandy-quality-button" href="{{ route('admin-docs-index') }}">{{ __('Documentation') }}</a>
        </div>
    </div>
</div>
@endsection