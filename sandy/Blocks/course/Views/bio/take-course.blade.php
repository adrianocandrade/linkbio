@extends('bio::layouts.master')
@section('footerJS')
    <script>
        jQuery(document).on('click', '.sandy-tabs-link', function(){
            jQuery('html, body').animate({ scrollTop: 0 }, 250);
        });
    </script>
@stop
<style>
    .bio-menu{
        display: none  !important;
    }
</style>
@section('content')
<div class="bio-single-shop-product is-course">
    
    <div class="center course-body mt-32">
        
        
        
        
        <a class="text-stage mb-10 underline text-gray-400 flex items-center" href="{{ \Bio::route($bio->id, 'sandy-blocks-course-single-course', ['id' => $course->id]) }}"> <i class="la la-arrow-left mr-3"></i> {{ $course->name }}</a>
        <div class="sandy-tabs mt-20">
            @foreach ($lessons as $item)
            <div class="sandy-tabs-item">
                
                <h1 class="product-title mb-5">{{ $item->name }}</h1>
                <div class="icon">
                    <i class="{{ $types_icon($item->lesson_type) }} sligh-thick text-lg"></i>
                </div>
                <p class="duration text-gray-400 text-sm mb-5">{{ $item->lesson_duration }}</p><div class="text-base mb-10" style="
                ">
                <div class="details__text">
                    {{ $item->description }}
                </div>
            </div>
            <hr class="mb-5">
            @includeIf("Blocks-course::bio.lesson.$item->lesson_type", ['course' => $course, 'lesson' => $item])
        </div>
        @endforeach
        <div class="mt-10"></div>
        <hr class="mb-5">
        <div class="lesson-item">
            @foreach ($lessons as $item)
            <div class="lessions flex items-center cursor-pointer sandy-tabs-link mb-8 {{ $loop->first ? 'active' : '' }}">
                <div class="icon mr-3 flex items-center">
                    <i class="sligh-thick text-lg border-2 rounded-full h-8 w-8 flex items-center justify-center">{{ $loop->iteration }}</i>
                </div>
                <div class="lession-detail">
                    <h1 class="text-base">{{ $item->name }}</h1>
                    <p class="duration text-gray-400 text-sm">{{ $item->lesson_duration }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="mb-32"></div>
</div>
@endsection