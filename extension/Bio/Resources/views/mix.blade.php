@extends('bio::layouts.master')
@section('title', __('Mix'))
@section('content')
<style>
#content{
padding-bottom: 0 !important;
}

.bio-bottom, .bio-branding-mobile-wrapper, .bio-dark, .bio-menu{
    display: none !important;
}
</style>

<div class="context bio relative">
    @section('mix-body-class', 'is-bio-banner')
    <a class="mix-banner-wrapper flex flex-col {!! ao($bio->settings, 'banner_or_background') ? '' : 'hidden' !!}" href="{{ route('user-mix-settings-customize') }}">
        <div class="mix-banner-wrapper-inner">
            {!! svg_i('upload-1', 'w-10 h-10 stroke-current text-white') !!}
            <div class="mt-3 text-white">{{ __('Click here to change banner image.') }}</div>
        </div>
        {!! \Bio::bio_banner($bio->id) !!}
    </a>
<div class="bio-wrap">
    <div class="context-head p-5 md:p-10 pt-10 z-50 relative">
        <div class="avatar-thumb mb-5">
            <div class="avatar-container">
                <div class="thumb">
                    <img src="{{ avatar() }}" alt="">
                </div>
                <a class="action cursor-pointer edit-profile-open">
                    {!! svg_i('pencil-2', 'w-8 h-4') !!}
                </a>
            </div>
        </div>
        <a class="bio-name-text block edit-profile-open">
            {{ user('name') }}
        </a>
        <a class="bio-username-text block edit-profile-open">
            {{ '@' . user('username') }}
        </a>
        <div class="my-4"></div>
        <a class="bio-des block text-sm edit-profile-open">
            {{ $bio->bio }}
        </a>
    </div>
    

