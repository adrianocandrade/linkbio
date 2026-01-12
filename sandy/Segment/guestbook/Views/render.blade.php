@extends('bio::layouts.master')
@section('content')
@section('head')
    <style>
        .list-items{
            background: #fad063;
            color: #fff;
            min-height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            word-break: break-word;
            padding: 10px 25px;
            border-radius: 10px;
            text-align: center;
        }

        .list-items:not(:last-child){
            margin-bottom: 15px;
        }

        .guestbook-title{
            padding: 20px 32px;
            background: #fff;
            border-radius: 10px;
        }

        body.is-dark .guestbook-title{
            background: #161616;
        }

        .guestbook-title h1{
            font-size: 22px;
            font-style: normal;
            font-weight: bold;
            margin-bottom: 4px;
            color: inherit;
        }

        .guestbook-title p{
            font-size: 15px;
            font-weight: normal;
            font-style: normal;
            line-height: 21px;
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

@section('footerJS')
    <script>

      app.utils.guestbook = function(){
         jQuery('[data-popup=".add-list"]').on('dialog:open', function(e, $elem){
            const colors = ["#fad063", "#4484d2", "#2dbcde", "#61bd72", "#6e4da4", "#d75fac", "#e797aa", "#f44336", "#d75fac", "#000000"];
            const random = Math.floor(Math.random() * colors.length);

            var $dialog = jQuery(this);
            $dialog.find('input[name="color"]').val(colors[random]);

            $dialog.find('.form-input textarea').css('background', colors[random]);
            $dialog.find('.form-input textarea').css('color', '#fff');
            $dialog.find('.form-input label').css('color', '#fff');
         });
      };
      app.utils.guestbook();
    </script>
@stop
@section('is_element', true)
<div class="context bio {!! radius_and_align_class($bio->id, 'align') !!} is-element p-5">
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
    <div class="context-body rounded-2xl my-auto px-5 pb-5">
        <a class="text-sticker add-list-open mb-5 cursor-pointer">{{ __('Post') }}</a>
        <div class="mb-10 guestbook-title">
            <h1 class="title">{{ $element->name }}</h1>
            <p>{{ ao($element->content, 'description') }}</p>
        </div>
        @forelse ($allDB as $item)
        @php
        $database = $item->database;
        @endphp
        <div class="list-items p-10" style="background: {{ ao($database, 'color') }}">
            {{ ao($database, 'content') }}
        </div>
        @empty
        
        @include('include.is-empty')
        @endforelse
    </div>
</div>
<div class="" data-popup=".add-list">
    <form class="sandy-dialog-body" method="post" action="{{ route('sandy-app-guestbook-post-list', $element->slug) }}">
        @csrf
        <input type="hidden" value="#000" name="color">
        <div class="form-input text-count-limit" data-limit="200">
            <label>{{ __('Write Something') }}</label>
            <span class="text-count-field"></span>
            <textarea name="content" cols="30" rows="10"></textarea>
        </div>
        <button class="text-sticker mt-5">{{ __('Post') }}</button>
    </form>
    <button type="button" class="add-list-close bg-black" data-close-popup><i class="flaticon-close"></i></button>
</div>
@endsection