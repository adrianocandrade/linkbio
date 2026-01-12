@extends('docs::layouts.master')
@section('content')
<div class="docs-search-header">
    <div class="search-image-container">
        <img src="{{ gs('assets/image/others/Asset-532.png') }}" class="search-image" alt="">
        <div class="search-image-text">
            <h1 class="search-heading-text">{{ __('Need Help?') }}</h1>
            <p class="search-heading-desc">{{ __('Search for a topic or question, check out our FAQs and guides, contact us for detailed support.') }}</p>
        </div>
    </div>
    <div class="search-results">
        <form class="search__form w-full" method="GET">
            <input class="search__input" type="text" name="query" placeholder="{{ __('Type your search word') }}">
            <button class="search__btn">
            <svg class="icon icon-search">
                <use xlink:href="{{ gs('assets/image/svg', 'sprite.svg#icon-search') }}"></use>
            </svg>
            </button>
        </form>
    </div>
</div>
<div class="title-sections mt-10">
    <h2 class="text-base">
    {{ __('Help by Category') }}
    </h2>
</div>
<div class="grid lg:grid-cols-3 docs-crate mb-10">

    @foreach ($docs as $item)
    <div class="crate-item">
        <div class="item-background">
            <div class="item-background-hover"></div>
        </div>
        <div class="crate-item-contents">
            <div class="content">
                <div class="icon">
                    
                </div>
                <h3>{{ $item->name }}</h3>
            </div>
            <div class="crate-li mt-8">
                @foreach ($guides[$item->id]['guide'] as $guide)
                <a href="{{ route('docs-guide', $guide->slug) }}">
                    <svg class="icon icon-settings">
                        <use xlink:href="{{ gs('assets/image/svg', 'sprite.svg#icon-document') }}"></use>
                    </svg>
                    <span>{{ $guide->name }}</span>
                </a>
                @endforeach
            </div>
            @if ($guides[$item->id]['guideCounts'] > 5)
            <div class="flex mt-5">
                <a href="{{ route('docs-guides', $item->id) }}" class="flex items-center mt-5 px-7 py-0.5 rounded-full cursor-pointer bg-gray-200 hover:bg-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <span class="text-sm font-medium text-secondary">{{ __('View All') }}</span>
                </a>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection