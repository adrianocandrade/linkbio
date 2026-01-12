@extends('mix::layouts.master')
@section('title', __('Locations'))
@section('footerJS')
<script>
app.utils.country_locations = function(){
jQuery('[data-popup=".edit-location"]').on('dialog:open', function(e, $elem) {
var name = jQuery($elem).data('name');
var description = jQuery($elem).data('description');
var price = jQuery($elem).data('price');
var id = jQuery($elem).data('id');
var $dialog = jQuery(this);
$dialog.find('input, textarea').parent('.form-input').addClass('active');
$dialog.find('input[name="id"]').val(id);
$dialog.find('input[name="name"]').val(name);
$dialog.find('input[name="price"]').val(price);
$dialog.find('textarea[name="description"]').html(description);
});
}
app.utils.country_locations();
</script>
@stop
@section('content')
@includeIf('include.back-header', ['route' => route('sandy-blocks-shop-mix-shipping-index')])
<div class="mix-padding-10">
    <div class="info mb-5">
        <div class="avatar-upload sandy-upload-modal-open flex items-center mb-5">
            <div class="avatar rounded-2xl h-20 w-20 flex items-center justify-center">
                <img data-src="{{ \Country::icon($shipping->country_iso) }}" class="lozad m-0" alt="">
            </div>
            <div class="content">
                <h5>{{ $shipping->country }}</h5>
                <p class="text-xs text-gray-400 mt-2">{{ __('Add your shipping locations & prices.') }}</p>
            </div>
        </div>
    </div>
    @if ($locations->isEmpty())
    @include('include.is-empty', ['link' => ['class' => 'location-new-open', 'link' => '#', 'title' => 'New Location']])
    @endif
    <div class="flex-table mt-4">
        @foreach ($locations as $item)
        
        <div class="flex-table-item rounded-2xl">
            <div class="flex-table-cell is-media is-grow" data-th="">
                <div class="h-avatar sm">
                    <img data-src="{{ \Country::icon($shipping->country_iso) }}" class="lozad" alt="">
                </div>
                <div>
                    <span class="item-name dark-inverted is-font-alt is-weight-600">{{ $item->name }}</span>
                </div>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Price') }}">
                <span class="tag is-green is-rounded">{{ nr($item->price, 2, true) }}</span>
            </div>
            <div class="flex-table-cell" data-th="{{ __('Created On') }}">
                <span class="dark-inverted is-weight-600">{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</span>
            </div>
            <div class="flex-table-cell cell-end" data-th="Actions">
                <button class="sandy-expandable-btn ml-auto edit-location-open" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-description="{{ $item->description }}" data-price="{{ $item->price }}"><span>{{ __('Edit') }}</span></button>
                <form action="{{ route('sandy-blocks-shop-mix-shipping-location-delete', $item->id) }}" method="post">
                    @csrf
                    <button class="sandy-expandable-btn ml-2 bg-red-500 text-white" data-delete="{{ __('Are you sure you want to delete this location?') }}"><span>{{ __('Delete') }}</span></button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @if (!$locations->isEmpty())
    <a class="sandy-expandable-btn cursor-pointer location-new-open mt-5"><span>{{ __('New Location') }}</span></a>
    @endif
</div>
<div data-popup=".edit-location" class="half-short">
    <form action="{{ route('sandy-blocks-shop-mix-shipping-location-edit') }}" method="post">
        @csrf
        <input type="hidden" name="id">
        <div class="form-input mb-7 text-count-limit" data-limit="50">
            <label>{{ __('Name') }}</label>
            <span class="text-count-field"></span>
            <input type="text" name="name">
            <p class="text-xs text-gray-400 mt-2">{{ __('The name can be a city or state.') }}</p>
        </div>
        <div class="form-input text-count-limit mt-5" data-limit="200">
            <label>{{ __('Short Description') }}</label>
            <span class="text-count-field"></span>
            <textarea rows="4" name="description"></textarea>
        </div>
        <div class="form-input mt-5">
            <label>{{ __('Price') }}</label>
            <input type="number" name="price">
        </div>
        <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-10"><span>{{ __('Save') }}</span></button>
    </form>
</div>
<div data-popup=".location-new" class="half-short">
    <form action="{{ route('sandy-blocks-shop-mix-shipping-location-post', $shipping->id) }}" method="post">
        @csrf
        <div class="form-input mb-7 text-count-limit" data-limit="50">
            <label>{{ __('Name') }}</label>
            <span class="text-count-field"></span>
            <input type="text" name="name">
            <p class="text-xs text-gray-400 mt-2">{{ __('The name can be a city or state.') }}</p>
        </div>
        <div class="form-input text-count-limit mt-5" data-limit="200">
            <label>{{ __('Short Description') }}</label>
            <span class="text-count-field"></span>
            <textarea rows="4" name="description"></textarea>
        </div>
        <div class="form-input mt-5">
            <label>{{ __('Price') }}</label>
            <input type="number" name="price">
        </div>
        <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-10"><span>{{ __('Save') }}</span></button>
    </form>
</div>
@endsection