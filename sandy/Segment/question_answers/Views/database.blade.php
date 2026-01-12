@extends('mix::layouts.master')
@section('content')
@section('head')
<link rel="stylesheet" href="{{ \Elements::getPublicAssets($element->element, "assets", 'response-asset.css') }}">
@stop

@section('footerJS')
    <script>
        app.utils.viewModal = function(){
          jQuery('[data-popup=".respond"]').on('dialog:open', function(e, $elem){
            var $id = jQuery($elem).data('id');
            var $dialog = jQuery(this);
            $dialog.find('[name="id"]').val($id);
          });
        };
        app.utils.viewModal();
    </script>
@stop
<div>
    @csrf
    <div class="inner-page-banner">
        
        <div class="heading has-icon">
            <i class="sio database-and-storage-002-server text-3xl mr-2"></i>
            {{ __('Database') }}
        </div>
        <div class="mt-5">{!! Elements::icon($ElemName) !!}</div>
        <h1 class="mt-5 text-base">{{ Elements::config($ElemName, 'name') }}</h1>
        <p>{{ __('All Submissions from this element.') }}</p>
    </div>
    <div class="p-10">
        @if (!$db->isEmpty())
        @foreach ($db as $item)
        <div>
            
            <div class="response mb-5">
                <div class="response-text">
                    {{ ao($item->database, 'question') }}
                </div>
                <span class="name-time">{{ ao($item->database, 'name') }} · <time>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</time></span>
                <div class="response-answer">
                    <div class="response-heading">{{ __('Response') }}</div>
                    @if (!empty(ao($item->database, 'response')))
                    <div class="response-text mt-3 mb-0">
                        {{ ao($item->database, 'response') }}
                    </div>
                    @else
                    <div class="flex">
                        
                        <a href="#" class="text-sticker bg-gray-200 respond-open" data-id="{{ $item->id }}">{{ __('Respond') }}</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        @else
        @include('include.is-empty')
        @endif
    </div>
</div>

<div class="p-10" data-popup=".respond">
    
    <form method="post" action="{{ route('sandy-app-question_answers-user-respond', $element->slug) }}">
        @csrf
        <input type="hidden" name="id">
        <div class="text-center">
            <div class="form-input mb-5">
                <label>{{ __('Response') }}</label>
                <textarea name="response" cols="30" rows="10"></textarea>
            </div>
            <button class="button mt-5 w-full">{{ __('Post') }}</button>
        </div>
    </form>
</div>
@endsection