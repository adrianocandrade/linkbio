@extends('admin::layouts.master')
@section('title', __('All Themes'))
@section('content')
<div class="sandy-page-row">
    <div class="sandy-page-col pl-0">
        <div class="page__head">
            <div class="step-banner remove-shadow">
                <div class="section-header">
                    <div class="section-header-info">
                        <p class="section-pretitle">{{ __('Themes') }}</p>
                        <h2 class="section-title">{{ __('All Themes') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5 page-trans rounded-2xl">
            
            <div class="flex-table mt-4">
                <!--Table header-->
                <div class="flex-table-header">
                    <span class="is-grow">{{ __('Theme') }}</span>
                    <span></span>
                    <span>{{ __('Action') }}</span>
                </div>
                @foreach (\BioStyle::getAll() as $key => $item)
                <div class="flex-table-item rounded-2xl">
                    <div class="flex-table-cell is-media is-grow" data-th="">
                        <div class="h-avatar md">
                            <img src="{{ gs("assets/image/theme/$key", ao($item, 'cover')) }}" alt="">
                        </div>
                        <div>
                            <span class="item-name">{{ ao($item, 'name') }}</span>
                            <span class="m-0 c-gray text-xs mt-2">
                                <span>{{ ao($item, 'description') }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="flex-table-cell"></div>
                    <div class="flex-table-cell cell-end" data-th="{{ __('Actions') }}">
                        <a href="{{ route('sandy-plugins-user_util-themes-edit', $key) }}" app-sandy-prevent="" class="text-sticker mt-0 ml-auto md:ml-0 mr-4"><i class="sio office-087-highlighter text-xl mr-4"></i> {{ __('Configure') }}</a>
                        <form action="{{ route('sandy-plugins-user_util-themes-delete', $key) }}" method="POST">
                            @csrf

                            <button data-delete="{{ __('Delete this theme?') }}" class="text-sticker mt-0 bg-red-500 text-white"><i class="sio media-icon-017-dustbin text-xl"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="sandy-page-col sandy-page-col_pt100">
        <div class="card card_widget">
            <div class="card-header mb-5">
                <p class="text-sm uppercase">{{ __('Upload') }}</p>
                <p class="subtitle text-xs">{{ __('Upload a new user theme.') }}</p>
            </div>
            
            <form action="{{ route('sandy-plugins-user_util-themes-upload') }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div data-generic-preview="">
                    <div class="h-avatar h-32 w-full is-upload is-outline-dark">
                        <i class="flaticon-upload-1"></i>
                        <input type="file" name="archive">
                        <div class="file-name"></div>
                    </div>
                </div>

                <button class="text-sticker bg-gray text-white is-loader-submit loader-white flex items-center justify-center mt-5">{{ __('Upload') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection