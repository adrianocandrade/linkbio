<?php 

$heading = ao($block->blocks, 'heading');

$content = ao($block->blocks, 'content');
?>


<a class="textarea-content edit-block-open" href="<?= route('user-mix-block-edit-get', $block->id) ?>">
    <div class="text theme-text-color">
    	<?= clean($content, 'titles') ?>
    </div>
</a>