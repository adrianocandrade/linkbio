<div class="flex">
    <div class="mr-5">
        <i class="sio shopping-icon-026-money-bag sligh-thick"></i>
    </div>
    <div>
        <p class="font-medium text-sm">
            {{ __('Product Order') }}
        </p>
        <p class="text-gray-400 text-sm mt-2">
            {{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}
        </p>
    </div>
    <div class="ml-auto text-right">
        <p class="flex justify-end items-center">
            <span class="text-gray-400 mr-2"><i class="sni sni-plus"></i></span>
            <span class="font-medium text-sm">
                {!! \Bio::price(ao($item->data, 'amount'), $item->user) !!}
            </span>
        </p>
        @if ($user = \App\User::find(ao($item->data, 'user_id')))
        <p class="uppercase text-xs text-gray-600">
            {{ __('By') }} {{ $user->name }}
        </p>
        @endif
    </div>
</div>