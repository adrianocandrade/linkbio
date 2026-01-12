<?php
    $rating = \App\Models\ProductReview::where('product_id', $item->id)->avg('rating');
    $variation = \App\Models\ProductOption::where('product_id', $item->id)->first();
?>

<div class="product-card-v2">
    <div class="product-card-v2-preview">
        <?= media_or_url($item->banner, 'media/shop/banner', true) ?>
    </div>
    <a href="<?= \Bio::route($item->user, 'user-bio-shop-single-product', ['id' => $item->id]) ?>" class="product-card-v2-link pb-0">
        <div class="product-card-v2-body">
            <div class="product-card-v2-line flex-col">
                <div class="product-card-v2-title mb-0 text-sm md:text-base"><?= $item->name ?></div>
                <div class="text-gray-400 text-sm h-16 md:14 overflow-hidden hidden"></div>
            </div>
            <div class="product-card-v2-line">
                <div class="flex justify-between w-full items-center">
                    <div class="star-rating">⭐ <?= round($rating, 2) ?></div>
                    <?php if (ao($item->stock_settings, 'enable') && !$variation): ?>
                    <div class="text-sm"><?= nr($item->stock) ?> <?= __('in stock') ?></div>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="product-card-v2-foot block md:flex">
            <div class="product-card-v2-status">
                <span class="block text-stage mb-0 product-type">🔥 <?= $item->productType ? __('Downloadable Product') : __('Normal Product') ?></span>
                <?php if ($variation): ?>
                <span><?= __('Choose variation') ?></span>
                <?php else: ?>
                <span>
                    <?php if (!empty($compare_price = $item->comparePrice)): ?>
                    <small class="line-through italic"><?= \Bio::price($compare_price, $item->user) ?></small>
                    <?php endif ?>
                <?= \Bio::price($item->price, $item->user) ?></span>
                <?php endif ?>
            </div>
        </div>
    </a>
</div>