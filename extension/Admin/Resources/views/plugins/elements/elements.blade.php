@extends('admin::layouts.master')
@section('title', __('Element Plugins'))
@section('namespace', 'admin-payments-elements')
@section('content')
<div class="sandy-page-row">
    <div class="sandy-page-col pl-0">
        <div class="page__head">
            <div class="step-banner remove-shadow">
                <div class="section-header">
                    <div class="section-header-info">
                        <p class="section-pretitle">{{ __('Elements') }}</p>
                        <h2 class="section-title">{{ __('All Usable Elements') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5 page-trans rounded-2xl">
            
            <div class="flex-table mt-4">
                <!--Table header-->
                <div class="flex-table-header">
                    <span class="is-grow">{{ __('Method') }}</span>
                    <span>{{ __('Action') }}</span>
                </div>
                @foreach ($elements as $key => $item)
                <div class="flex-table-item rounded-2xl">
                    <div class="flex-table-cell is-media is-grow" data-th="">
                        {!! Elements::icon($key) !!}
                        <div>
                            <span class="item-name">{{ ao($item, 'name') }}</span>
                            <span class="m-0 c-gray text-xs mt-2">
                                <span>{{ ao($item, 'description') }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="flex-table-cell cell-end" data-th="{{ __('Actions') }}">
                        <a href="{{ route('admin-bio-elements-configure', ['element' => $key]) }}" app-sandy-prevent="" class="text-sticker mt-0 ml-auto md:ml-0">{{ __('Configure') }}</a>
                        <form action="{{ route('admin-bio-elements-delete') }}" method="post">
                            @csrf
                            <input type="hidden" name="plugin" value="{{ $key }}">
                            <button data-delete="{{ __('Do you want to delete this element?') }}" class="text-sticker bg-red-500 text-white mt-0 ml-2 flex items-center justify-center"><i class="sni sni-trash"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @if (!\App\License::has_full_license())
            <div class="flex mt-10 z-10 relative justify-center mb-5">
                
                <div class="card card_widget mb-0 md:w-2/4">
                    <div class="section-header">
                        <div class="section-header-info">
                            <div class="flex items-center mb-2">
                                <i class="sio web-hosting-052-error-page text-4xl"></i>
                            </div>
                            <p class="text-sm">{{ __('Cannot use more than 10 elements on a REGULAR version of this script.') }}</p>
                            <div class="section-header-actions mt-2">
                                <a href="{{ route('admin-license-index') }}" app-sandy-prevent="" class="section-header-action text-sticker bg-gray-200 text-white">{{ __('Update license') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="sandy-page-col sandy-page-col_pt100">
        <div class="card card_widget">
            <div class="card__head card__head_mb32">
                <div class="card__title h6 text-sm">{{ __('Upload') }}</div>
            </div>
            
            <div class="inner-page-banner h-32 mb-10 rounded-2xl">
                <h1 class="text-base">{{ __('Elements') }}</h1>
                <p>{{ __('Upload an element .zip to start using.') }}</p>
                <a href="#" target="_blank" class="mt-5 text-xs c-black font-bold href-link-button">{{ __('Get All Elements') }}</a>
            </div>
            <form action="{{ route('admin-bio-elements-upload') }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div data-generic-preview="">
                    <div class="h-avatar h-32 w-full is-upload is-outline-dark">
                        <i class="flaticon-upload-1"></i>
                        <input type="file" name="archive">
                        <div class="file-name"></div>
                    </div>
                </div>
                <div class="block">
                    <button class="text-sticker mt-5 mr-3 is-loader-submit flex items-center justify-center">{{ __('Upload') }}</button>
                    <p class="text-xs mt-5 italic">{{ __('(Note: it\'s essential to make all public if you install elements manually. Making public basically moves the assets & images of the elements to the public folder so it can be accessible by the element. If you use aws filesystem, this will also move the images & assets to aws.)') }}</p>
                    <a class="text-sticker mt-5 is-submit" href="{{ route('admin-bio-elements-make-all-public') }}" app-sandy-prevent="">{{ __('Make All Public') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection