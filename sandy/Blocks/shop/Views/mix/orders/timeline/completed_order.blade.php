<div class="flex">
    <div class="mr-5">
        <i class="sio office-047-checkmark text-green-500 sligh-thick"></i>
    </div>
    <div>
        <p class="font-medium text-sm">
            {{ __('Order Completed') }}
        </p>
        <p class="text-gray-400 text-sm mt-2">
            {{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}
        </p>
    </div>
    <div class="ml-auto text-right">
        <p class="font-medium text-xs">
            {{ __('Marked as completed') }}
        </p>
    </div>
</div>