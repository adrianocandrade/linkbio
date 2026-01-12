@extends('docs::layouts.master')
@section('title', __('Support'))

@section('footerJS')
    <script src="{{ gs('assets/js/emoji-picker.js') }}"></script>
    <script>

      app.utils.emoji_picker = function(){

          var button = document.querySelector('.add-emoji');

          var picker = new EmojiButton({
            position: 'bottom-start',
            autoHide: false,
            emojisPerRow: 7,
            autoFocusSearch: false
          });

          button.addEventListener('click', () => {
            picker.togglePicker(button);
          });

          picker.on('emoji', emoji => {
             document.querySelector('#chat-input').value += emoji;
          });
      }
      app.utils.emoji_picker();
</script>
@stop
@section('content')
<div class="support-div">
   <div class="support-chat">
      <div class="support-top block sm:flex mb-14 items-center">
         <div class="support-info mr-auto">
          <div class="text-2xl">
            {{ $conversation->topic }}
          </div>

          <div class="text-sm mt-5">
            {{ $conversation->description }}
          </div>
         </div>
         <div class="support-actions flex items-center mt-5 sm:mt-0">
            <p class="text-sticker m-0">{{ $conversation->status ? __('Opened') : __('Closed') }}</p>
            <a href="{{ route('user-support-my-requests') }}" class="ml-4"><i class="sio security-icon-037-customer-support text-2xl"></i></a>
         </div>
      </div>
      <div class="messages p-5 sm:p-10 rounded-3xl" bg-style="#fafafa">
         
         <div class="message-list" hx-get="{{ route('user-support-get-messages', $conversation->id) }}" hx-trigger="every 10s" hx-indicator="#indicator" hx-swap="innerHTML" _="on htmx:afterOnLoad call app.utils.lozad()">
            {!! support_conversation_messages($conversation->id) !!}
         </div>

            <div class="htmx-indicator text-black" id="indicator">{{ __('Fetching new data...') }}</div>
      </div>



      <form method="post" action="{{ route('user-support-respond') }}" enctype="multipart/form-data" class="editor sandy-tabs mt-20">
         @csrf
         <input type="hidden" value="{{ $conversation->id }}" name="conversation_id">

         <input type="hidden" value="text" name="message_type" id="message-type">

         <div class="editor__wrap">
            <div class="editor__head">
               <div class="editor__control">
                  <a class="editor__action sandy-tabs-link active" data-change-type="text" data-change-input="#message-type">
                     <i class="sio design-and-development-048-text-tool sligh-thick text-lg text-black"></i>
                  </a>
                  <a class="editor__action sandy-tabs-link" data-change-type="image" data-change-input="#message-type">
                     <i class="sio design-and-development-061-picture sligh-thick text-lg text-black"></i>
                  </a>
                  <a class="editor__action sandy-tabs-link" data-change-type="link" data-change-input="#message-type">
                     <i class="sio seo-and-marketing-058-linked sligh-thick text-lg text-black"></i>
                  </a>
                  <a class="editor__action sandy-tabs-link" data-change-type="file" data-change-input="#message-type">
                     <i class="sio network-icon-039-file-download text-lg sligh-thick text-black"></i>
                  </a>
               </div>
               <a class="ml-auto add-emoji cursor-pointer">
                  <i class="sio media-icon-038-smiley text-lg sligh-thick text-black"></i>
               </a>
            </div>

            <div class="editor__body">
               <div class="sandy-tabs-item">
                  <div class="editor__field">
                     <textarea class="editor__textarea" id="chat-input" name="message" placeholder="{{ __('text ...') }}"></textarea>
                  </div>
               </div>
               <div class="sandy-tabs-item">
                  <div class="sandy-upload-v2 border-dashed cursor-pointer" data-generic-preview="">
                     <div class="image-con">
                        <div class="image"></div>
                        <div class="file-name"></div>
                     </div>
                     <div class="info">
                        {{ __('Attach an image') }}
                     </div>
                     <div class="add-button">
                        {{ __('Select') }}
                     </div>
                     <input type="file" name="image" accept="image/*">
                  </div>
               </div>
               <div class="sandy-tabs-item">
                  <div class="form-input">
                     <label>{{ __('Link') }}</label>
                     <input type="text" class="bg-w" name="link">
                  </div>
               </div>
               <div class="sandy-tabs-item">
                  <div class="sandy-upload-v2 card-shadow mb-5 border-white cursor-pointer" data-generic-preview="">
                     <div class="image-con">
                        <div class="file-name"></div>
                     </div>
                     <div class="info">
                        {{ __('Attach a file') }}
                     </div>
                     <div class="add-button">
                        {{ __('Add') }}
                     </div>
                     <input type="file" name="file">
                  </div>
               </div>
            </div>

            @if ($conversation->status)
               <button class="text-sticker mt-0 m-5">{{ __('Reply') }}</button>
               @else
               <p class="p-5 italic text-xs">{{ __('Ticket has been solved & closed.') }}</p>
            @endif
         </div>
      </form>
   </div>
</div>
@endsection