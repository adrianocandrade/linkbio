@extends('admin::layouts.master')
@section('title', __('All Users'))
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
    var $popup_user_edit = jQuery($elem).data('popup-user-edit');
    var $popup_user_login = jQuery($elem).data('popup-user-login');
    var $popup_delete_user = jQuery($elem).data('popup-user-delete');
    var $dialog = jQuery(this);
    $dialog.find('.popup-user-name').html($name);
    $dialog.find('.popup-user-bio').attr('href', $popup_user_bio);
    $dialog.find('.popup-user-edit').attr('href', $popup_user_edit);
    $dialog.find('.popup-user-login').attr('action', $popup_user_login);
    $dialog.find('.popup-user-delete').attr('action', $popup_delete_user);
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
            <h2 class="section-title">{{ __('All Users') }}</h2>
          </div>
          <div class="section-header-actions">
            <div class="notifications__tags">
              <a class="notifications__link active new-user-modal-open" href="#">{{ __('New User') }}</a>
            </div>
            <div class="notifications__tags ml-3">
              <a class="notifications__link bg-red-50 text-red-600 hover:bg-red-100 border border-red-200" href="{{ route('admin-deleted-users-index') }}">
                <i class="la la-trash mr-2"></i>{{ __('Deleted Users / Backups') }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if (!$users->isEmpty())
    <div class="flex-table">
      <!--Table header-->
      <div class="flex-table-header">
        <span class="is-grow">{{ __('Customer') }}</span>
        <span>{{ __('Status') }}</span>
        <span>{{ __('Info') }}</span>
        <span class="cell-end">{{ __('Actions') }}</span>
      </div>
      @foreach ($users as $user)
      <div class="flex-table-item rounded-2xl overflow-x-auto">
        <a href="{{ bio_url($user->id) }}" target="_blank" class="flex-table-cell is-media is-grow" data-th="">
          <div class="h-avatar md is-video" style="background: {{ao($user->settings, 'avatar_color')}}">
            <img class="avatar is-squared lozad" data-src="{{ avatar($user->id) }}" alt="">
          </div>
          <div>
            <span class="item-name mb-2">{{ $user->name }}</span>
            <span class="item-meta">
              <span>{{ $user->email }}</span>
            </span>
          </div>
        </a>
        <div class="flex-table-cell" data-th="{{ __('Status') }}">
          <div class="ml-auto md:mx-auto">
            @if ($user->status)
            <span class="text-sticker m-0 bg-green text-white">{{ __('Active') }}</span>
            @else
            <span class="text-sticker m-0 bg-red-500 flex items-center text-white">{{ __('Disabled') }}</span>
            @endif
          </div>
        </div>
        <div class="flex-table-cell" data-th="{{ __('Info') }}">
          <div class="flex ml-auto">
            <div class="text-sticker m-0 mr-2 xs" data-hover="{{ __('Registered on - :date', ['date' => \Carbon\Carbon::parse($user->created_at)->toDayDateTimeString()]) }}">
              <i class="la la-clock text-lg"></i>
            </div>
            <div class="text-sticker m-0 mr-2 xs" data-hover="{{ __('Last Activity - :date', ['date' => \Carbon\Carbon::parse($user->lastActivity)->toDayDateTimeString()]) }}">
              <i class="la la-user-clock text-lg"></i>
            </div>
            <div class="text-sticker m-0 is-flag xs shadow-none">
              <img src="{{ Country::icon($user->lastCountry) }}" alt="">
            </div>
          </div>
        </div>
        <div class="flex-table-cell cell-end" data-th="{{ __('Actions') }}">
          <a href="#" class="text-3xl ml-auto user-view-modal-open" data-name="{{ $user->name }}" data-popup-user-bio="{{ bio_url($user->id) }}" data-popup-user-login="{{ route('admin-users-login', $user->id) }}" data-popup-user-edit="{{ route('admin-edit-user', $user->id) }}" data-popup-user-delete="{{ route('admin-delete-user', $user->id) }}"><i class="sio industrial-icon-051-painter-roller"></i></a>
        </div>
      </div>
      @endforeach
    </div>
      @else
      <div class="is-empty p-10 text-center">
        <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">

        <p class="mt-10 text-lg font-bold">{{ __('No User Found.') }}</p>
      </div>

    @endif
    
    <div class="mt-10">
      {!! $users->links() !!}
    </div>
  </div>
  <div class="sandy-page-col sandy-page-col_pt100">
    <div class="card card_widget">
      <div class="card__head card__head_mb32">
        <div class="card__title h6">{{ __('Filter') }}</div>
      </div>
      <div class="card__filters">
        <form class="notifications__search flex gap-2 items-center" method="GET">
          <div class="dropdown">
            <button class="dropdown__head sorting__action shadow-none rounded-2xl mort-main-bg m-0">
            <i class="la la-filter"></i>
            </button>
            <div class="dropdown__body has-simplebar">
              <div data-simplebar>
                
              <div class="form-input mb-5">
                <label class="initial">{{ __('Search by') }}</label>
                <select name="search_by">
                  @foreach (['email' => 'Email', 'name' => 'Name'] as $key => $value)
                  <option value="{{$key}}" {{ request()->get('search_by') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-input mb-5">
                <label class="initial">{{ __('Status') }}</label>
                <select name="status">
                  <option value="">{{ __('All') }}</option>
                  @foreach (['active' => 'Active', 'disabled' => 'Disabled'] as $key => $value)
                  <option value="{{$key}}" {{ request()->get('status') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-input mb-5">
                <label class="initial">{{ __('Plan') }}</label>
                <select name="plan">
                  <option value="">{{ __('All') }}</option>
                  @foreach (\App\Models\Plan::get() as $item)
                    <option value="{{ $item->id }}" {{ request()->get('plan') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-input mb-5">
                <label class="initial">{{ __('Country') }}</label>
                <select name="country">
                  <option value="">{{ __('All') }}</option>
                  @foreach (Country::list() as $key => $value)
                  <option value="{{ $key }}" {{ request()->get('country') == $key ? 'selected' : '' }}>{{ $value }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-input mb-5">
                <label class="initial">{{ __('Order by') }}</label>
                <select name="order_by">
                  @foreach (['created_at' => 'Registration Date', 'lastActivity' => 'Last Activity', 'email' => 'Email', 'name' => 'Name'] as $key => $value)
                  <option value="{{$key}}" {{ request()->get('order_by') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                  @endforeach
                </select>
              </div>
              <!-- OrderType:START -->
              <div class="form-input mb-5">
                <label class="initial">{{ __('Order type') }}</label>
                <select name="order_type">
                  @foreach (['DESC' => 'Descending', 'ASC' => 'Ascending'] as $key => $value)
                  <option value="{{$key}}" {{ request()->get('order_type') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                  @endforeach
                </select>
              </div>
              <!-- OrderType:END -->
              <!-- Results Per Page:START -->
              <div class="form-input mb-5">
                <label class="initial">{{ __('Per Page') }}</label>
                <select name="per_page">
                  @foreach ([10, 25, 50, 100, 250] as $key => $value)
                  <option value="{{$value}}" {{ request()->get('per_page') == $value ? 'selected' : '' }}>{{ $value }}</option>
                  @endforeach
                </select>
              </div>
              <!-- Results Per Page:END -->
              <button class="button sandy-quality-button bg-blue2 is-loader-submit loader-white mt-0 mb-8">{{ __('Submit') }}</button>
              </div>
            </div>
          </div>

          <input class="notifications__input" type="text" name="query" value="{{ request()->get('query') }}" placeholder="{{ __('Search') }}">
          <button class="notifications__start flex items-center justify-center">
          <svg class="icon icon-search">
            <use xlink:href="{{ gs('assets/image/svg', 'sprite.svg#icon-search') }}"></use>
          </svg>
          </button>
        </form>
      </div>
      
      <div class="card__btns mt-10">
        <a class="card__btn btn btn_transparent" href="{{ route('admin-users-export-csv') }}" app-sandy-prevent="">{{ __('Export to CSV') }}</a>
      </div>
      <div class="card__btns mt-5">
        <a class="card__btn btn bg-red-50 text-red-600 hover:bg-red-100 border border-red-200" href="{{ route('admin-deleted-users-index') }}" app-sandy-prevent="">
          <i class="la la-trash mr-2"></i>{{ __('Deleted Users / Backups') }}
        </a>
      </div>
      <a class="card__reset" href="{{ route('admin-users') }}">{{ __('Reset all filters') }}</a>
    </div>
  </div>
</div>




{{--<div class="search mb-10">
  <div class="search__container">
    <div class="section-header items-start">
      <div class="section-header-info mb-10">
        <div class="search__title h4">{{ __('All users on the database') }}</div>
        <div class="search__info">{{ __('Search users by username, email address') }}</div>
      </div>
      <div class="section-header-actions">
        <a href="{{ route('admin-languages') }}" class="section-header-action text-white">{{ __('New User') }} +</a>
      </div>
    </div>
    <div class="search__preview" hidden><img src="http://ui8-unity-exchange.herokuapp.com/img/figures-2.png" alt=""></div>
    <div class="sorting mt-5">
      <div class="sorting__row">
        <div class="sorting__col flex items-center">
          <label class="checkbox mr-5" data-inputs=".checkbox__input">
            <input class="checkbox__input" type="checkbox">
            <span class="checkbox__in"><span class="checkbox__tick"></span></span>
          </label>
          <form class="search__form w-full">
            <input class="search__input" type="text" placeholder="{{ __('Type your search word.') }}">
            <button class="search__btn">
            <svg class="icon icon-search">
              <use xlink:href="{{ url('assets/image/svg/sprite.svg#icon-search') }}"></use>
            </svg>
            </button>
          </form>
        </div>
        <div class="sorting__col">
          <div class="sorting__line">
            <div class="sorting__actions ml-auto">
              <div class="dropdown">
                <button class="dropdown__head sorting__action">
                <i class="la la-download"></i>
                </button>
                <div class="dropdown__body">
                  <a class="dropdown__link" href="#">{{ __('Export to csv') }}</a>
                  <a class="dropdown__link" href="#">{{ __('language.line') }}</a>
                </div>
              </div>
              <div class="dropdown">
                <button class="dropdown__head sorting__action">
                <i class="flaticon-more text-base"></i>
                </button>
                <div class="dropdown__body">
                  <a class="dropdown__link" href="#">{{ __('Delete') }}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="my-10">
  <!-- Not Using -->
  <div class="grid md:grid-cols-4 gap-4">
    <div class="users color-thief">
      <div class="user-preview flex justify-between">
        <label class="checkbox users-checkbox">
          <input class="checkbox__input" type="checkbox">
          <span class="checkbox__in"><span class="checkbox__tick"></span></span>
        </label>
        <div class="avatar">
          <img class="img" src="{{ avatar() }}">
        </div>
        <div class="flex flex-col">
          <div class="text-sticker mb-5" data-hover="{{ __('Registered on') }} - 2021-06-10 01:47:39">
            <i class="la la-clock text-lg"></i>
          </div>
          <div class="text-sticker mb-5" data-hover="{{ __('Total login') }} - 1000">
            <i class="la la-user-clock text-lg"></i>
          </div>
          <div class="text-sticker m-0">
            <img src="{{ url('assets/image/countries/ng.svg') }}" alt="">
          </div>
        </div>
      </div>
      <div class="details">
        <div class="content">
          <div class="title">Jeff Jola</div>
          <div class="email">jeffjola@gmail.com</div>
          <div class="status green mt-5">Last seen - 3 months ago</div>
          <div class="status green mt-5">Status - Disabled</div>
        </div>
        <div class="user-actions">
          <button class="user-action" data-hover="{{ __('View profile') }}">
          <i class="la la-eye"></i>
          </button>
          <button class="user-action" data-hover="{{ __('Login') }}" app-sandy-prevent>
          <i class="la la-sign-in"></i>
          </button>
          <button class="user-action" data-hover="{{ __('Edit user') }}">
          <i class="flaticon-edit"></i>
          </button>
          <button class="user-action" data-hover="{{ __('Delete user') }}" app-sandy-prevent>
          <i class="flaticon-delete"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="users color-thief">
      <div class="user-preview flex justify-between">
        <label class="checkbox users-checkbox">
          <input class="checkbox__input" type="checkbox">
          <span class="checkbox__in"><span class="checkbox__tick"></span></span>
        </label>
        <div class="avatar">
          <img class="img" src="{{ getStorage('media/bio/background', user('background_settings.image.image')) }}">
        </div>
        <div class="flex flex-col">
          <div class="text-sticker mb-5" data-hover="{{ __('Registered on') }} - 2021-06-10 01:47:39">
            <i class="la la-clock text-lg"></i>
          </div>
          <div class="text-sticker mb-5" data-hover="{{ __('Total login') }} - 1000">
            <i class="la la-user-clock text-lg"></i>
          </div>
          <div class="text-sticker m-0">
            <img src="{{ url('assets/image/countries/ng.svg') }}" alt="">
          </div>
        </div>
      </div>
      <div class="details">
        <div class="content">
          <div class="title">Jeff Jola</div>
          <div class="email">jeffjola@gmail.com</div>
          <div class="status green mt-5">Last seen - 3 months ago</div>
          <div class="status green mt-5">Status - Disabled</div>
        </div>
        <div class="user-actions">
          <button class="user-action" data-hover="{{ __('View profile') }}">
          <i class="la la-eye"></i>
          </button>
          <button class="user-action" data-hover="{{ __('Login') }}" app-sandy-prevent>
          <i class="la la-sign-in"></i>
          </button>
          <button class="user-action" data-hover="{{ __('Edit user') }}">
          <i class="flaticon-edit"></i>
          </button>
          <button class="user-action" data-hover="{{ __('Delete user') }}" app-sandy-prevent>
          <i class="flaticon-delete"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="users color-thief">
      <div class="user-preview flex justify-between">
        <label class="checkbox users-checkbox">
          <input class="checkbox__input" type="checkbox">
          <span class="checkbox__in"><span class="checkbox__tick"></span></span>
        </label>
        <div class="avatar">
          <img class="img" src="{{ url('assets/image/avatar/avatar.jpg') }}">
        </div>
        <div class="flex flex-col">
          <div class="text-sticker mb-5" data-hover="{{ __('Registered on') }} - 2021-06-10 01:47:39">
            <i class="la la-clock text-lg"></i>
          </div>
          <div class="text-sticker mb-5" data-hover="{{ __('Total login') }} - 1000">
            <i class="la la-user-clock text-lg"></i>
          </div>
          <div class="text-sticker m-0">
            <img src="{{ url('assets/image/countries/ng.svg') }}" alt="">
          </div>
        </div>
      </div>
      <div class="details">
        <div class="content">
          <div class="title">Jeff Jola</div>
          <div class="email">jeffjola@gmail.com</div>
          <div class="status green mt-5">Last seen - 3 months ago</div>
          <div class="status green mt-5">Status - Disabled</div>
        </div>
        <div class="user-actions">
          <button class="user-action" data-hover="{{ __('View profile') }}">
          <i class="la la-eye"></i>
          </button>
          <button class="user-action" data-hover="{{ __('Login') }}" app-sandy-prevent>
          <i class="la la-sign-in"></i>
          </button>
          <button class="user-action" data-hover="{{ __('Edit user') }}">
          <i class="flaticon-edit"></i>
          </button>
          <button class="user-action" data-hover="{{ __('Delete user') }}" app-sandy-prevent>
          <i class="flaticon-delete"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div> --}}
<!-- New User Modal:START -->
<div data-popup=".new-user-modal">
  <form action="{{ route('admin-new-user') }}" method="POST">
    @csrf
    <div class="mb-10 p-5 rounded-xl mort-main-bg text-center">
      {{ __('New User') }}
    </div>
    <div class="form-input mb-5">
      <label>{{ __('Name') }}</label>
      <input type="text" name="name">
    </div>
    <div class="grid grid-cols-2 gap-4 mb-5">
      
      <div class="form-input">
        <label>{{ __('Username') }}</label>
        <input type="text" name="username">
      </div>
      <div class="form-input">
        <label>{{ __('Email') }}</label>
        <input type="email" name="email">
      </div>
    </div>
    <div class="form-input mb-5">
      <label>{{ __('Password') }}</label>
      <input type="password" name="password">
    </div>
    <div class="text-xs italic my-5">{{ __('(Note: password must have at least one uppercase, lowercase number, special characters)') }}</div>
    <button class="text-sticker is-loader-submit black flex items-center">{{ __('Submit') }}</button>
  </form>
</div>
<!-- New User Modal:END -->
<!-- User View Modal:START -->
<div data-popup=".user-view-modal" class="sandy-dialog-overflow">
  <div class="mb-5 p-5 rounded-3xl mort-main-bg popup-user-name"></div>
  <div class="mort-main-bg insight-split-card is-not grid grid-cols-1 md:grid-cols-2 md:flex">
    <div class="split-card">
      <div class="heading has-icon">
        <i class="sio design-and-development-081-sitemap"></i>
        {{ __('Bio') }}
      </div>
      <div class="sub-heading my-4">
        {{ __('View the bio page of this User') }}
      </div>
      <a href="" target="_blank" class="popup-user-bio text-sticker">{{ __('View') }}</a>
    </div>
    
    <div class="split-card">
      <div class="heading has-icon">
        <i class="sio office-068-pencilcase"></i>
        {{ __('Edit') }}
      </div>
      <div class="sub-heading my-4">
        {{ __('Edit this user') }}
      </div>
      <a href="" app-sandy-prevent="" class="text-sticker flex items-center popup-user-edit">
        <i class="sio office-087-highlighter mr-2"></i>
        {{ __('Edit') }}
      </a>
    </div>
    <div class="split-card">
      <div class="heading has-icon">
        <i class="sio internet-052-pencil"></i>
        {{ __('Login') }}
      </div>
      <div class="sub-heading my-4">
        {{ __('Login as this user & manage / view their activites') }}
      </div>
      <form action="" method="POST" class="popup-user-login">
        @csrf
        <button class="text-sticker mt-4">{{ __('Login') }}</button>
      </form>
    </div>
    <div class="split-card">
      <div class="heading has-icon">
        <i class="sio internet-085-dustbin"></i>
        {{ __('Delete') }}
      </div>
      <div class="sub-heading italic my-4 text-xs">
        {{ __("(Note: Deleting this user will completely remove all info & files from the server.')") }}
      </div>
      <form action="" method="post" class="popup-user-delete">
        @csrf
        <button data-delete="{{ __('Are you sure you want to delete this user?') }}" class="text-sticker mt-4 bg-red-500 text-white">{{ __('Delete') }}</button>
      </form>
    </div>
  </div>
</div>
<!-- User View Modal:END -->
@endsection