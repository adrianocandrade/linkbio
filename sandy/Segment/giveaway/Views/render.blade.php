@extends('bio::layouts.master')
@section('content')
@section('head')
<style>
.giveaway h1{
font-size: 16px;
font-style: normal;
font-weight: bold;
margin-bottom: 4px;
color: inherit;
}
.context-body{
border-radius: 0 !important;
background: transparent !important;
position: relative;
}
.context-body .giveaway{
padding: 20px 32px;
border-radius: 10px;
display: block;
bottom: 0;
width: 100%;
background: #FFF;
}

body.is-dark .context-body .giveaway{
    background: #161616;
}
@@supports ((-webkit-backdrop-filter: none) or (backdrop-filter: none)) {
    .context-body .giveaway {
        -webkit-backdrop-filter: blur(4px);
        backdrop-filter: blur(4px);
    }
}

.date-of-birth{
    display: flex;
}

.date-of-birth .dob-title{
    font-size: 12px;
    line-height: 20px;
    padding: 4px;
    margin-right: 0px;
}

.date-of-birth .date-picker-container{
    display: flex;
    justify-content: flex-start;
    align-items: center;
    text-align: left;
}
.date-of-birth .date-picker-container .date-picker{
    display: flex;
}

.date-of-birth .date-picker-container .date-picker select{
    color: rgb(51, 51, 51);
    background: rgb(255, 255, 255) none repeat scroll 0% 0%;
    width: 100%;
    border: 1px solid rgb(204, 204, 204);
    margin: 0px 4px;
    padding: 5px;
    transition: border-color 0.3s ease-in-out 0s;
    appearance: none;
    border-radius: 5px;
    outline: currentcolor none medium;
    font-size: 12px;
}
.context-body{
    height: initial;
    border-radius: 20px;
}
#app-sandy-mix #content, #app-sandy-mix.is-bio{
    overflow: initial !important;
}
</style>
@stop
@section('is_element', true)
<div class="context bio h-screen p-5 {!! radius_and_align_class($bio->id, 'align') !!} is-element">
    <div class="bio-background">
        {!! media_or_url($element->thumbnail, 'media/element/thumbnail', true) !!}
    </div>
    <div class="context-head pt-10">
        <div class="avatar-thumb relative z-10 mb-5">
            <div class="avatar-container">
                <a href="/<?= e(config('app.bio_prefix')) ?><?= $bio->username ?>">
                    <div class="thumb" style="background: {{ao($bio->settings, 'avatar_color')}}">
                        {!! avatar($bio->id, true) !!}
                    </div>
                </a>
            </div>
            <div class="bio-info-container">
                <div class="bio-name-text theme-text-color flex">
                    {{ $bio->name }}
                    {!! user_verified($bio->id) !!}
                </div>
                <div class="bio-username-text theme-text-color">
                    {{ '@' . $bio->username }}
                </div>
            </div>
        </div>
    </div>
    <div class="context-body remove-before p-2 mt-10 rounded-xl">
        <form class="giveaway" method="post" action="{{ route('sandy-app-giveaway-submit', $element->slug) }}">
            @csrf

            <h1 class="title mb-5">{{ ao($element->content, 'caption') }}</h1>
            <div class="sm:grid sm:grid-cols-2 gap-4">
                
                
                <div class="form-input mb-5 col-span-2">
                    <label>{{ __('Email') }}</label>
                    <input type="text" name="email">
                </div>

                @if (ao($element->content, 'first_name'))
                    <div class="form-input mb-5">
                        <label>{{ __('First Name') }}</label>
                        <input type="text" name="first_name">
                    </div>
                @endif
                @if (ao($element->content, 'last_name'))
                    <div class="form-input mb-5">
                        <label>{{ __('Last Name') }}</label>
                        <input type="text" name="last_name">
                    </div>
                @endif
                @if (ao($element->content, 'phone'))
                    <div class="form-input mb-5 col-span-2">
                        <label>{{ __('Phone Number') }}</label>
                        <input type="text" name="phone">
                    </div>
                @endif
                @if (ao($element->content, 'dob'))
                    <div class="date-of-birth col-span-2">
                        <div class="dob-title">{{ __('Date Of Birth') }}</div>

                        <div class="date-picker-container">
                            <div class="date-picker">
                                <select name="dob[month]">
                                    @foreach (ao($date, 'months') as $key => $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <select name="dob[day]">
                                    @foreach (ao($date, 'days') as $key => $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <select name="dob[year]">
                                    @foreach (ao($date, 'year') as $key => $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif



            </div>
            <button class="button sandy-quality-button is-loader-submit loader-white">{{ __('Submit') }}</button>
        </form>


    </div>
</div>
@endsection