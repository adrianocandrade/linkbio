
<div class="bio-swiper-container">
    <div class="bio-swiper-wrapper">
        <div class="bio-swiper-slide">

        <?php foreach ($sections as $item): ?>
            <a class="swiper-item">
                <div class="is-card">
                    <?= media_or_url($item->thumbnail, 'media/blocks', true) ?>
                    <div class="card-infos">
                        <h2><?= clean(ao($item->content, 'heading'), 'titles') ?></h2>
                    </div>
                </div>
            </a>
        <?php endforeach ?>
         </div>
         <div class="bio-slider-arrows">
             <div class="slide-left hidden">
                 <i class="sni sni-arrow-left-c"></i>
             </div>

             <div class="slide-right hidden">
                 <i class="sni sni-arrow-right-c"></i>
             </div>
         </div>
     </div>
 </div>