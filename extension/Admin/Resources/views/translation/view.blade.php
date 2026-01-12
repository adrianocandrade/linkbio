@extends('admin::layouts.master')
@section('title', __('View Languages'))
@section('namespace', 'admin-view-translation')

@section('footerJS')
   <script>
      app.utils.translangPop = function(){
         jQuery('[data-popup=".edit-values"]').on('dialog:open', function(e, $elem){
            var $previous = jQuery($elem).data('previous');
            var $new = jQuery($elem).data('new');

            var $dialog = jQuery(this);
            $dialog.find('[name="previous"]').html($previous);
            $dialog.find('input[name="previous"]').val($previous);
            $dialog.find('[name="new"]').html($new);


            $dialog.find('[name="new"], [name="previous"]').parent('.form-input').addClass('active');
         });
      }
      app.utils.translangPop();
   </script>
@stop
@section('content')


<div class="step-banner">
  <div class="section-header">
    <div class="section-header-info">
      <p class="section-pretitle">{{ __('Languages') }} ({{ count($languages) }})</p>
      <h2 class="section-title">{{ __('View Language') }}</h2>
      - 
      <p>
         {{ $lang }}
      </p>
    </div>
    <div class="section-header-actions">

      @if (config('app.APP_LOCALE') !== $lang)
        <form method="post" action="{{ route('admin-post-translation', ['type' => 'set_as_main', 'language' => $lang]) }}">
         @csrf

           <button class="section-header-action mr-4 text-white">
            {{ __('Set as main language') }}
           </button>
         </form>
      @endif

      <a class="edit-lang-open section-header-action mr-4">{{ __('Edit') }}</a>

      <a href="{{ route('admin-languages') }}" class="section-header-action">{{ __('All Translation') }} ></a>
     </div>
  </div>

  <form class="search__form mt-7" method="GET">
   <input class="search__input" type="text" name="query" placeholder="{{ __('Search') }}" value="{{ request()->get('query') }}">
     <button class="search__btn">
       <svg class="icon icon-search">
         <use xlink:href="{{ url('assets/image/svg/sprite.svg#icon-search') }}"></use>
       </svg>
     </button>
   </form>


  <div class="section-header mt-7">
    <div class="section-header-info">
       <label class="checkbox" data-inputs=".checkbox__input">
          <input class="checkbox__input" type="checkbox">
          <span class="checkbox__in"><span class="checkbox__tick"></span></span>
       </label>
    </div>
    <div class="section-header-actions">
      <a class="section-header-action cursor-pointer new-value-open mr-4">{{ __('New Value') }}</a>

      <a class="section-header-action text-sticker coolGray-900 mt-0 cursor-pointer update-all" data-route="{{ route('admin-post-translation', ['type' => 'multi_delete', 'language' => $lang]) }}"><i class="flaticon-delete"></i></a>
     </div>
  </div>
</div>


<div class="page-trans mb-10">
   <h6 class="text-xl mb-5">{{ __('All values') }}</h6>
   <div class="page-trans-table">
      @foreach ($values as $key => $value)
         <div class="table-flex">
            <div class="first-action">
               <label class="checkbox">
                  <input class="checkbox__input" name="action[]" value="{{ $key }}" type="checkbox">
                  <span class="checkbox__in"><span class="checkbox__tick"></span></span>
               </label>
            </div>

            <div class="middle">
               <div class="title">{{ $key }}</div>
               <div class="caption">{{ !is_array($value) ? $value : '' }}</div>
            </div>

            <div class="action flex">
               <a class="text-sticker edit-values-open cursor-pointer" data-previous="{{ $key }}" data-new="{{ !is_array($value) ? $value : '' }}">
                  <i class="flaticon-edit"></i>
               </a>

               <form action="{{ route('admin-post-translation', ['type' => 'delete', 'language' => $lang]) }}" method="post">
                  @csrf

                  <input type="hidden" name="previous" value="{{ $key }}">
                  <button class="text-sticker bg-red-500 text-white ml-4 cursor-pointer" data-delete="{{ __('Are you sure you want to delete this item?') }}">
                     <i class="flaticon-delete"></i>
                  </button>
               </form>
            </div>
         </div>
      @endforeach
   </div>
</div>





<div data-popup=".edit-values">
      <div class="inner-page-banner mb-10">
         <h1>{{ __('Change translation value') }}</h1>

         - 

         <p class="my-5">{{ __('Previous Value') }}</p>
         <hr>
         <p class="mt-5" name="previous"></p>
      </div>

      <form action="{{ route('admin-post-translation', ['type' => 'edit', 'language' => $lang]) }}" method="post">
         @csrf


         <input type="hidden" name="previous">

         <div class="form-input">
            <label>
               {{ __('New Value') }}
            </label>
            <textarea name="new" cols="30" rows="7"></textarea>
         </div>

        <button class="button main mt-5" type="submit">{{ __('Save') }}</button>
      </form>
      

      <button class="edit-values-close" data-close-popup><i class="flaticon-close"></i></button>
</div>




<div data-popup=".new-value">
      <div class="inner-page-banner mb-10">
         <h1>{{ __('Add new translation value') }}</h1>
         <p>{{ __('Translation value') }}</p>
      </div>

      <form action="{{ route('admin-post-translation', ['type' => 'new', 'language' => $lang]) }}" method="post">
         @csrf



         <div class="form-input mb-10">
            <label>
               {{ __('Previous Value') }}
            </label>
            <textarea name="previous" cols="30" rows="7"></textarea>
         </div>

         <div class="form-input">
            <label>
               {{ __('New Value') }}
            </label>
            <textarea name="new" cols="30" rows="7"></textarea>
         </div>

        <button class="button main mt-5" type="submit">{{ __('Save') }}</button>
      </form>
      

      <button class="new-value-close" data-close-popup><i class="flaticon-close"></i></button>
</div>


<div data-popup=".edit-lang">
      <div class="inner-page-banner mb-10">
         <h1>{{ __('Edit Language') }}</h1>
         <p>{{ __('Translation value') }}</p>
      </div>

      <form action="{{ route('admin-post-translation', ['type' => 'edit_lang', 'language' => $lang]) }}" method="post">
         @csrf



         <div class="form-input">
            <label>
               {{ __('Language Name') }}
            </label>
            <input name="newName" type="text" value="{{ $lang }}">
         </div>

        <button class="button main mt-5" type="submit">{{ __('Save') }}</button>
      </form>
      

      <button class="edit-lang-close" data-close-popup><i class="flaticon-close"></i></button>
</div>

@endsection
