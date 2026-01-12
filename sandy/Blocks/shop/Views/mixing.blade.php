<?php
$heading = ao($block, 'name');
$content = ao($block->blocks, 'content');
$product_limit = (int) ao($block->blocks, 'products') ?? 0;
$products = \Sandy\Blocks\shop\Models\Product::where('user', $block->user)->orderBy('position', 'ASC')->orderBy('id', 'ASC')->get();
?>
<div class="grid grid-cols-2 gap-4 relative z-10">
    <?php foreach ($products as $item): ?>
    <div class="product-card-v2">
        <div class="product-card-v2-preview">
            <?= media_or_url($item->banner, 'media/shop/banner', true) ?>
        </div>
        <a href="<?= route('sandy-blocks-shop-mix-edit-product', $item->id) ?>" app-sandy-prevent="" class="product-card-v2-link pb-0">
            <div class="product-card-v2-body">
                <div class="product-card-v2-line flex-col">
                    <div class="product-card-v2-title mb-0 text-sm md:text-base"><?= $item->name ?></div>
                    <div class="text-gray-400 text-sm h-16 md:14 overflow-hidden hidden"></div>
                </div>
            </div>
            <div class="product-card-v2-foot block md:flex mt-0 pt-2">
                <div class="product-card-v2-status w-full">
                    <span><?= \Bio::price($item->price, $item->user) ?></span>
                    <p class="mt-3 sandy-expandable-btn block rounded-xl"><span><?= __('Edit') ?></span></p>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach ?>
</div>
<div class="add-new-link my-5 sm">
  <a class="el-btn m-0" app-sandy-prevent="" href="<?= route('sandy-blocks-shop-mix-new-product') ?>"><i class="sni sni-plus"></i></a>
</div>