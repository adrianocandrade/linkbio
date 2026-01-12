@extends('admin::layouts.master')
@section('title', __('Edit User'))
@section('namespace', 'admin-users')
@section('headJS')
<style type="text/css">
@media screen and ( max-width: 600px ){
li.page-item {
display: none !important;
}
.page-item:first-child,
.page-item:nth-child( 2 ),
.page-item:nth-last-child( 2 ),
.page-item:last-child,
.page-item.active,
.page-item.disabled {
display: block !important;
}
}
</style>
@stop
@section('footerJS')
<script>
app.utils.viewModal = function(){
  jQuery('[data-popup=".user-view-modal"]').on('dialog:open', function(e, $elem){
    var $name = jQuery($elem).data('name');
    var $popup_user_bio = jQuery($elem).data('popup-user-bio');
    var $dialog = jQuery(this);
    $dialog.find('.popup-user-name').html($name);
    $dialog.find('.popup-user-bio').attr('href', $popup_user_bio);
  });
};
app.utils.viewModal();
</script>
@stop
@section('content')
<div class="sandy-page-row">
  <div class="sandy-page-col pl-0">
    <div class="page__head">
      <div class="step-banner remove-shadow">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle">{{ __('Users') }} ({{ number_format(\App\User::count()) }})</p>
            <h2 class="section-title">{{ __('Edit User') }}</h2>
          </div>
          <div class="section-header-actions">
            <div class="notifications__tags">
              <a class="notifications__link active" app-sandy-prevent="" href="{{ route('admin-users') }}">{{ __('All Users') }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>


    <form class="rounded-3xl card-shadow p-8" method="POST" action="{{ route('admin-edit-user-post', $item->id) }}">
      @csrf
      <div class="h-avatar is-video">
        <div data-background-image="{{ avatar($item->id) }}" class="lozad image"></div>
      </div>
      


      <div class="title-sections mt-8 mb-0">
          <h2 class="text-base c-gray">{{ __('Basic') }}</h2>
      </div>
      <div class="md:grid grid-cols-2 gap-4 mt-10">
        <div class="form-input mb-7 md:mb-0">
          <label>{{ __('Name') }}</label>
          <input type="text" name="name" value="{{ $item->name }}">
        </div>
        <div class="form-input">
          <label>{{ __('Email') }}</label>
          <input type="text" name="email" value="{{ $item->email }}">
        </div>
      </div>

      <div class="form-input mt-5">
        <label>{{ __('Username') }}</label>
        <input type="text" name="username" value="{{ $item->username }}">
      </div>

      <div class="md:grid grid-cols-2 gap-4 mt-10">
        <div class="form-input mb-7 md:mb-0">
          <label class="initial">{{ __('User Status') }}</label>
          <select name="status">
            <option value="0" {{ !$item->status ? 'selected' : '' }}>{{ __('Disabled') }}</option>
            <option value="1" {{ $item->status ? 'selected' : '' }}>{{ __('Active') }}</option>
          </select>
        </div>
        <div class="form-input">
          <label class="initial">{{ __('User Role') }}</label>
          <select name="role">
            <option value="0" {{ !$item->role ? 'selected' : '' }}>{{ __('User') }}</option>
            <option value="1" {{ $item->role ? 'selected' : '' }}>{{ __('Admin') }}</option>
          </select>
        </div>
      </div>


      <div class="title-sections mt-8 mb-0">
          <h2 class="text-base c-gray">{{ __('Password') }}</h2>
      </div>
      
      <div class="md:grid grid-cols-2 gap-4 mt-5">
        <div class="form-input mb-7 md:mb-0">
          <label>{{ __('Password') }}</label>
          <input type="password" name="password">
        </div>
        <div class="form-input">
          <label>{{ __('Confirm Password') }}</label>
          <input type="password" name="password_confirmation">
        </div>
      </div>



      <button class="text-sticker is-submit is-loader-submit loader-white flex items-center mt-10">{{ __('Save') }}</button>
    </form>


  </div>
  <div class="sandy-page-col sandy-page-col_pt100">
    <div class="card card_widget desktop-hide">
      <div class="card__head mort-main-bg p-5 mb-10 rounded-3xl">
        <div class="card__title text-sm">{{ __('Other Users') }}</div>
      </div>

        <div class="sandy-quality">
          <div class="sandy-quality-list">
            @forelse ($users as $item)
            <div class="sandy-quality-item">
              <div class="preview bg-pink-opacity">
                <img src="{{ avatar($item->id) }}" class="rounded-xl" alt="">
              </div>
              <div class="sandy-quality-details">
                <div class="sandy-quality-line">
                  <div>{{ $item->name }}</div>
                </div>
                <a class="sandy-quality-info href-link-button text-sticker flex items-center justify-center py-2" href="{{ route('admin-edit-user', $item->id) }}"><i class="sio office-087-highlighter mr-2"></i> {{ __('Edit') }}</a>
              </div>
            </div>
            @empty
            <div class="is-empty text-center">
              <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
              <p class="mt-10 text-lg font-bold">{{ __('No new user. 🙂') }}</p>
            </div>
            @endforelse
          </div>
        </div>
    </div>
  </div>
</div>
@endsection