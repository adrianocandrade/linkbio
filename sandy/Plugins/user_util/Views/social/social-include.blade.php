@php
$socials = socials();
@endphp
<div class="w-full">
    
    <div class="grid mt-5 lg:grid-cols-3 grid-cols-2 gap-4">
        @foreach ($socials as $key => $value)
        <div class="sandy-big-radio sortable-item" data-id="{{ $key }}">
            <div class="radio-select-inner font rounded-2xl cursor-default">
                <div class="preview">
                    <div class="h-avatar is-video sm" style="background: {{ ao($value, 'color') }}">
                        <i class="{{ ao($value, 'icon') }}"></i>
                    </div>
                </div>
                <h1 class="text-sm mt-5">{{ ao($value, 'name') }}</h1>
                <div class="flex flex-col md:flex-row">
                    <a app-sandy-prevent="" iframe-trigger="" href="{{ route('sandy-plugins-user_util-socials-edit', $key) }}" class="text-sticker m-0 md:mr-2 mb-2 md:mb-0">{{ __('Edit') }}</a>

                    <form action="{{ route('sandy-plugins-user_util-socials-delete', $key) }}" method="POST">
                        @csrf
                        <button class="m-0 text-xs text-sticker bg-red-500 text-white flex items-center p-2 w-full" data-delete="{{ __('Are you sure you want to remove this social item?') }}">{{ __('Remove') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>