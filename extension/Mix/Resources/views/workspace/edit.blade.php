@extends('mix::layouts.master')
@section('title', __('Edit Workspace'))
@section('mix-body-class', 'bg-white')
@section('content')
<div class="mix-padding-10">
    <div class="mb-10">
        <p class="text-lg font-bold">{{ __('Edit Workspace') }}</p>
        <p class="text-xs text-gray-400">{{ __('Update your workspace settings.') }}</p>
    </div>

    <!-- Update Form -->
    <form action="{{ route('workspace-update', $workspace->id) }}" method="POST" class="mort-main-bg p-5 rounded-2xl mb-10">
        @csrf
        
        <div class="form-input mb-7">
            <label>{{ __('Workspace Name') }}</label>
            <input type="text" name="name" value="{{ $workspace->name }}" class="bg-w" required>
        </div>

        <div class="form-input is-link always-active active mb-7">
            <label class="is-alt-label hidden">{{ __('URL Slug') }}</label>
            <div class="is-link-inner">
                <div class="side-info">
                    {{ config('app.url') }}/ 
                </div>
                @if(isset($isDefault) && $isDefault)
                    {{-- ✅ Segurança: Workspace principal não pode ter slug editado --}}
                    <input type="text" name="slug" value="{{ $workspace->slug }}" class="is-alt-input bg-gray-100" readonly disabled>
                    <input type="hidden" name="slug" value="{{ $workspace->slug }}">
                    <div class="mt-2 text-xs text-amber-600 bg-amber-50 p-2 rounded">
                        <i class="la la-lock"></i> {{ __('The URL slug of your main workspace cannot be changed. This prevents broken links and URL conflicts.') }}
                    </div>
                @else
                    <input type="text" name="slug" value="{{ $workspace->slug }}" class="is-alt-input bg-white" required>
                    <div class="mt-2 text-xs text-gray-500">
                        {{ __('This will be your workspace public URL. Choose carefully.') }}
                    </div>
                @endif
            </div>
        </div>

        <button class="mt-5 sandy-expandable-btn"><span>{{ __('Update Workspace') }}</span></button>
    </form>

    <!-- Danger Zone -->
    <div class="border border-red-200 dark:border-red-900 bg-red-50 dark:bg-red-900/10 p-5 rounded-2xl">
        <p class="text-lg font-bold text-red-600 mb-2">{{ __('Danger Zone') }}</p>
        <p class="text-sm text-red-500 mb-5">
            {{ __('Deleting this workspace will permanently remove all associated data and components. This action cannot be undone.') }}
        </p>

        <form action="{{ route('workspace-delete', $workspace->id) }}" method="POST" class="delete-workspace-form">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 text-sm font-bold">
                {{ __('Delete Workspace') }}
            </button>
        </form>
    </div>
</div>
@push('footer_scripts')
<script>
    jQuery(document).ready(function($) {
        $('.delete-workspace-form button').click(function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            $.confirm({
                title: "{{ __('Delete Workspace') }}",
                content: "{{ __('Are you sure you want to delete this workspace? All data will be lost.') }}",
                type: 'red',
                theme: 'modern',
                typeAnimated: true,
                buttons: {
                    delete: {
                        text: "{{ __('Delete Workspace') }}",
                        btnClass: 'btn-red',
                        action: function(){
                            form.submit();
                        }
                    },
                    cancel: function () {
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection
