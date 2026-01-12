<?php

if(!isset($previous)){
	$previous = false;
}

if(!isset($change_next)){
	$change_next = false;
}

?>

<div class="inner-pages-header mb-10">
	<div class="inner-pages-header-container">
		<a class="previous-page" href="{{ $previous }}">
			<p class="back-button"><i class="la la-arrow-left"></i></p>
			<h1 class="inner-pages-title ml-3">{{ __('Shop') }}</h1>
		</a>

		@if (!$change_next)
			<div class="buy-now-button"><span>{{ __('Bag') }}</span></div>
			@else
			{!! $change_next !!}
		@endif
	</div>
</div>