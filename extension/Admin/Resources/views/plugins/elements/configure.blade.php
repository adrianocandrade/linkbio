@extends('admin::layouts.master')
@section('title', __('Element'))
@section('namespace', 'admin-bio-elements-configure')
@section('content')
@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}"></script>
<script>
app.utils.tinymce();
</script>
@stop
<div class="sandy-page-row">
    <div class="sandy-page-col pl-0">
        <div class="page__head">
            <div class="card card_widget">
                <div class="section-header">
                    <div class="section-header-info">
                        <p class="section-pretitle">{{ __('Element') }}</p>
                        <h2 class="section-title">{{ __('Edit Element') }}</h2>
                    </div>
                    <div class="config-elem mb-5">
                        {!! Elements::icon($element) !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-5 page-trans rounded-2xl">
            <form action="{{ route('admin-bio-elements-configure-post', $element) }}" method="POST">
                @csrf
                <div class="form-input mb-7">
                    <label>{{ __('Name') }}</label>
                    <input type="text" name="config[name]" value="{{ ao($config, 'name') }}">
                </div>
                <div class="form-input mb-7">
                    <label>{{ __('Description') }}</label>
                    <input type="text" name="config[description]" value="{{ ao($config, 'description') }}">
                </div>
                <div class="form-input">
                    <label>{{ __('About') }}</label>
                    <textarea name="config[about]" cols="30" rows="10" class="editor">{!! ao($config, 'about') !!}</textarea>
                </div>
                @if (is_array($con('config')))
                <div class="mort-main-bg rounded-2xl p-5 my-5">
                    <div class="text-base">{{ __('Configure') }}</div>
                </div>
                @foreach ($con('config') as $key => $value)
                <div class="form-input mb-5">
                    <label>{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                    <input type="text" value="{{ ao($value, 'value') }}" name="config_value[{{$key}}]">
                    <p class="mt-3 italic text-xs">{{ ao($value, 'description') }}</p>
                </div>
                @endforeach
                @endif
                <button class="text-sticker is-submit is-loader-submit loader-white flex items-center mt-10">{{ __('Edit') }}</button>
            </form>
        </div>
    </div>
    <div class="sandy-page-col sandy-page-col_pt100">
        <div class="card card_widget desktop-hide">
            <div class="card-header mb-5">
                <p class="text-sm uppercase flex items-center"><i class="sio internet-012-web-development mr-2 text-2xl"></i> {{ __('Assets') }}</p>
                <p class="subtitle text-xs">{{ __('Assets like js or css can be used in coding the element & in frontend styling.') }}</p>
            </div>
            
            @foreach (\Elements::getAssetsNames($element) as $key => $value)
            <div class="text-sticker rounded-2xl mb-3 w-full justify-between items-center h-full">
                <a href="{{ \Elements::getPublicAssets($element, "assets", $value) }}" target="_blank" class="is-link">{{ $value }}</a>
                <form action="{{ route('admin-bio-elements-assets-delete', ['element' => $element, 'media' => pathinfo($value, PATHINFO_FILENAME)]) }}" method="POST">
                    @csrf
                    <button data-delete="{{ __('Remove this media file?') }}" class="c-red text-xs m-0">{{ __('remove') }}</button>
                </form>
            </div>
            @endforeach
            <form action="{{ route('admin-bio-elements-assets-upload', $element) }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div data-generic-preview="">
                    <div class="h-avatar h-32 w-full is-upload is-outline-dark">
                        <i class="flaticon-upload-1"></i>
                        <input type="file" name="file">
                        <div class="file-name"></div>
                    </div>
                </div>
                <p class="mt-5 italic text-xs">{{ __('(Note: Only .js, .css can be uploaded and must be below 2mb in size.)') }}</p>
                
                <div class="flex items-center">
                    <button class="text-sticker mt-5 mr-3 is-loader-submit flex items-center justify-center">{{ __('Upload') }}</button>
                </div>
            </form>
        </div>
        <div class="card card_widget">
            <div class="card-header mb-5">
                <p class="text-sm uppercase flex items-center"><i class="sio internet-030-photo-camera mr-2 text-2xl"></i> {{ __('Gallery') }}</p>
                <p class="subtitle text-xs">{{ __('Images to be used as the element gallery on preview.') }}</p>
            </div>
            @foreach (\Elements::getGalleryNames($element) as $key => $value)
            <div class="text-sticker rounded-2xl mb-3 w-full justify-between items-center p-3 h-full">
                <div class="h-avatar sm">
                    <div class="image lozad" data-background-image="{{ \Elements::getPublicAssets($element, "gallery", $value) }}"></div>
                </div>
                <a href="{{ \Elements::getPublicAssets($element, "gallery", $value) }}" target="_blank" class="is-link mx-2"><span>{{ $value }}</span></a>
                <form action="{{ route('admin-bio-elements-gallery-delete', ['element' => $element, 'media' => pathinfo($value, PATHINFO_FILENAME)]) }}" method="POST">
                    @csrf
                    <button data-delete="{{ __('Remove this media file?') }}" class="c-red text-xs m-0">{{ __('remove') }}</button>
                </form>
            </div>
            @endforeach
            
            <div class="block">
                
                <a class="auth-link mb-5 mt-2 reorder-images-open cursor-pointer">
                    <i class="sio project-management-041-organizer text-black mr-2 text-base"></i>
                    {{ __('Reorder?') }}
                </a>
            </div>
            
            <form action="{{ route('admin-bio-elements-gallery-upload', $element) }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div data-generic-preview="">
                    <div class="h-avatar h-32 w-full is-upload is-outline-dark">
                        <i class="flaticon-upload-1"></i>
                        <input type="file" name="media" accept="image/*">
                        <div class="image"></div>
                        <div class="file-name"></div>
                    </div>
                </div>
                <p class="mt-5 italic text-xs">{{ __('(Note: Only .jpg, .png, .gif, .jpeg, .svg can be uploaded and must be below 2mb in size.)') }}</p>
                
                <div class="flex items-center">
                    <button class="text-sticker mt-5 mr-3 is-loader-submit flex items-center justify-center">{{ __('Upload') }}</button>
                    <a class="text-sticker mt-5 is-submit" href="{{ route('admin-bio-elements-make-public', $element) }}" app-sandy-prevent="">{{ __('Make Public') }}</a>
                </div>
                <p class="mt-5 italic text-xs">{{ __('(Note: If you click on the "make public" button, it simple moves the images from the element directory to the public directory so it can be accessible publicly & more importantly it adds the images to the config file of the element. If you upload an image you would have to reorder the images again as it resets everything.)') }}</p>
            </form>
        </div>
    </div>
</div>
<div data-popup=".reorder-images" class="sandy-dialog-overflow">
    <form action="" method="POST">
        <p class="mb-5 italic text-xs">{{ __('(Reorder images by dragging the card or the icon.)') }}</p>
        <div class="sortable" data-route="{{ route('admin-bio-elements-configure-sort-gallery', $element) }}">
            @foreach (\Elements::getGalleryConfig($element) as $key => $value)
            <div class="flex sortable-item" data-id="{{ $value }}">
                <div class="text-sticker rounded-2xl mb-3 w-full justify-between items-center p-3 h-full">
                    <div class="h-avatar sm">
                        <div class="image lozad" data-background-image="{{ \Elements::getPublicAssets($element, "gallery", $value) }}"></div>
                    </div>
                    <a class="auth-link">{{ $value }}</a>
                    <span class="sni sni-move handle cursor-pointer"></span>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="flex">
            <a class="reorder-images-close text-sticker cursor-pointer">{{ __('Close') }}</a>
        </div>
    </form>
</div>
@endsection