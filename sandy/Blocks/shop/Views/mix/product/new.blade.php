@extends('mix::layouts.master')
@section('title', __('New Product'))
@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}" data-barba-script></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}" data-barba-script></script>
<script data-barba-script>
app.utils.Smalltinymce();
</script>
@stop
@section('content')
@includeIf('include.back-header', ['route' => route('sandy-blocks-shop-mix-view'), 'can_save' => true])
<form method="post" action="{{ route('sandy-blocks-shop-mix-new-product-post') }}" class="mix-padding-10 dy-submit-header" enctype="multipart/form-data">
    @csrf


    <div class="dashboard-header-banner relative mt-0 mb-5">
		<div class="card-container">
			
			<div class="text-lg font-bold">{{ __('Create Product') }}</div>
            <div class="side-cta">
                <img src="{{ gs('assets/image/emoji/Yellow-1/Happy.png') }}" alt="">
            </div>
		</div>
	</div>

    <div class="subtab-wrapper sandy-tabs mt-10">
		<div class="flex items-baseline justify-between">
			<div class="flex max-w-100 overflow-auto">
				<a class="subtab sandy-tabs-link active">{{ __('Basic') }}</a>
				<a class="subtab sandy-tabs-link">{{ __('Files') }}</a>
				<a class="subtab sandy-tabs-link hidden">{{ __('Seo') }}</a>
				<a class="subtab sandy-tabs-link">{{ __('Variation') }}</a>
			</div>
		</div>

		<div class="tab-title-divider"></div>
        <div class="tab-body">
            <div class="sandy-tabs-item">
                <div class="mort-main-bg p-5 rounded-2xl">
                    
                    <div class="avatar-upload sandy-upload-modal-open flex justify-between items-center mb-5">
                        <div class="avatar rounded-2xl h-20 w-20">
                            <div class="image lozad rounded-2xl"></div>
                        </div>
                        <input type="file" class="avatar-upload-input" name="banner">
                        <div class="content text-right">
                            <h5>{{ __('Banner') }}</h5>
                            <p class="text-sticker">{{ __('Browse') }}</p>
                        </div>
                    </div>
                    <div class="form-input mb-5">
                        <label>{{ __('Name') }}</label>
                        <input type="text" class="bg-w" name="name">
                    </div>
                    <div class="bio-tox is-white form-input">
                        <label>{{ __('Description') }}</label>
                        <textarea name="description" class="bg-w editor" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="my-7">
                    <div class="text-lg font-bold">{{ __('Price') }}</div>
                    <p class="text-gray-400 text-xs">{{ __('Setup your product pricing options. Leave empty for free product.') }}</p>
                </div>
                <div class="mort-main-bg p-5 rounded-2xl relative z-10 mt-5">
                    <div class="form-input mb-5">
                        <label class="initial">{{ __('Price Type') }}</label>
                        <select name="price_type" class="bg-w" data-sandy-select=".select-shift">
                            <option value="1">{{ __('Fixed Price') }}</option>
                            <option value="2">{{ __('Membership') }}</option>
                        </select>
                    </div>
                    <div class="select-shift">
                        <div data-sandy-open="1" class="hide">
                            <div class="form-input">
                                <label>{{ __('Price') }}</label>
                                <input type="number" name="price" class="bg-w">
                            </div>
                            <div class="rounded-2xl relative z-10 mt-5">
                                <div class="form-input">
                                    <label>{{ __('Compare Price') }}</label>
                                    <input type="number" name="compare_price" class="bg-w">
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-5">{!! __t('Display discounts off your regular prices. For example, <del>$35</del>, $29. This field is optional.') !!}</p>
                        </div>
                        <div data-sandy-open="2" class="hide">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="form-input">
                                    <label>{{ __('Monthly') }}</label>
                                    <input type="number" name="extra[price_monthly]" class="bg-w">
                                </div>
                                <div class="form-input">
                                    <label>{{ __('Annual') }}</label>
                                    <input type="number" name="extra[price_annual]" class="bg-w">
                                </div>
                            </div>
                            <p class="text-sm mt-4">{{ __('Note: recurring payments are only available if your current payment method supports recurring.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="my-7">
                    <div class="text-lg font-bold">{{ __('Stock') }}</div>
                    <p class="text-gray-400 text-xs">{{ __('Setup your product stock. Let our system manage stock for you. You can disable stock if you dont want it to show.') }}</p>
                </div>
                <div class="card customize mb-5">
                    <div class="card-header flex justify-between">
                        <p class="title mb-0">{{ __('Enable Stock') }}</p>
                        <label class="sandy-switch">
                            <input type="hidden" name="stock[enasble]" value="0">
                            <input class="sandy-switch-input" name="stock[enable]" value="1" type="checkbox" >
                            <span class="sandy-switch-in"><span class="sandy-switch-box is-white"></span></span>
                        </label>
                    </div>
                </div>
                <div class="mort-main-bg p-5 rounded-2xl relative z-10 mt-5">
                    <div class="rounded-2xl relative z-10 mt-5">
                        <div class="form-input">
                            <label>{{ __('Stock') }}</label>
                            <input type="number" name="product_stock" class="bg-w">
                        </div>
                    </div>
                    <div class="rounded-2xl relative z-10 mt-5">
                        <div class="form-input">
                            <label>{{ __('Sku') }}</label>
                            <input type="number" name="stock[sku]" class="bg-w">
                        </div>
                    </div>
                </div>
            </div>
            <div class="sandy-tabs-item">
                <div class="my-7">
                    <div class="text-lg font-bold">{{ __('Downloadables') }}</div>
                    <p class="text-gray-400 text-xs">{{ __('Enabling downloadable file(s) will change the product type. Users cannot purchase more than one at a time.') }}</p>
                </div>
                <div class="card customize mb-5">
                    <div class="card-header flex justify-between">
                        <p class="title mb-0">{{ __('Enable Downloadable') }}</p>
                        <label class="sandy-switch">
                            <input name="productType" value="0" type="hidden" >
                            <input class="sandy-switch-input" name="productType" value="1" type="checkbox" >
                            <span class="sandy-switch-in"><span class="sandy-switch-box is-white"></span></span>
                        </label>
                    </div>
                </div>
                <div class="sandy-upload-v2 mb-5 cursor-pointer" data-generic-preview="">
                    <input type="file" name="downloadable_files">
                    <div class="image-con">
                        <div class="image"></div>
                        <div class="file-name"></div>
                    </div>
                    <div class="info">
                        {{ __('Files') }}
                    </div>
                    <div class="add-button">
                        {{ __('Add') }}
                    </div>
                </div>
            </div>
            <div class="sandy-tabs-item hidden">
                <div class="card customize mb-5">
                    <div class="card-header flex justify-between">
                        <p class="title mb-0">{{ __('Enable custom seo info') }}</p>
                        <label class="sandy-switch">
                            <input type="hidden" name="seo[enable]" value="0">
                            <input class="sandy-switch-input" name="seo[enable]" value="1" type="checkbox" >
                            <span class="sandy-switch-in"><span class="sandy-switch-box is-white"></span></span>
                        </label>
                    </div>
                </div>
                
                <div class="card customize mb-10">
                    <div class="card-header">
                        <div class="form-input mb-7 text-count-limit" data-limit="55">
                            <label>{{ __('Page Name') }}</label>
                            <span class="text-count-field"></span>
                            <input type="text" name="seo[page_name]" class="bg-w">
                        </div>
                        
                        <div class="form-input text-count-limit" data-limit="400">
                            <label>{{ __('Page Description') }}</label>
                            <span class="text-count-field"></span>
                            <textarea rows="4" name="seo[page_description]" class="bg-w"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sandy-tabs-item">
                
                <div class="my-7">
                    <div class="text-lg font-bold">{{ __('Variation') }}</div>
                    <p class="text-gray-400 text-xs">{{ __('Save the product to add variations.') }}</p>
                </div>
            </div>
        </div>
        <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-10">{{ __('Save') }}</button>
    </div>
    
    {!! sandy_upload_modal() !!}
</form>
<div data-dynamic-template hidden>
    <div class="mb-5" data-dynamic-item="" data-items-name="ribbon">
        <div class="flex">
            
            <div class="form-input w-full mr-4">
                <label class="">{{ __('Ribbon') }}</label>
                <input type="text" data-item-name="ribbon">
            </div>
            <a class="ml-auto flex items-center cursor-pointer" data-dynamic-remove><i class="flaticon-delete"></i></a>
        </div>
    </div>
</div>
@endsection