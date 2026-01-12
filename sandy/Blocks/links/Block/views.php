<?php foreach ($sections as $item): ?>
<a <?= !empty(ao($item->content, 'link')) ? 'href="'. ao($item->content, 'link') .'"' : '' ?> class="yetti-links-v2">
    <div class="yetti-links-v2-inner">

        <?php if ($media = media_or_url($item->thumbnail, 'media/blocks', true)): ?>
            <div class="thumbnail-preview"><?= $media ?></div>
        <?php endif ?>
        <span><?= clean(ao($item->content, 'heading'), 'titles') ?></span>
    </div>
    
    <span class="fancy-drop"></span>
</a>
<?php endforeach ?>