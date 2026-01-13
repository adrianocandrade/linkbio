@extends('admin::layouts.master')
@section('title', __('Edit Blog'))
@section('namespace', 'admin-new-blog')
@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}"></script>
<script>
  app.utils.changeInput = function(){
    jQuery('[name="type"]').each(function(){
      var objects = {
          changeInput: function ($this) {
            switch($this.find(':selected').attr("value")) {
              case "internal":
               jQuery('#blog-slug').find('label').html("{{ __('Slug') }}");
               jQuery('.input-side-pre').show();
               jQuery('#blog-slug').addClass('pre');
              break;
              case "external":
               jQuery('#blog-slug').find('label').html("{{ __('External Url') }}");
               jQuery('.input-side-pre').hide();
               jQuery('#blog-slug').removeClass('pre');
              break;
            }
          }
      }
      objects.changeInput(jQuery(this));
      jQuery(this).on('change', function(){
        objects.changeInput(jQuery(this));
      });
    });

  }

  app.utils.tinymce();
  app.utils.changeInput();

  jQuery('input[name="name"]').on('input', function() {
    var title = jQuery(this).val();
    var slug = title.toString().toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, "")
      .replace(/\s+/g, '-')
      .replace(/[^\w\-]+/g, '')
      .replace(/\-\-+/g, '-')
      .replace(/^-+/, '')
      .replace(/-+$/, '');
    jQuery('input[name="location"]').val(slug);
  });
</script>
@stop

@section('content')
<div class="sandy-page-row">
  <div class="sandy-page-col pl-0">
    <div class="page__head">
      <div class="step-banner remove-shadow">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle">{{ __('Blogs') }} ({{ number_format(\App\Models\Blog::count()) }})</p>
            <h2 class="section-title">{{ __('Edit Blog') }}</h2>
            <p class="mt-4">{{ __('Views') }} - <small>{{ $blog->total_views }}</small></p>
          </div>
          <div class="section-header-actions">
            <a href="{{ route('admin-blogs') }}" class="section-header-action">{{ __('All Posts') }}</a>
          </div>
        </div>
      </div>
    </div>
    <form method="post" action="{{ route('admin-edit-blog-post', $blog->id) }}" class="rounded-3xl card-shadow p-5" enctype="multipart/form-data">
      @csrf
      <div class="card cuztomize mb-5 p-5 mort-main-bg rounded-2xl">
        <div class="form-input">
          <label for="">{{ __('Name') }}</label>
          <input type="text" class="bg-w" value="{{ $blog->name }}" name="name">
        </div>
        <div class="grid grid-cols-2 gap-4 mt-5">
          <div class="form-input mt-5">
            <label class="initial">{{ __('Page type') }}</label>
            <select name="type" class="bg-w">
              <option value="internal" {{ $blog->type == 'internal' ? 'selected' : '' }}>{{ __('Internal') }}</option>
              <option value="external" {{ $blog->type == 'external' ? 'selected' : '' }}>{{ __('External') }}</option>
            </select>
          </div>
          <div class="form-input mt-5">
            <label class="initial">{{ __('Status') }}</label>
            <select name="status" class="bg-w">
              <option value="1" {{ $blog->status ? 'selected' : '' }}>{{ __('Active') }}</option>
              <option value="0" {{ !$blog->status ? 'selected' : '' }}>{{ __('Hidden') }}</option>
            </select>
          </div>
        </div>
      </div>
      <div class="mb-5 p-5 mort-main-bg rounded-2xl">
        <div class="form-input pre" id="blog-slug">
          <label class="initial">{{ __('Slug') }}</label>
          <div class="flex">
            <div class="input-side-pre">
              <span>{{ url('/') }}/{{ __('blog') }}/</span>
            </div>
            <input type="text" name="location" value="{{ $blog->location }}" class="bg-w">
          </div>
        </div>
      </div>
      <div class="mb-5 p-5 mort-main-bg rounded-2xl">
        <div class="flex items-center flex-col">
          <div class="h-avatar h-52 w-full is-upload is-outline-dark text-2xl" data-generic-preview=".h-avatar">
            <i class="flaticon-upload-1"></i>
            <input type="file" name="blog_thumbnail">
            <div class="image lozad" data-background-image="{{ gs('media/site/blog', $blog->thumbnail) }}"></div>
          </div>
        </div>
      </div>
      <div class="my-5 p-5 card mort-main-bg rounded-2xl">
        <div class="form-input">
          <label for="">{{ __('Description') }}</label>
          <textarea name="description" class="editor" id="" cols="30" rows="10">{!! $blog->description !!}</textarea>
        </div>
      </div>
      <div class="p-5 mort-main-bg mb-5 rounded-2xl">
        <div class="form-input">
          <label>{{ __('Author') }}</label>
          <input type="text" name="author" value="{{ $blog->author }}" class="bg-w">
        </div>
      </div>
      <div class="p-5 mort-main-bg rounded-2xl">
        <div class="form-input">
          <label>{{ __('Time to read. Ex: 5 min') }}</label>
          <input type="text" name="ttr" value="{{ $blog->ttr }}" class="bg-w">
        </div>
      </div>
      <div class="promotion__body px-0 pb-0">
        <button class="text-sticker is-submit is-loader-submit loader-white button">{{ __('Save') }}</button>
      </div>
    </form>
  </div>
  <div class="sandy-page-col sandy-page-col_pt100 md:px-10">
    <div class="card card_widget">
      <div class="card__head card__head_mb32">
        <div class="card__title h6">{{ __('Other Posts') }}</div>
      </div>
      
      <div class="sandy-quality">
        @forelse (\App\Models\Blog::limit(5)->get() as $item)
        <div class="admin-plans is-side">
          <div class="plan-details">
            <div class="title">
              {{ $item->name }}
            </div>
            <div class="plan-actions">
              <a href="{{ route('admin-edit-blog', $item->id) }}" class="action">{{ __('Edit') }}</a>
            </div>
          </div>
          <div class="h-avatar md ml-4">
            <img src="{{ gs('media/site/blog', $item->thumbnail) }}" alt="">
          </div>
        </div>
        @empty
        <div class="is-empty p-10 text-center">
          <img src="{{ gs('assets/image/others', 'empty-fld.png') }}" class="w-half m-auto" alt="">
          <p class="mt-10 text-lg font-bold">{{ __('It\'s kinda lonely here! Start creating.') }}</p>
          <a href="{{ route('admin-new-plan') }}" class="text-sticker mt-5">{{ __('Create Plan') }}</a>
        </div>
        @endforelse
        <a class="button sandy-quality-button bg-black" href="{{ route('admin-blogs') }}">{{ __('All Posts') }}</a>
      </div>
    </div>
  </div>
</div>
@endsection
