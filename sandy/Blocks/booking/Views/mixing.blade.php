<?php

    use Sandy\Blocks\booking\Helper\Time;
    use Sandy\Blocks\booking\Models\BookingService;
    $time = new Time($block->user);

    $date = \Carbon\Carbon::now();
    $services = BookingService::where('user', $block->user)
        ->when($block->workspace_id, function($q) use ($block){
             $q->where('workspace_id', $block->workspace_id);
        })
        ->count();

    $image = random_avatar("booking-avatar-$block->id", 'adventurer-neutral');
    $gallery = user('booking.gallery', $block->user);
    $image = !empty($gallery) && is_array($gallery) ? gs('media/booking', array_values($gallery)[0] ?? '') : $image;

    $available = $time->check_workday(date('l', strtotime($date->format('Y-m-d'))), $block->user);
?>

<style>
    .booking-card-1{
        border: 2px dashed #cecccc;
    }
</style>

<div class="booking-card-1 bg-transparent">
    <div class="head-card flex justify-between items-center">
        <div class="creator-name">
            <div class="image-user">
                <?= avatar($block->user, true) ?>

            </div>
            <h3><?= user('name', $block->user) ?></h3>
        </div>

        <a href="{{ route('sandy-blocks-booking-mix-dashboard') }}" class="sandy-expandable-btn rounded-lg"><span>{{ __('Manage') }}</span></a>
    </div>
    <div class="body-card py--0 pt-0">
        <div class="cover-image">
            <img class="img-cover" src="<?= $image ?>" alt=" ">
        </div>

    </div>
    <div class="footer-card">
        <div class="starting-bad">
            <h4><?= $services ?> <?= __('Services') ?></h4>
            <span class="font-bold <?= $available ? 'text-green-600' : 'text-red-600' ?>"><?= $available ? __('Available today') : __('Not available') ?></span>
        </div>
        <button type="button" class="button rounded-lg h-10 pl-4 pr-4"><?= __('Book Now') ?></button>
    </div>
</div>
