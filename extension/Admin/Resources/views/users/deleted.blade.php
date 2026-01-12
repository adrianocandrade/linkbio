@extends('admin::layouts.master')
@section('title', __('Deleted Users / Backups'))
@section('namespace', 'admin-deleted-users')
@section('content')
<div class="sandy-page-row">
  <div class="sandy-page-col pl-0">
    <div class="page__head">
      <div class="step-banner remove-shadow">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle">{{ __('Backups') }}</p>
            <h2 class="section-title">{{ __('Deleted Users / Backups') }}</h2>
          </div>
        </div>
      </div>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white rounded-2xl p-6 shadow-sm">
        <div class="text-gray-500 text-sm mb-1">{{ __('Total Backups') }}</div>
        <div class="text-2xl font-bold">{{ number_format($stats['total']) }}</div>
      </div>
      <div class="bg-green-50 rounded-2xl p-6 shadow-sm border border-green-200">
        <div class="text-green-600 text-sm mb-1">{{ __('Active') }}</div>
        <div class="text-2xl font-bold text-green-600">{{ number_format($stats['active']) }}</div>
      </div>
      <div class="bg-blue-50 rounded-2xl p-6 shadow-sm border border-blue-200">
        <div class="text-blue-600 text-sm mb-1">{{ __('Restored') }}</div>
        <div class="text-2xl font-bold text-blue-600">{{ number_format($stats['restored']) }}</div>
      </div>
      <div class="bg-red-50 rounded-2xl p-6 shadow-sm border border-red-200">
        <div class="text-red-600 text-sm mb-1">{{ __('Expired') }}</div>
        <div class="text-2xl font-bold text-red-600">{{ number_format($stats['expired']) }}</div>
      </div>
    </div>

    @if (!$backups->isEmpty())
    <div class="flex-table">
      <!--Table header-->
      <div class="flex-table-header">
        <span class="is-grow">{{ __('User') }}</span>
        <span>{{ __('Backup Date') }}</span>
        <span>{{ __('Expires At') }}</span>
        <span>{{ __('Status') }}</span>
        <span>{{ __('File Size') }}</span>
        <span class="cell-end">{{ __('Actions') }}</span>
      </div>
      @foreach ($backups as $backup)
      <div class="flex-table-item rounded-2xl overflow-x-auto">
        <div class="flex-table-cell is-media is-grow" data-th="">
          <div>
            <span class="item-name mb-2">{{ $backup->name ?? __('N/A') }}</span>
            <span class="item-meta">
              <span>{{ $backup->email }}</span>
              @if($backup->username)
              <span class="mx-2">•</span>
              <span>{{ '@' . $backup->username }}</span>
              @endif
            </span>
          </div>
        </div>
        <div class="flex-table-cell" data-th="{{ __('Backup Date') }}">
          <span class="text-sm">{{ \Carbon\Carbon::parse($backup->backup_date)->format('d/m/Y H:i') }}</span>
        </div>
        <div class="flex-table-cell" data-th="{{ __('Expires At') }}">
          <span class="text-sm {{ $backup->isExpired() ? 'text-red-500' : '' }}">
            {{ \Carbon\Carbon::parse($backup->expires_at)->format('d/m/Y H:i') }}
          </span>
        </div>
        <div class="flex-table-cell" data-th="{{ __('Status') }}">
          <div class="ml-auto md:mx-auto">
            @if($backup->is_restored)
              <span class="text-sticker m-0 bg-blue-500 text-white">{{ __('Restored') }}</span>
              @if($backup->restoredBy)
                <span class="text-xs text-gray-500 block mt-1">
                  {{ __('By') }}: {{ $backup->restoredBy->name }}
                </span>
              @endif
            @elseif($backup->isExpired())
              <span class="text-sticker m-0 bg-red-500 text-white">{{ __('Expired') }}</span>
            @else
              <span class="text-sticker m-0 bg-green-500 text-white">{{ __('Active') }}</span>
            @endif
          </div>
        </div>
        <div class="flex-table-cell" data-th="{{ __('File Size') }}">
          <span class="text-sm">{{ formatBytes($backup->file_size ?? 0) }}</span>
        </div>
        <div class="flex-table-cell cell-end" data-th="{{ __('Actions') }}">
          <div class="flex items-center gap-2 justify-end">
            <a href="{{ route('admin-deleted-users-show', $backup->id) }}" 
               class="text-sticker m-0 bg-blue-500 text-white cursor-pointer" 
               data-hover="{{ __('View Details') }}">
              <i class="la la-eye"></i>
            </a>
            <a href="{{ route('admin-deleted-users-download', $backup->id) }}" 
               class="text-sticker m-0 bg-gray-500 text-white cursor-pointer" 
               data-hover="{{ __('Download Backup') }}">
              <i class="la la-download"></i>
            </a>
            @if($backup->canBeRestored())
            <form method="POST" action="{{ route('admin-deleted-users-restore', $backup->id) }}" 
                  onsubmit="return confirm('{{ __('Are you sure you want to restore this account?') }}')">
              @csrf
              <button type="submit" 
                      class="text-sticker m-0 bg-green-500 text-white cursor-pointer" 
                      data-hover="{{ __('Restore Account') }}">
                <i class="la la-undo"></i>
              </button>
            </form>
            @endif
            @if(!$backup->is_restored)
            <form method="POST" action="{{ route('admin-deleted-users-delete', $backup->id) }}" 
                  onsubmit="return confirm('{{ __('Are you sure you want to delete this backup? This action cannot be undone.') }}')">
              @csrf
              <button type="submit" 
                      class="text-sticker m-0 bg-red-500 text-white cursor-pointer" 
                      data-hover="{{ __('Delete Backup') }}">
                <i class="la la-trash"></i>
              </button>
            </form>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Paginação -->
    <div class="mt-6">
      {{ $backups->links() }}
    </div>
    @else
    <div class="bg-white rounded-2xl p-12 text-center shadow-sm">
      <i class="la la-inbox text-6xl text-gray-300 mb-4"></i>
      <p class="text-gray-500">{{ __('No backups found.') }}</p>
    </div>
    @endif
  </div>
  <div class="sandy-page-col sandy-page-col_pt100">
    <div class="card card_widget">
      <div class="card__head card__head_mb32">
        <div class="card__title h6">{{ __('Filter') }}</div>
      </div>
      <div class="card__filters">
        <form class="notifications__search flex gap-2 items-center" method="GET" action="{{ route('admin-deleted-users-index') }}">
          <div class="dropdown">
            <button class="dropdown__head sorting__action shadow-none rounded-2xl mort-main-bg m-0">
            <i class="la la-filter"></i>
            </button>
            <div class="dropdown__body has-simplebar">
              <div data-simplebar>
                
              <div class="form-input mb-5">
                <label class="initial">{{ __('Search by') }}</label>
                <select name="search_by">
                  @foreach (['email' => 'Email', 'username' => 'Username', 'name' => 'Name'] as $key => $value)
                  <option value="{{$key}}" {{ request()->get('search_by') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-input mb-5">
                <label class="initial">{{ __('Status') }}</label>
                <select name="status">
                  <option value="">{{ __('All Status') }}</option>
                  @foreach (['active' => 'Active', 'restored' => 'Restored', 'expired' => 'Expired'] as $key => $value)
                  <option value="{{$key}}" {{ request()->get('status') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-input mb-5">
                <label class="initial">{{ __('Order by') }}</label>
                <select name="order_by">
                  @foreach (['backup_date' => 'Backup Date', 'expires_at' => 'Expires At', 'email' => 'Email', 'username' => 'Username'] as $key => $value)
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
                  @foreach ([10, 15, 25, 50, 100] as $key => $value)
                  <option value="{{$value}}" {{ request()->get('per_page') == $value ? 'selected' : '' }}>{{ $value }}</option>
                  @endforeach
                </select>
              </div>
              <!-- Results Per Page:END -->
              <button class="button sandy-quality-button bg-blue2 is-loader-submit loader-white mt-0 mb-8">{{ __('Submit') }}</button>
              </div>
            </div>
          </div>

          <input class="notifications__input" type="text" name="search" value="{{ request()->get('search') }}" placeholder="{{ __('Search') }}">
          <button class="notifications__start flex items-center justify-center">
          <svg class="icon icon-search">
            <use xlink:href="{{ gs('assets/image/svg', 'sprite.svg#icon-search') }}"></use>
          </svg>
          </button>
        </form>
      </div>
      <a class="card__reset" href="{{ route('admin-deleted-users-index') }}">{{ __('Reset all filters') }}</a>
    </div>
  </div>
</div>
@endsection

