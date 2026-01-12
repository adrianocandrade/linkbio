<?php 

$heading = ao($block->blocks, 'heading');

$content = ao($block->blocks, 'content');
?>


<div class="textarea-content">
    <div class="text theme-text-color">
    	<?= clean($content, 'titles') ?>
    </div>
</div>