
        <div class="element-video {{ ao($lesson->lesson_data, 'is_iframe') ? 'h-full' : '' }}">
            <div class="element-single-video {{ ao($lesson->lesson_data, 'is_iframe') ? 'is-iframe h-full' : '' }}">
                @if (!ao($lesson->lesson_data, 'is_iframe'))
                <div class="element-single-video-container" href="<?= getEmbedableLink(ao($lesson->lesson_data, 'type'), ao($lesson->lesson_data, 'link')) ?>">
                    
                    <button class="play-button">
                    <i class="sni sni-play"></i>
                    </button>
                    <img src="<?= ao($lesson->lesson_data, 'thumbnail') ?>" alt="" class="banner">
                </div>
                @else
                <iframe src="<?= getEmbedableLink(ao($lesson->lesson_data, 'type'), ao($lesson->lesson_data, 'link')) ?>" frameborder="0"></iframe>
                @endif
            </div>
        </div>