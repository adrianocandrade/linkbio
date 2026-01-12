<?php
$product_limit = (int) ao($block->blocks, 'products') ?? 0;
$products = \Sandy\Blocks\shop\Models\Product::where('user', $block->user)->orderBy('position', 'ASC')->orderBy('id', 'ASC')->get();
?>

<?php if (!plan('settings.block_shop', $block->user)): ?>
    <style>
        .block-id-<?= $block->id ?>{
            display: none !important;
        }
    </style>
<?php endif ?>


<?php if (\Str::is('mix', request()->path()) && !plan('settings.block_shop', $block->user)): ?>
    <p class="text-xs text-gray-400 mb-1"><?= __('Products has been disabled due to plan.') ?></p>
    <a href="<?= Route::has('pricing-index') ? route('pricing-index') : '' ?>" app-sandy-prevent="" class="mb-5 text-sticker secondary-box"><?= __('Change Plan') ?></a>
<?php endif ?>
<div class="grid grid-cols-2 gap-4 relative z-10">
    <?php foreach ($products as $item): ?>
    <?= \Sandy\Blocks\shop\Helper\Shop::shop_product_item($item) ?>
    <?php endforeach ?>
</div>
<a href="<?= \Bio::route($block->user, 'sandy-blocks-shop-home') ?>" class="mt-8 sandy-expandable-btn rounded-lg sandy-loader-flower"><span><?= clean(__('All Products'), 'titles') ?></span></a>