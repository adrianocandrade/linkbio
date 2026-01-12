@extends('bio::layouts.master')
@section('index-bio', true)
@section('seo')
{!! user_seo_tags($bio->id) !!}
@stop
@section('content')
<div class="relative z-10">
    <div class="bio-menu">
        <div class="bio-menu-container">
            <div class="bio-menu-info">
                <div class="user-img bio-avatar">
                    {!! avatar($bio->id, true) !!}
                </div>
                <div class="bio-name-text theme-text-color">
                    {{ $bio->name }}
                </div>
                <div class="social-modal social-modal-open two-burger-icon"></div>
            </div>
        </div>
    </div>
    <div class="context bio {!! radius_and_align_class($bio->id, 'align') !!}">
        
        {!! \Bio::bio_banner($bio->id) !!}

        <div class="bio-wrap bg-transparent">
            
        <div class="context-head">
            <div class="avatar-thumb relative z-10 mb-5">
                <div class="avatar-container">
                    <div class="thumb" style="background: {{ao($bio->settings, 'avatar_color')}}">
                        {!! avatar($bio->id, true) !!}
                    </div>
                </div>
                <div class="bio-info-container">
                    <div class="bio-name-text theme-text-color flex">
                        {{ $bio->name }}
                        {!! user_verified($bio->id) !!}
                    </div>
                    <div class="bio-username-text theme-text-color">
                        {{ '@' . $bio->username }}
                    </div>
                </div>
            </div>
            <div class="bio-des mt-5 font-14 mb-7 theme-text-color">
                {{ $bio->bio }}
            </div>
            @if (plan('settings.social', $bio->id))
            <div class="context-social pb-5">
                <div class="social-links">
                    @foreach (socials() as $key => $items)
                    @if (!empty(user('social.'.$key, $bio->id)))
                    <a class="social-link {{ $key }}" target="_blank" href="{{ linker(sprintf(ao($items, 'address'), user("social.$key", $bio->id)), $bio->id) }}">
                        <i class="{{ ao($items, 'icon') }}"></i>
                        {{ ao($items, 'svg') }}
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>
            
        <section class="stories-section pl-5">
            <div class="display-stories">
                <div class="swiper myStories">
                    <div class="swiper-wrapper wrapper-stories flex overflow-x-auto py-4" id="storiesBox">
                        <!-- HERE -> ITEMS -> AUTOMATICALLY BY JAVASCRIPT -->
                    </div>
                </div>
            </div>
        </section>

        <div class="px-5 md:px-10 context-body mt-0">
            @if ($blocks->isEmpty())
            <div class="no-record">
                <div class="rounded-3xl block">
                    <div class="text-center flex justify-center flex-col items-center">
                        <img data-src="{{ \Bio::emoji('Pleading_Face') }}" class="lozad w-20" alt="">
                        <div class="text-xl font-bold mt-5">{{ __('No Block.') }}</div>
                        <div class="w-3/4 mt-3">
                            <div class="text-sm text-gray-400">{{ __('This user has not posted any block.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @foreach ($blocks as $item)
            <div class="bio-margin animated">
                
                    
                <div class="bio-titles">
                    <div class="heading theme-text-color">
                        <?= clean(ao($item->blocks, 'heading'), 'titles') ?>
                    </div>
                    <div class="subheading theme-text-color">
                        <?= clean(ao($item->blocks, 'subheading'), 'titles') ?>
                    </div>
                </div>
                {!! (new \YettiBlocks)->get_blocks($item->id) !!}
            </div>
            @endforeach
            <div class="pb-5"></div>
        </div>
        </div>
    </div>
</div>


@section('footerJS')

<script>
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
        stories: {!! json_encode(yetti_highlight_stories($bio->id, 'public')) !!},
    });
</script>
@stop
@endsection