@extends('admin::layouts.master')
@section('title', __('Edit Theme'))
@section('content')
<div class="sandy-page-row">
    <div class="sandy-page-col pl-0">
        <div class="page__head">
            <div class="step-banner remove-shadow">
                <div class="section-header">
                    <div class="section-header-info">
                        <p class="section-pretitle">{{ __('Theme') }}</p>
                        <h2 class="section-title">{{ __('Edit User Theme') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5 page-trans rounded-2xl">
            
            <form action="{{ route('sandy-plugins-user_util-themes-edit-post', $theme) }}" method="POST">
                @csrf
                <div class="title-sections mb-5">
                    <h2 class="text-base font-normal">{{ __('Config') }}</h2>
                </div>
                <div class="form-input mb-5">
                    <label>{{ __('Name') }}</label>
                    <input type="text" name="config[name]" value="{{ $config('name') }}">
                </div>
                <div class="form-input mb-5">
                    <label>{{ __('Description') }}</label>
                    <input type="text" name="config[description]" value="{{ $config('description') }}">
                </div>
                <p class="subtitle text-xs italic mb-5">{{ __('(Note: If it is an internal page kindly specify the folder in the public dir in which the image is located. Ex: "assets/image/themes/{'.$theme.'}/theme-default.png".)') }}</p>
                <div class="form-input mb-5">
                    <label>{{ __('Cover Image') }}</label>
                    <input type="text" name="config[cover]" value="{{ $config('cover') }}">
                </div>
                <div class="mort-main-bg rounded-2xl p-5 mb-5">
                    
                    <div class="card-header mb-5">
                        <p class="text-sm mb-3">{{ __('Defaults') }}</p>
                        <p class="subtitle text-xs">{{ __('Theme Defaults Customization.') }}</p>
                    </div>

                    <div class="form-input mb-5">
                        <label class="initial">{{ __('Enable Theme Configurations') }}</label>
                        <select name="defaults[enable]" class="bg-w">
                            <option value="1" {{ $config('defaults.enable') ? 'selected' : '' }}>{{ __('Enable') }}</option>
                            <option value="0" {{ !$config('defaults.enable') ? 'selected' : '' }}>{{ __('Disable') }}</option>
                        </select>
                        <p class="mt-2 italic text-xs">{{ __('(Note: If you disable then it will use current user customization.)') }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <div class="form-input">
                                <label class="initial">{{ __('Radius') }}</label>
                                <select name="defaults[radius]" class="bg-w">
                                    @foreach (['straight' => 'Straight', 'round' => 'Round', 'rounded' => 'Rounded'] as $key => $value)
                                    <option value="{{ $key }}" {{ $config('defaults.radius') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="form-input">
                                <label class="initial">{{ __('Bio Align') }}</label>
                                <select name="defaults[bio_align]" class="bg-w">
                                    @foreach (['left' => 'Left', 'center' => 'Center', 'right' => 'Right'] as $key => $value)
                                    <option value="{{ $key }}" {{ $config('defaults.bio_align') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-input">
                        <label class="initial">{{ __('Font') }}</label>
                        <select name="defaults[font]" class="bg-w">
                            @foreach (fonts() as $key => $value)
                            <option value="{{ $key }}" {{ $config('defaults.font') == $key ? 'selected' : '' }}>{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mort-main-bg rounded-2xl p-5 mb-5">
                    
                    <div class="card-header mb-5">
                        <p class="text-sm mb-2 font-bold">{{ __('Background') }}</p>
                        <p class="subtitle text-xs">{{ __('Theme Defaults Background.') }}</p>
                    </div>
                    <div class="form-input mb-5">
                        <label class="initial">{{ __('Enable Background Image') }}</label>
                        <select name="background[enable]" class="bg-w" data-sandy-select=".select-shift">
                            <option value="1" {{ $config('defaults.background.enable') ? 'selected' : '' }}>{{ __('Enable') }}</option>
                            <option value="0" {{ !$config('defaults.background.enable') ? 'selected' : '' }}>{{ __('Disable') }}</option>
                        </select>
                        <p class="mt-2 italic text-xs">{{ __('(Note: If you disable then it will maintain current user background.)') }}</p>
                    </div>
                    <div class="select-shift">
                        <div data-sandy-open="1">
                            
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <label class="sandy-big-checkbox">
                                    <input type="radio" name="background[source]" class="sandy-input-inner" value="internal" {{ $config('defaults.background.source') == 'internal' ? 'checked' : '' }}>
                                    <div class="checkbox-inner rounded-2xl">
                                        <div class="checkbox-wrap">
                                            <div class="content">
                                                <h1>{{ __('Internal') }}</h1>
                                                <p>{{ __('Internal image from the public folder.') }}</p>
                                            </div>
                                            <div class="icon">
                                                <div class="active-dot">
                                                    <i class="la la-check"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="sandy-big-checkbox">
                                    <input type="radio" name="background[source]" value="external" class="sandy-input-inner" {{ $config('defaults.background.source') == 'external' ? 'checked' : '' }}>
                                    <div class="checkbox-inner rounded-2xl">
                                        <div class="checkbox-wrap">
                                            <div class="content">
                                                <h1>{{ __('External') }}</h1>
                                                <p>{{ __('External Image from url.') }}</p>
                                            </div>
                                            <div class="icon">
                                                <div class="active-dot">
                                                    <i class="la la-check"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="form-input">
                                <label>{{ __('Background Url') }}</label>
                                <input type="text" name="background[background]" class="bg-w" value="{{ $config('defaults.background.background') }}">
                            </div>
                            
                        </div>
                        <div data-sandy-open="0"></div>
                    </div>
                </div>
                <div class="mort-main-bg rounded-2xl p-5">
                    <div class="card-header mb-5">
                        <p class="text-sm mb-2 font-bold">{{ __('Button\'s Background') }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="form-wrap" pickr>
                                <label>{{ __('Button Background Color') }}</label>
                                <input pickr-input type="hidden" name="color[button_background]" value="{{ $config('defaults.color.button_background') ?? '#000' }}">
                                <div id="background-color" pickr-div></div>
                            </div>
                        </div>
                        <div>
                            <div class="form-wrap" pickr>
                                <label>{{ __('Button Text Color') }}</label>
                                <input pickr-input type="hidden" name="color[button_text_color]" value="{{ $config('defaults.color.button_text_color') ?? '#000' }}">
                                <div id="button-text-color" pickr-div></div>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="form-wrap" pickr>
                                <label>{{ __('General Text Color') }}</label>
                                <input pickr-input type="hidden" name="color[text_color]" value="{{ $config('defaults.color.text_color') ?? '#000' }}">
                                <div id="button-text-color" pickr-div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="text-sticker is-submit is-loader-submit loader-white flex items-center mt-10">{{ __('Save') }}</button>
            </form>
        </div>
    </div>
    <div class="sandy-page-col sandy-page-col_pt100">
        <div class="card card_widget">
            <div class="card-header mb-5">
                <p class="text-sm uppercase flex items-center"><i class="sio design-and-development-033-laptop mr-2 text-2xl"></i> {{ __('Css') }}</p>
                <p class="subtitle text-xs">{{ __('Css files to be included when theme is in use.') }}</p>
                <p class="mt-5 italic text-xs">{{ __('(Note: shortcodes can be used in css files.)') }}</p>
                <p class="mt-3 text-xs">{{ __('Shortcodes: {button_background} for button background color. {button_text_color} for user button text color.') }}</p>
                <p class="mt-5 italic text-xs">{{ __('(Note: You can click on the below css file to edit them.)') }}</p>
            </div>
            @foreach (BioStyle::getCssName($theme) as $key => $value)
            <div class="text-sticker rounded mb-3 w-full justify-between items-center">
                <a href="{{ route('sandy-plugins-user_util-themes-edit-css', ['theme' => $theme, 'css' => basename($value, '.css')]) }}" class="is-link">{{ $value }}</a>
                <form action="{{ route('sandy-plugins-user_util-themes-css-delete', ['theme' => $theme, 'css' => basename($value, '.css')]) }}" method="POST">
                    @csrf
                    <button data-delete="{{ __('Remove this css file?') }}" class="c-red text-xs m-0">{{ __('remove') }}</button>
                </form>
            </div>
            @endforeach
            
            <form action="{{ route('sandy-plugins-user_util-themes-css-upload', $theme) }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div data-generic-preview="">
                    <div class="h-avatar h-32 w-full is-upload is-outline-dark">
                        <i class="flaticon-upload-1"></i>
                        <input type="file" name="css">
                        <div class="file-name"></div>
                    </div>
                </div>
                <p class="mt-5 italic text-xs">{{ __('(Note: Only .css can be uploaded.)') }}</p>
                <button class="text-sticker mt-5 is-loader-submit flex items-center justify-center">{{ __('Upload') }}</button>
            </form>
        </div>

        
        <div class="card card_widget">
            <div class="card-header mb-5">
                <p class="text-sm uppercase flex items-center"><i class="sio design-and-development-061-picture mr-2 text-2xl"></i> {{ __('Media') }}</p>
                <p class="subtitle text-xs">{{ __('Images to be used by theme. can be used in cover images or in css.') }}</p>
                <p class="mt-5 italic text-xs">{{ __('(Note: You can get the images in your css with the shortcodes below.)') }}</p>
                <p class="mt-3 text-xs">{{ __('Shortcodes: {media: example.png} for a full path of example.png image url. Change the "example.png" to any uploaded image name. Please maintain the exact shortcode format.') }}</p>
            </div>
            @foreach (BioStyle::getMediaNames($theme) as $key => $value)
                <div class="text-sticker rounded-2xl mb-3 w-full justify-between items-center p-3 h-full">
                    <div class="h-avatar sm">
                        <div class="image lozad" data-background-image="{{ gs("assets/image/theme/$theme", $value) }}"></div>
                    </div>
                    <a href="{{ gs("assets/image/theme/$theme", $value) }}" target="_blank" class="is-link">{{ $value }}</a>
                    <form action="{{ route('sandy-plugins-user_util-themes-delete-media', ['theme' => $theme, 'media' => pathinfo($value, PATHINFO_FILENAME)]) }}" method="POST">
                        @csrf
                        <button data-delete="{{ __('Remove this media file?') }}" class="c-red text-xs m-0">{{ __('remove') }}</button>
                    </form>
                </div>
            @endforeach
            
            <form action="{{ route('sandy-plugins-user_util-themes-upload-media', $theme) }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div data-generic-preview="">
                    <div class="h-avatar h-32 w-full is-upload is-outline-dark">
                        <i class="flaticon-upload-1"></i>
                        <input type="file" name="media">
                        <div class="file-name"></div>
                    </div>
                </div>
                <p class="mt-5 italic text-xs">{{ __('(Note: Only .jpg, .png, .gif, .jpeg, .svg can be uploaded and must be below 2mb in size.)') }}</p>
                
                <div class="flex items-center">
                    <button class="text-sticker mt-5 mr-3 is-loader-submit flex items-center justify-center">{{ __('Upload') }}</button>
                    <a class="text-sticker mt-5 is-submit" href="{{ route('sandy-plugins-user_util-themes-make-public', $theme) }}" app-sandy-prevent="">{{ __('Make Public') }}</a>
                </div>
                <p class="mt-5 italic text-xs">{{ __('(Note: If you click on the "make public" button, it simple moves the images from the themes directory to the public directory so it can be accessible.)') }}</p>
            </form>
        </div>
    </div>
</div>
@endsection