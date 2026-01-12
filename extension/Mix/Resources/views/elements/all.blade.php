@extends('mix::layouts.master')
@section('title', __('Elements'))
@section('content')

<div class="mix-padding-10">
    
<div class="dashboard-header-banner relative mt-0 mb-5">
    <div class="card-container">

        <div class="text-lg font-bold">{{ __('Accelerated Pages') }}</div>
        <div class="pr-20">
            
            <p class="text-xs text-gray-400">{{ __('Select an element to create a new section on your page. Add your content heading, text, images, videos and links then save when you’re done.') }}</p>

            
            <a href="{{ route('user-mix-apps') }}" class="button mt-5 px-10">{{ __('Create New') }}</a>

        </div>


        <div class="side-cta top-8">
            {!! orion('thunder-1', 'h-20') !!}
        </div>
    </div>
</div>

 @if (!$elements->isEmpty())
 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
     @foreach ($elements as $element)
     
     <div class="card p-5 rounded-2xl mb-7 block has-sweet-container border-4 border-solid border-gray-200">
        <div class="card-container bg-repeat-right">


            <div class="icon ">
                {!! Elements::icon($element->element) !!}
            </div>
            <div class="mt-5 text-xl font-bold mb-2 truncate">{{ $element->name }}</div>
            @if (Route::has("sandy-app-$element->element-render"))
                <a class="link-title flex text-xs mb-2" href="{{ route("sandy-app-$element->element-render", $element->slug) }}" iframe-trigger="" app-sandy-prevent="">/{{$element->slug}}/</a>
            @endif
            <p class="type text-xs mb-3"><i class="sni sni-spark"></i>{{ Elements::config($element->element, 'name') }}</p>
            <p class="date text-xs mb-3">{{ \Carbon\Carbon::parse($element->created_at)->format('Y / m / d') }}</p>

            <a app-sandy-prevent="" href="{{ route('user-mix-element-tree', ['slug' => $element->slug]) }}" class="sandy-expandable-btn px-10-"><span>{{ __('Manage') }}</span></a>
        </div>
    </div>

     <div class="card-elements mt-0 flex flex-col is-matching hidden" style="{{ Elements::thumbStyle($element->element) }}">
         <a href="{{ route('user-mix-element-tree', ['slug' => $element->slug]) }}" class="text-sticker mr-3 ml-auto flex items-center is-edit"><i class="sio internet-052-pencil"></i></a>
         <div class="card-titles">
             <div class="mb-3">
                 {!! Elements::icon($element->element) !!}
             </div>
             <h3 class="title">{{ $element->name }}</h3>
             @if (Route::has("sandy-app-$element->element-render"))
                 <a class="link-title flex" href="{{ route("sandy-app-$element->element-render", $element->slug) }}" iframe-trigger="" app-sandy-prevent="">/{{$element->slug}}/</a>
             @endif
             <p class="type"><i class="sni sni-spark"></i>{{ Elements::config($element->element, 'name') }}</p>
             <p class="date">{{ \Carbon\Carbon::parse($element->created_at)->format('Y / m / d') }}</p>
         </div>
     </div>
     @endforeach
 </div>
 @else
 @include('include.is-empty')
 @endif
 
</div>
@endsection