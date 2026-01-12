@extends('admin::layouts.master')
@section('title', __('General Plugins'))
@section('namespace', 'admin-general-plugins')@section('footerJS')
<script>
    app.utils.plugin_license = function(){
        jQuery('[data-popup=".add-license"]').on('dialog:open', function(e, $elem) {
            var plugin = jQuery($elem).data('plugin');
            var $dialog = jQuery(this);
            $dialog.find('input[name="plugin"]').val(plugin);
        });
    }
    app.utils.plugin_license();
</script>
@stop
@section('content')
<div class="sandy-page-row">
    <div class="sandy-page-col pl-0">
        <div class="page__head">
            <div class="step-banner remove-shadow">
                <div class="section-header">
                    <div class="section-header-info">
                        <p class="section-pretitle">{{ __('General') }}</p>
                        <h2 class="section-title">{{ __('All Plugins') }}</h2>
                        <div class="notifications__tags m-0 mt-5">
                            <a class="notifications__link active" href="https://purchase.sandydev.com" target="_blank">{{ __('Get More Plugins') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5 page-trans rounded-2xl">
            
            <div class="flex-table mt-4">
                <!--Table header-->
                <div class="flex-table-header">
                    <span class="is-grow">{{ __('Plugin') }}</span>
                    <span class="ml-auto">{{ __('Action') }}</span>
                </div>
                @foreach ($plugins as $key => $item)
                <div class="flex-table-item rounded-2xl">
                    <div class="flex-table-cell is-media is-grow" data-th="">
                        <div class="h-avatar is-medium mr-4 is-video bg-white text-black">
                            <i class="{{ $getItem($item, 'thumbnail') }} text-5xl"></i>
                        </div>
                        <div>
                            <span class="item-name dark-inverted is-font-alt is-weight-600 flex items-center">
                                {{ $getItem($item, 'name') }}
                                <span class="text-xs italic ml-2">(V{{ $getItem($item, 'version') }})</span>
                            </span>
                            <span class="item-meta text-xs mt-2">
                                <span>{{ $getItem($item, 'description') }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="flex-table-cell cell-end" data-th="{{ __('Actions') }}">
                        <div class="ml-auto">
                            @if (!\SandyLicense::has_plugin_license($key))
                                <a class="text-sticker mb-2 text-white bg-gray-500 add-license-open cursor-pointer" data-plugin="{{ $key }}">{{ __('Add License') }}</a>
                            @endif

                            <form action="{{ route('admin-plugins-delete') }}" method="post" class="flex">
                                @csrf
                                <input type="hidden" name="plugin" value="{{ $key }}">
                                <button data-delete="{{ __('Do you want to delete this plugin?') }}" class="text-sticker bg-red-500 text-white mt-0 ml-auto">{{ __('Delete') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="sandy-page-col sandy-page-col_pt100">
        <div class="card card_widget">
            <div class="card-header mb-5">
                <i class="sio network-icon-050-cloud-uploading mb-5 text-5xl"></i>
                <p class="text-sm uppercase">{{ __('Upload a plugin') }}</p>
            </div>
            
            <form action="{{ route('admin-plugins-upload') }}" method="post" enctype="multipart/form-data">
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
<div data-popup=".add-license">
    <div class="flex items-center">
        
        <img data-src="{{ gs('assets/image/others', 'gumroad-icon.png') }}" class="lozad w-8" alt="">
        <div class="ml-4">
            <div class="h6">{{ __('Gumroad') }}</div>
            <p class="mt-0">{{ __('Add your purchase license to activate this plugin before you use.') }}</p>
        </div>
    </div>

    
</div>
@endsection