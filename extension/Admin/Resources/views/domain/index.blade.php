@extends('admin::layouts.master')
@section('title', __('Domain'))
@section('footerJS')
<script>
app.utils.update_domain = function(){
  jQuery('[data-popup=".edit-domain"]').on('dialog:open', function(e, $elem) {
    var protocol = jQuery($elem).data('protocol');
    var host = jQuery($elem).data('host');
    var id = jQuery($elem).data('id');
    var $dialog = jQuery(this);
    $dialog.find('input[name="id"]').val(id);
    $dialog.find('input[name="host"]').val(host);
    $dialog.find('select[name="protocol"] option[value="'+ protocol +'"]').prop('selected', true);
  });
}
app.utils.update_domain();
</script>
@stop
@section('content')
<div class="sandy-page-row">
  <div class="sandy-page-col pl-0">
    <div class="page__head">
      <div class="step-banner remove-shadow">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle">{{ __('Domain') }} ({{ number_format(\App\Models\Domain::count()) }})</p>
            <h2 class="section-title">{{ __('All Domains') }}</h2>
          </div>
        </div>
        <div class="search-results mt-5">
          <form class="search__form w-full" method="GET">
            <input class="search__input" type="text" value="{{ request()->get('query') }}" name="query" placeholder="{{ __('Search for host') }}">
            
            <button class="search__btn">
              <svg class="icon icon-search">
                <use xlink:href="{{ gs('assets/image/svg', 'sprite.svg#icon-search') }}"></use>
              </svg>
            </button>
          </form>
        </div>
      </div>
    </div>
    <div class="flex-table">
      <!--Table header-->
      <div class="flex-table-header">
        <span class="is-grow">{{ __('Domain') }}</span>
        <span>{{ __('Scheme') }}</span>
        <span class="cell-end">{{ __('Actions') }}</span>
      </div>
      @foreach ($domains as $domain)
      <div class="flex-table-item rounded-2xl overflow-x-auto">
        <div class="flex-table-cell is-media is-grow" data-th="">
          @if ($user = \App\User::find($domain->user))
          <div class="h-avatar md is-video" style="background: {{ao($user->settings, 'avatar_color')}}">
            <img class="avatar is-squared lozad" data-src="{{ avatar($user->id) }}" alt="">
          </div>
          <div>
            <span class="item-name mb-2">{{ $user->name }}</span>
            <span class="item-meta">
              <span>{{ "$domain->host" }}</span>
            </span>
          </div>
          @else
          <div>
            <span class="item-name mb-2">{{ $domain->scheme }}</span>
            <span class="item-meta">
              <span>{{ "$domain->host" }}</span>
            </span>
          </div>
          @endif
        </div>
        <div class="flex-table-cell" data-th="{{ __('Scheme') }}">
          <div class="ml-auto md:mx-auto">
            <a class="text-sticker m-0" href="{{ "$domain->scheme://$domain->host" }}" target="_blank">{{ "$domain->scheme://$domain->host" }}</a>
          </div>
        </div>
        <div class="flex-table-cell cell-end" data-th="{{ __('Actions') }}">
          <a href="#" class="text-3xl ml-auto edit-domain-open" data-id="{{ $domain->id }}" data-host="{{ $domain->host }}" data-protocol="{{ $domain->scheme }}"><i class="sio network-icon-016-pencil-tool sligh-thick"></i></a>
          <form action="{{ route('admin-domain-post', 'delete') }}" method="post">
            @csrf
            <input type="hidden" value="{{ $domain->id }}" name="id">
            <button data-delete="{{ __('Confirm deleting this domain.') }}" class="text-3xl ml-3"><i class="sio media-icon-017-dustbin sligh-thick text-red-500"></i></button>
          </form>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="sandy-page-col sandy-page-col_pt100">
    <div class="card card_widget">
      <div class="card__head card__head_mb32">
        <div class="card__title h6">{{ __('New Domain') }}</div>
      </div>
      <div class="card__filters mb-0">
        <form action="{{ route('admin-domain-post', 'new') }}" method="post" class="w-full">
          @csrf
          <div class="form-input">
            <label class="initial">{{ __('Protocol') }}</label>
            <select name="protocol">
              <option value="https">{{ __('HTTPS') }}</option>
              <option value="http">{{ __('HTTP') }}</option>
            </select>
          </div>
          <div class="form-input mt-5">
            <label class="initial">{{ __('Host') }}</label>
            <input type="text" name="host" placeholder="{{ __('Host without protocol ex: example.com') }}">
          </div>
          <button class="mt-5 text-sticker bg-gray-200">{{ __('Save') }}</button>
        </form>
        <p class="text-xs mt-5">{{ __('Make sure the domain cname is pointed to this site address.') }}</p>
      </div>
    </div>
  </div>
</div>
<div data-popup=".edit-domain">
  
  <form action="{{ route('admin-domain-post', 'edit') }}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="form-input">
      <label class="initial">{{ __('Protocol') }}</label>
      <select name="protocol">
        <option value="https">{{ __('HTTPS') }}</option>
        <option value="http">{{ __('HTTP') }}</option>
      </select>
    </div>
    <div class="form-input mt-5">
      <label class="initial">{{ __('Host') }}</label>
      <input type="text" name="host" placeholder="{{ __('Host without protocol ex: example.com') }}">
    </div>
    <button class="mt-5 text-sticker bg-gray-200">{{ __('Save') }}</button>
  </form>
</div>
@endsection