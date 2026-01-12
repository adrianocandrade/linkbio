@extends('mix::layouts.master')
@section('title', __('Edit Product'))
@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}" data-barba-script></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}" data-barba-script></script>
<script data-barba-script>
app.utils.Smalltinymce();
</script>
<script>
app.utils.edit_variant = function(){
jQuery('[data-popup=".variant-edit"]').on('dialog:open', function(e, $elem) {
var amount = jQuery($elem).data('amount');
var quantity = jQuery($elem).data('quantity');
var description = jQuery($elem).data('description');
var name = jQuery($elem).data('name');
var id = jQuery($elem).data('id');
var $dialog = jQuery(this);
$dialog.find('input, textarea').parent('.form-input').addClass('active');
$dialog.find('input[name="variant_id"]').val(id);
$dialog.find('input[name="amount"]').val(amount);
$dialog.find('input[name="quantity"]').val(quantity);
$dialog.find('input[name="name"]').val(name);
$dialog.find('textarea[name="description"]').html(description);
});
}
app.utils.edit_variant();
</script>
@stop
@section('content')
@includeIf('include.back-header', ['route' => route('sandy-blocks-shop-mix-view'), 'can_save' => true])
<form method="post" action="{{ route('sandy-blocks-shop-mix-edit-product-post', $product->id) }}" class="mix-padding-10  dy-submit-header" enctype="multipart/form-data">
    @csrf

    <div class="dashboard-header-banner relative mt-0 mb-5">
		<div class="card-container">
			
			<div class="text-lg font-bold">{{ __('Edit Product') }}</div>
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
                        <div class="avatar rounded-2xl h-20 w-20 flex items-center justify-center">
                            {!! media_or_url($product->banner, 'media/shop/banner', true) !!}
                        </div>
                        <input type="file" class="avatar-upload-input" name="banner">
                        <div class="content text-right">
                            <h5>{{ __('Banner') }}</h5>
                            <p class="text-sticker">{{ __('Browse') }}</p>
                        </div>
                    </div>
                    <div class="form-input mb-5">
                        <label>{{ __('Name') }}</label>
                        <input type="text" class="bg-w" value="{{ $product->name }}" name="name">
                    </div>
                    <div class="bio-tox is-white form-input">
                        <label>{{ __('Description') }}</label>
                        <textarea name="description" class="bg-w editor" id="" cols="30" rows="10">{{ $product->description }}</textarea>
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
                            <option value="1" {{ $product->price_type == 1 ? 'selected' : '' }}>{{ __('Fixed Price') }}</option>
                            <option value="2" {{ $product->price_type == 2 ? 'selected' : '' }}>{{ __('Membership') }}</option>
                        </select>
                    </div>
                    <div class="select-shift">
                        <div data-sandy-open="1" class="hide">
                            <div class="form-input">
                                <label>{{ __('Price') }}</label>
                                <input type="number" name="price" value="{{ $product->price }}" class="bg-w">
                            </div>
                            <div class="rounded-2xl relative z-10 mt-5">
                                <div class="form-input">
                                    <label>{{ __('Compare Price') }}</label>
                                    <input type="number" name="compare_price" value="{{ $product->comparePrice }}" class="bg-w">
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-5">{!! __t('Display discounts off your regular prices. For example, <del>$35</del>, $29. This field is optional.') !!}</p>
                        </div>
                        <div data-sandy-open="2" class="hide">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="form-input">
                                    <label>{{ __('Monthly') }}</label>
                                    <input type="number" value="{{ ao($product->extra, 'price_monthly') }}" name="extra[price_monthly]" class="bg-w">
                                </div>
                                <div class="form-input">
                                    <label>{{ __('Annual') }}</label>
                                    <input type="number" name="extra[price_annual]" value="{{ ao($product->extra, 'price_annual') }}" class="bg-w">
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
                            <input type="hidden" name="stock[enable]" value="0">
                            <input class="sandy-switch-input" name="stock[enable]" {{ ao($product->stock_settings, 'enable') ? 'checked' : '' }} value="1" type="checkbox" >
                            <span class="sandy-switch-in"><span class="sandy-switch-box is-white"></span></span>
                        </label>
                    </div>
                </div>
                <div class="mort-main-bg p-5 rounded-2xl relative z-10 mt-5">
                    <div class="rounded-2xl relative z-10 mt-5">
                        <div class="form-input">
                            <label class="initial">{{ __('Stock') }}</label>
                            <input type="number" name="product_stock" value="{{ $product->stock }}" class="bg-w" placeholder="∞">
                        </div>
                    </div>
                    <div class="rounded-2xl relative z-10 mt-5">
                        <div class="form-input">
                            <label>{{ __('Sku') }}</label>
                            <input type="number" name="stock[sku]" value="{{ ao($product->stock_settings, 'sku') }}" class="bg-w">
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
                            <input class="sandy-switch-input" name="productType" {{ $product->productType ? 'checked' : '' }} value="1" type="checkbox" >
                            <span class="sandy-switch-in"><span class="sandy-switch-box is-white"></span></span>
                        </label>
                    </div>
                </div>
                
                @if (is_array($product->files))
                    @foreach ($product->files as $key => $value)
                    <div class="text-sticker rounded-2xl mb-3 w-full justify-between items-center p-3 h-full">
                        <p class="is-link truncate">{{ $value }}</p>

                        <a class="text-sticker m-0 bg-red-400 text-white" app-sandy-prevent="" href="{{ route('sandy-blocks-shop-mix-delete-product-file', ['id' => $product->id, 'file' => $value]) }}" data-delete="{{ __('Are you sure you want to delete this file?') }}"><span>{{ __('Delete') }}</span></a>
                    </div>
                    @endforeach
                @else
                <p class="text-gray-400 text-xs">{{ __('Downloadables has not been set by this page.') }}</p>
                @endif
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
                            <input class="sandy-switch-input" name="seo[enable]" {{ ao($product->seo, 'enable') ? 'checked' : '' }} value="1" type="checkbox" >
                            <span class="sandy-switch-in"><span class="sandy-switch-box is-white"></span></span>
                        </label>
                    </div>
                </div>
                
                <div class="card customize mb-10">
                    <div class="card-header">
                        <div class="form-input mb-7 text-count-limit" data-limit="55">
                            <label>{{ __('Page Name') }}</label>
                            <span class="text-count-field"></span>
                            <input type="text" name="seo[page_name]" value="{{ ao($product->seo, 'page_name') }}" class="bg-w">
                        </div>
                        
                        <div class="form-input text-count-limit" data-limit="400">
                            <label>{{ __('Page Description') }}</label>
                            <span class="text-count-field"></span>
                            <textarea rows="4" name="seo[page_description]" class="bg-w">{{ ao($product->seo, 'page_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sandy-tabs-item">
                
                <div class="my-7">
                    <div class="text-lg font-bold">{{ __('Variation') }}</div>
                    <p class="text-gray-400 text-xs">{{ __('Note that variations will cancel out the item default price.') }}</p>
                </div>
                <div class="mt-5 mb-5">
                    <div class="grid grid-cols-1 gap-7 relative z-10 sortable" data-route="{{ route('sandy-blocks-shop-mix-sort-variant') }}" data-handle=".variant-move">
                        @forelse ($variant as $item)
                        <div class="p-5 product-variant-edit flex items-center card card_widget card-inherit remove-after sortable-item" bg-style="#e8e8e8" data-id="{{ $item->id }}">
                            <div class="variant-move mr-2 cursor-move">
                                <img src="{{ gs('assets/image/others/drag-asset.png') }}" class="w-2" alt="">
                            </div>
                            <div class="truncate">
                                
                                <p class="text-gray-600 text-sm truncate">{{ $item->name }}</p>
                            </div>
                            <div class="flex ml-auto">
                                <a class="text-sticker cursor-pointer variant-edit-open bg-white" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-description="{{ $item->description }}" data-amount="{{ $item->price }}" data-quantity="{{ $item->stock }}"><span><i class="la la-pencil"></i></span></a>
                                <a class="text-sticker ml-2 bg-white" href="{{ route('sandy-blocks-shop-mix-delete-variant', $item->id) }}" data-delete="{{ __('Are you sure you want to delete this variant?') }}" app-sandy-prevent=""><span><i class="la la-trash"></i></span></a>
                            </div>
                        </div>
                        @empty
                        @include('include.is-empty')
                        @endforelse
                    </div>
                </div>
                <a class="text-sticker cursor-pointer variant-new-open"><span>{{ __('Add Variant') }}</span></a>
            </div>
        </div>
        <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-10">{{ __('Save') }}</button>
    </div>
    
    {!! sandy_upload_modal($product->banner, 'media/shop/banner') !!}
</form>
<form action="{{ route('sandy-blocks-shop-mix-delete-product', $product->id) }}" method="post" class="mix-padding-10 pt-0">
    @csrf
    <button data-delete="{{ __('Are you sure you want to delete this product?') }}" class="shadow-none w-full button bg-red-400 text-white toast-custom-close sandy-loader-flower">{{ __('Delete') }}</button>
</form>
<div class="half-short" data-popup=".variant-edit">
    <form action="{{ route('sandy-blocks-shop-mix-edit-variant') }}" method="post">
        @csrf
        <input type="hidden" name="variant_id">
        <div class="mb-7">
            <div class="text-lg font-bold">{{ __('Edit Variation') }}</div>
            <p class="text-gray-400 text-xs">{{ __('Modify or Edit this current variation.') }}</p>
        </div>
        <div class="form-input mb-5">
            <label>{{ __('Variant name') }}</label>
            <input type="text" name="name">
        </div>
        <div class="form-input mb-5">
            <label>{{ __('Description') }}</label>
            <textarea name="description" cols="30" rows="10"></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            
            <div class="form-input">
                <label class="initial">{{ __('Amount') }}</label>
                <input type="number" name="amount">
            </div>
            <div class="form-input">
                <label class="initial">{{ __('Stock') }}</label>
                <input type="number" name="quantity" placeholder="∞">
            </div>
        </div>

        <p class="mt-3 text-gray-400 text-xs">{{ __('Note, if you enable stock on product, it is required for you to add the quantity on variation as it will manage the variation stock for you.') }}</p>
        <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-5">{{ __('Save') }}</button>
    </form>
</div>
<div class="half-short" data-popup=".variant-new">
    <form action="{{ route('sandy-blocks-shop-mix-create-variant') }}" method="post">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="mb-7">
            <div class="text-lg font-bold">{{ __('New Variation') }}</div>
            <p class="text-gray-400 text-xs">{{ __('Add a new product variant.') }}</p>
        </div>
        <div class="form-input mb-5">
            <label>{{ __('Variant name') }}</label>
            <input type="text" name="name">
        </div>
        <div class="form-input mb-5">
            <label>{{ __('Description') }}</label>
            <textarea name="description" cols="30" rows="10"></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            
            <div class="form-input">
                <label class="initial">{{ __('Amount') }}</label>
                <input type="number" name="amount">
            </div>
            <div class="form-input">
                <label class="initial">{{ __('Stock') }}</label>
                <input type="number" name="quantity" placeholder="∞">
            </div>
        </div>
        <p class="mt-3 text-gray-400 text-xs">{{ __('Note, if you enable stock on product, it is required for you to add the quantity on variation as it will manage the variation stock for you.') }}</p>
        <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-5">{{ __('Save') }}</button>
    </form>
</div>
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