<section class="stories-section pl-5">
    <!-- DISPLAY STRORIES -->
    <div class="display-stories">
        <!-- SWIPER -->
        <div class="swiper myStories">
            <div class="swiper-wrapper wrapper-stories flex overflow-x-auto py-4" id="storiesBox">
                <!-- MY STORY -->
                <div class="swiper-slide spaceBox">
                    <a href="{{ route('user-mix-highlight-create') }}" class="boxStories block px-0">
                        <div class="btn add-my-story">
                            <div class="my_img">
                                <img src="{{ gs('assets/image/emoji/Yellow-1/Selfie.png') }}" alt="my story">
                                <div class="icon">
                                    <i class="flaticon2-plus"></i>
                                </div>
                            </div>
                            <div class="display-text">
                                <span>{{ __('Create Story') }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- HERE -> ITEMS -> AUTOMATICALLY BY JAVASCRIPT -->
            </div>
        </div>
    </div>
</section>
    
    <div class="p-5 md:p-10 rounded-t-2xl" bg-style="#f9f9fb">
        
        <div class="context-block-edit sortable" data-handle=".handle-drag" data-delay="150" data-route="{{ route('user-mix-block-sort') }}">
            @forelse ($blocks as $items)
            <div class="context-block-single context-block-edit-single sortable-item" id="block-id-{{ $items->id }}" data-id="{{ $items->id }}" data-edit-route="{{ Route::has("sandy-blocks-$items->block-edit") ? route("sandy-blocks-$items->block-edit", $items->id) : '#' }}">
                <div class="context-block-header">
                    
                    <div class="actions">
                        <a href="{{ route('user-mix-block-edit-get', $items->id) }}" app-sandy-prevent="" class="edit-block-open">
                            {!! svg_i('pencil-2') !!}
                        </a>

                        <form action="{{ Route::has("sandy-blocks-$items->block-delete") ? route("sandy-blocks-$items->block-delete", $items->id) : '#' }}" method="post">
                            @csrf
                            <button data-delete="{{ __('Are you sure you want to delete this block and its content?') }}">
                            {!! svg_i('delete-3') !!}
                            </button>
                        </form>
                        <a class="handle-drag">
                            {!! svg_i('move-tool-1') !!}
                        </a>
                    </div>
                </div>
                <div class="context-block-edit-body">
                    
                    <div class="bio-titles">
                        <div class="heading theme-text-color">
                            <?= clean(ao($items->blocks, 'heading'), 'titles') ?>
                        </div>
                        <div class="subheading theme-text-color">
                            <?= clean(ao($items->blocks, 'subheading'), 'titles') ?>
                        </div>
                    </div>
                    {{ (new \YettiBlocks)->get_edit_blocks($items->id) }}
                </div>
                <p class="font-9 italic mt-3">{{ __('Drag sections to reorder.') }}</p>
            </div>
            @if (count($blocks) >= plan('settings.blocks_limit') && $loop->iteration == plan('settings.blocks_limit'))
            <div class="p-5 my-10 text-center md:w-3/4 mx-auto items-center flex flex-col w-4/5 inactive" data-upgrade-block="{{ plan('settings.blocks_limit') }}">
                <img data-src="{{ \Bio::emoji('Anguished_Face') }}" class="lozad w-20" alt="">
                <div class="text-xl font-bold my-5">{{ __('Limit reached') }}</div>
                <p>{!! __(':num_of_blocks block section(s) will be visible on your page. Upgrade to add more.', ['num_of_blocks' => '<b>'. plan('settings.blocks_limit') .'</b>']) !!}</p>
                <div>
                    <a href="{{ route('pricing-index') }}" app-sandy-prevent="" target="_blank" class="text-sticker mt-5">{{ __('Upgrade your plan') }}</a>
                </div>
            </div>
            @endif
            @empty
            @includeIf('include.is-empty')
            @endforelse
        </div>
    </div>

</div>
</div>



<div class="bio-bar-container">
    <div class="bio-bar-actions">
        <a class="cursor-pointer add-block-popup-open">
            {!! svg_i('plus-1', 'stroke-current text-white') !!}
            {{ __('Add Blocks') }}
        </a>

        <a href="{{ route('user-mix-pages') }}">
            {!! svg_i('lightning-strike-1', 'stroke-current text-white') !!}
            {{ __('Pages') }}
        </a>
        <a href="{{ route('user-mix-settings') }}">
            {!! svg_i('cogwheel-1', 'stroke-current text-white') !!}
            {{ __('Settings') }}
        </a>
        @php
            $activeWorkspaceId = session('active_workspace_id');
            $activeWorkspace = $activeWorkspaceId ? \App\Models\Workspace::find($activeWorkspaceId) : null;
            $previewUrl = $activeWorkspace ? url($activeWorkspace->slug . '?preview=1') : bio_url(user('id')) . '?preview=1';
        @endphp
        <a href="{{ $previewUrl }}" app-sandy-prevent="" iframe-trigger="" class="border-l border-0 border-gray-400 border-solid cursor-pointer">
            {!! svg_i('eye-1', 'stroke-current text-white') !!}
        </a>
    </div>
</div>


<div data-iframe-modal="" class="sandy-bio-element-dialog is-mix">
    <div class="iframe-header">
        <div class="icon iframe-trigger-close">
            <i class="flaticon2-cross"></i>
        </div>
        <a class="out" href="#" target="_blank" data-open-popup>
            <i class="la la-external-link-alt"></i>
        </a>
    </div>
    <div class="sandy-dialog-body"></div>
</div>

<div class="small-floating fit-iframe-height p-0" data-popup=".edit-block" data-has-iframe-modal="">
    <div class="sandy-dialog-body"></div>
</div>


<div data-popup=".edit-profile" class="is-mobile-blocks">
    
    <div class="flex items-center mb-5">
        <div class="text-lg font-bold mr-auto"><?= __('EDIT PROFILE') ?></div>
        <button class="yetti-popup-close flex items-center justify-center edit-profile-close">
            <?= svg_i('close-1', 'icon') ?>
        </button>
    </div>

    <form method="post" action="{{ route('user-mix-settings-post', 'profile') }}" enctype="multipart/form-data">
        @csrf

        <div class="card customize mb-5">
            <div class="avatar-upload sandy-upload-modal-open">
                <div class="avatar">
                    {!! avatar($bio->id, true) !!}
                </div>
                <input type="file" class="avatar-upload-input" name="avatar">
                <div class="content">
                    <h5>{{ __('Avatar') }}</h5>
                    <p class="text-sticker">{{ __('Browse') }}</p>
                </div>
            </div>
        </div>
        
        

        {!! sandy_upload_modal($bio->avatar_settings, 'media/bio/avatar') !!}
        <div class="card customize">
            <div class="card-header">
                <div class="form-input mb-7">
                    <label>{{ __('Username') }}</label>
                    <input type="text" name="username" class="bg-w" value="{{ $bio->username }}">
                </div>
                <div class="form-input mb-7">
                    <label>{{ __('Name') }}</label>
                    <input type="text" name="name" class="bg-w" value="{{ $bio->name }}">
                </div>
                <div class="form-input mb-7 hidden">
                    <label>{{ __('Email') }}</label>
                    <input type="email" name="email" class="bg-w" value="{{ $bio->email }}">
                </div>
                <div class="form-input">
                    <label>{{ __('Bio') }}</label>
                    <textarea rows="4" name="bio" class="bg-w">{{ $bio->bio }}</textarea>
                </div>
            </div>
        </div>
        <button class="button w-full mt-8">{{ __('Save') }}</button>
    </form>
</div>

<div data-element-pickr class="half-short t-300px">

    @forelse (elements($bio->id) as $element)
		
    <label class="sandy-big-checkbox relative z-10 mb-5">
        <input type="radio" name="elements" class="sandy-input-inner" value="{{ $element->id }}"  data-route="{{ \Route::has("sandy-app-$element->element-render") ? parse(route("sandy-app-$element->element-render", $element->slug), 'path') : '' }}">
        <div class="checkbox-inner rounded-2xl">
            <div class="meta-app">
                {!! ElementIcon($element->element) !!}
                <div class="content">
                    <p class="title">{{ $element->name }}</p>
                    <span>{{ __('Added :date', ['date' => \Carbon\Carbon::parse($element->create_at)->format('F d')]) }}</span>
                </div>
                <div class="active-dot ml-auto rounded-lg">
                    <i class="la la-check"></i>
                </div>
            </div>
        </div>
    </label>
    @empty
    @include('include.is-empty', ['link' => ['link' => route('user-mix-block-new'), 'title' => __('Create')]])
    @endforelse
</div>


<div data-popup=".add-block-popup" class="-small -is-mobile-blocks half-short p-0">
    <div class="modal-header">
        
        <div class="modal-header-title uppercase text-base">{{ __('Add New Block') }}</div>

        <div class="modal-header-close flex items-center justify-center bg-transparent add-block-popup-close">
            {!! svg_i('close-1', 'stroke-current text-black w-8 h-8') !!}
        </div>
    </div>
    <div class="block-lists mt-5 px-2 md:px-0">

        <div class="separator-title">{!! __('Links & buttons') !!}</div>

        <div class="p-5">
            <div class="grid grid-cols-2 gap-4">
                
                @foreach (config('blocks') as $key => $value)
                <form action="{{ (new \YettiBlocks)->create_route($key) }}" class="card-block-2 bg-gray-100 shadow-none mt-0 p-2 m-0" method="post">
                    @csrf
                    <button class="flex items-center no-disabled-btn">
                        <div class="card-thumb p-0 mr-2 m-0">
                            <i class="{{ ao($value, "icon") }}"></i>
                            @if (ao($value, 'orion'))
                                {!! orion(ao($value, 'orion'), 'w-5 h-5') !!}
                            @endif
                        </div>
                        <div class="card-title p-0 m-0">
                            <h3 class="mb-0">{{ __(ao($value, "name")) }}</h3>
                        </div>
                    </button>
                </form>
                @endforeach
            </div>
        </div>
        <div class="separator-title">{{ __('Other Tools') }}</div>
        
        <div class="p-5">
            <div class="grid grid-cols-2 gap-4">
                
                <a class="card-block-2 bg-gray-100 shadow-none mt-0 flex items-center p-2 m-0 col-span-2 link-shortener-open" app-sandy-prevent="">
                    <div class="card-thumb p-0 mr-2 m-0">
                        {!! orion('key-2', 'w-5 h-5') !!}
                    </div>
                    <div class="card-title p-0 m-0">
                        <h3 class="mb-0">{{ __('Link Shortener') }}</h3>
                    </div>
                </a>

                <a class="card-block-2 bg-gray-100 shadow-none mt-0 flex items-center p-2 m-0 col-span-2 link-tree-import-open" app-sandy-prevent="">
                    <div class="card-thumb p-0 mr-2 m-0">
                        {!! orion('link-4', 'w-5 h-5') !!}
                    </div>
                    <div class="card-title p-0 m-0">
                        <h3 class="mb-0">{{ __('Import from LinkTree') }}</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div data-popup=".link-tree-import" class="small-floating p-0">
    <div class="modal-header">
        
        <div class="modal-header-title uppercase text-base">{{ __('LinkTree Importer') }}</div>

        <div class="modal-header-close flex items-center justify-center bg-transparent link-tree-import-close">
            {!! svg_i('close-1', 'stroke-current text-black w-8 h-8') !!}
        </div>
    </div>
    <div class="p-5">
        <div class="card p-5 rounded-2xl block has-sweet-container border-4 border-solid border-gray-200">
            <div class="card-container bg-repeat-right" data-bg="{{ gs('assets/image/others/scribbbles/4.png') }}">
                <div class="my-2 text-xs is-info w-44 mb-5">{{ __('Import links from your active linktree page. Input your username to get started.') }}</div>


                                    
                <form method="post" action="{{ route('user-mix-copy-linktree') }}" class="mr-14">
                    @csrf
                    <div class="form-input is-link always-active active">
                        <label class="is-alt-label">{{ __('Username') }}</label>
                        <div class="is-link-inner">
                        <div class="side-info">
                            @
                        </div>
                        <input type="text" name="username" placeholder="{{ __('Your Linktree Username') }}" class="is-alt-input">
                        </div>
                    </div>

                    <button class="sandy-expandable-btn px-10 text-black mt-5 z-10 relative"><span>{{ __('Import') }}</span></button>
                </form>
            </div>
        </div>
    </div>
</div>


<div data-popup=".link-shortener" class="small-floating p-0">
    <div class="modal-header">
        
        <div class="modal-header-title uppercase text-base">{{ __('Shorten') }}</div>

        <div class="modal-header-close flex items-center justify-center bg-transparent link-shortener-close">
            {!! svg_i('close-1', 'stroke-current text-black w-8 h-8') !!}
        </div>
    </div>
    <div class="p-5">
        <livewire:mix.link-shortener :user_id="$bio->id"/>
    </div>
</div>

@section('footerJS')

<script>
    // BUILD ITEM
    function buildItem(id, type, length, src, preview, link, linkText, time, seen) {
        return {
            id, type, length, src, preview, link, linkText, time, seen
        };
    }

    /*==================================
    START THE STORIES [CIRCLES]
    ==================================*/
    var stories = new Zuck('storiesBox', {
        autoFullScreen: true,
        skin: 'Snapssenger',
        avatars: false,
        list: false,
        openEffect: true,
        cubeEffect: true,
        backButton: false,
        backNative: false,
        localStorage: false,
        paginationArrows: true,
        stories: {!! json_encode(yetti_highlight_stories($bio->id)) !!},
    });
    
    jQuery('#bio-css-styles').remove();
</script>
@stop
@endsection