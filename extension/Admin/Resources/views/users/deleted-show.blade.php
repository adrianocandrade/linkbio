@extends('admin::layouts.master')
@section('title', __('Backup Details'))
@section('namespace', 'admin-deleted-users-show')
@section('content')
<div class="sandy-page-row">
  <div class="sandy-page-col pl-0">
    <div class="page__head">
      <div class="step-banner remove-shadow">
        <div class="section-header">
          <div class="section-header-info">
            <a href="{{ route('admin-deleted-users-index') }}" class="text-blue-500 hover:text-blue-700 mb-2 inline-block">
              <i class="la la-arrow-left"></i> {{ __('Back to Backups') }}
            </a>
            <p class="section-pretitle">{{ __('Backup Details') }}</p>
            <h2 class="section-title">{{ $backup->name ?? __('N/A') }}</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <!-- Informações do Backup -->
      <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h3 class="text-lg font-bold mb-4">{{ __('Backup Information') }}</h3>
        <dl class="space-y-3">
          <div>
            <dt class="text-sm text-gray-500">{{ __('User ID') }}</dt>
            <dd class="font-medium">{{ $backup->user_id ?? __('N/A') }}</dd>
          </div>
          <div>
            <dt class="text-sm text-gray-500">{{ __('Name') }}</dt>
            <dd class="font-medium">{{ $backup->name ?? __('N/A') }}</dd>
          </div>
          <div>
            <dt class="text-sm text-gray-500">{{ __('Email') }}</dt>
            <dd class="font-medium">{{ $backup->email }}</dd>
          </div>
          <div>
            <dt class="text-sm text-gray-500">{{ __('Username') }}</dt>
            <dd class="font-medium">@{{ $backup->username ?? __('N/A') }}</dd>
          </div>
          <div>
            <dt class="text-sm text-gray-500">{{ __('Backup Date') }}</dt>
            <dd class="font-medium">{{ \Carbon\Carbon::parse($backup->backup_date)->format('d/m/Y H:i:s') }}</dd>
          </div>
          <div>
            <dt class="text-sm text-gray-500">{{ __('Expires At') }}</dt>
            <dd class="font-medium {{ $backup->isExpired() ? 'text-red-500' : '' }}">
              {{ \Carbon\Carbon::parse($backup->expires_at)->format('d/m/Y H:i:s') }}
            </dd>
          </div>
          <div>
            <dt class="text-sm text-gray-500">{{ __('File Size') }}</dt>
            <dd class="font-medium">{{ formatBytes($backup->file_size ?? 0) }}</dd>
          </div>
          <div>
            <dt class="text-sm text-gray-500">{{ __('Status') }}</dt>
            <dd>
              @if($backup->is_restored)
                <span class="text-sticker m-0 bg-blue-500 text-white">{{ __('Restored') }}</span>
                @if($backup->restored_at)
                  <span class="text-xs text-gray-500 block mt-1">
                    {{ __('Restored at') }}: {{ \Carbon\Carbon::parse($backup->restored_at)->format('d/m/Y H:i:s') }}
                  </span>
                @endif
                @if($backup->restoredBy)
                  <span class="text-xs text-gray-500 block mt-1">
                    {{ __('By') }}: {{ $backup->restoredBy->name }} ({{ $backup->restoredBy->email }})
                  </span>
                @endif
              @elseif($backup->isExpired())
                <span class="text-sticker m-0 bg-red-500 text-white">{{ __('Expired') }}</span>
              @else
                <span class="text-sticker m-0 bg-green-500 text-white">{{ __('Active') }}</span>
              @endif
            </dd>
          </div>
        </dl>
      </div>

      <!-- Metadados -->
      <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h3 class="text-lg font-bold mb-4">{{ __('Metadata') }}</h3>
        @if($backup->backup_metadata)
          <dl class="space-y-3">
            @foreach($backup->backup_metadata as $key => $value)
            <div>
              <dt class="text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $key)) }}</dt>
              <dd class="font-medium">
                @if(is_bool($value))
                  {{ $value ? __('Yes') : __('No') }}
                @else
                  {{ $value }}
                @endif
              </dd>
            </div>
            @endforeach
          </dl>
        @else
          <p class="text-gray-500">{{ __('No metadata available.') }}</p>
        @endif
      </div>
    </div>

    <!-- Ações -->
    <div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
      <h3 class="text-lg font-bold mb-4">{{ __('Actions') }}</h3>
      <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin-deleted-users-download', $backup->id) }}" 
           class="sandy-btn sandy-btn-secondary">
          <i class="la la-download mr-2"></i> {{ __('Download Backup') }}
        </a>
        
        @if($backup->canBeRestored())
        <form method="POST" action="{{ route('admin-deleted-users-restore', $backup->id) }}" 
              onsubmit="return confirm('{{ __('Are you sure you want to restore this account? All data will be restored.') }}')"
              class="inline-block">
          @csrf
          <button type="submit" class="sandy-btn sandy-btn-primary">
            <i class="la la-undo mr-2"></i> {{ __('Restore Account') }}
          </button>
        </form>
        @else
        <button disabled class="sandy-btn sandy-btn-secondary opacity-50 cursor-not-allowed">
          <i class="la la-undo mr-2"></i> {{ __('Cannot Restore') }}
        </button>
        @endif

        @if(!$backup->is_restored)
        <form method="POST" action="{{ route('admin-deleted-users-delete', $backup->id) }}" 
              onsubmit="return confirm('{{ __('Are you sure you want to delete this backup? This action cannot be undone.') }}')"
              class="inline-block">
          @csrf
          <button type="submit" class="sandy-btn sandy-btn-danger">
            <i class="la la-trash mr-2"></i> {{ __('Delete Backup') }}
          </button>
        </form>
        @endif
      </div>
    </div>

    <!-- Preview dos dados (se disponível) -->
    @if($backupData)
    <div class="bg-white rounded-2xl p-6 shadow-sm">
      <h3 class="text-lg font-bold mb-4">{{ __('Backup Preview') }}</h3>
      <div class="bg-gray-50 rounded-lg p-4 max-h-96 overflow-auto">
        <pre class="text-xs"><code>{{ json_encode($backupData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection

