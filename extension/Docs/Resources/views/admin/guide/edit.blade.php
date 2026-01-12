@extends('admin::layouts.master')
@section('title', __('Edit Guide'))
@section('content')
@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}"></script>
<script>
app.utils.tinymce();
</script>
@stop
<div class="sandy-page-row">
  <div class="sandy-page-col pl-0">
    <div class="page__head">
      
      <div class="section-header mb-16">
        <div class="section-header-info">
          <p class="section-pretitle">{{ __('Edit Guide') }}</p>
          <h2 class="section-title">{{ __('Guide') }}</h2>
        </div>
        <div class="section-header-actions">
          <a href="{{ route('admin-docs-view', ['id' => $docs->id]) }}" class="section-header-action">{{ __('All Guides') }}</a>
        </div>
      </div>
    </div>
    <form method="post" action="{{ route('admin-docs-guide-edit-post', ['id' => $docs->id, 'guide_id' => $guide->id]) }}"enctype="multipart/form-data">
      @csrf
      <div class="col-span-2">
        <div class="card-shadow p-5 rounded-2xl">
          <div class="card cuztomize mb-5 p-5 mort-main-bg rounded-2xl">
            <div class="form-input">
              <label for="">{{ __('Name') }}</label>
              <input type="text" class="bg-w" value="{{ $guide->name }}" name="name">
            </div>
            <div class="grid md:grid-cols-2 gap-4 mt-5">
              <div class="form-input mt-5">
                <label class="initial">{{ __('Short Description') }}</label>
                <input type="text" class="bg-w" value="{{ ao($guide->content, 'subdes') }}" name="short_des">
              </div>
              <div class="form-input mt-5">
                <label class="initial">{{ __('Docs Category') }}</label>
                <select name="docs" id="" class="bg-w">
                  @foreach ($alldocs as $item)
                  <option value="{{ $item->id }}" {{ $guide->docs_category == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-input mt-5">
                <label class="initial">{{ __('Status') }}</label>
                <select name="status" class="bg-w">
                  <option value="1" {{ $guide->status ? 'selected' : '' }}>{{ __('Active') }}</option>
                  <option value="0" {{ !$guide->status ? 'selected' : '' }}>{{ __('Hidden') }}</option>
                </select>
              </div>
            </div>
          </div>
          <div class="my-5 p-5 card mort-main-bg rounded-2xl">
            <div class="form-input">
              <label for="">{{ __('Description') }}</label>
              <textarea name="description" class="editor" id="" cols="30" rows="10">{{ ao($guide->content, 'content') }}</textarea>
            </div>
          </div>
          <div class="promotion__body px-0 pb-0 mb-0">
            <button class="promotion__btn button">{{ __('Save') }}</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="sandy-page-col sandy-page-col_pt100">
    <div class="card card_widget">
      <div class="card__head card__head_mb32">
        <div class="card__title h6">{{ __('Info') }}</div>
      </div>
      <div class="flex items-center">
        <i class="text-2xl sio banking-finance-flaticon-097-information-sign mr-3"></i>
        <p>{{ __('Use the fields to add a new Documentation guide. Please fill in the required information.') }}</p>
      </div>
      <p class="italic text-xs mt-5">{{ __('(Note: The "name" field is used for search query across the entire script. Do well to name your guide well.)') }}</p>
      
      <form action="{{ route('admin-docs-guide-delete', ['id' => $docs->id, 'guide_id' => $guide->id]) }}" class="mt-5" method="post">
        @csrf
        <button data-delete="{{ __('Are you sure you want to delete this?') }}" class="text-sticker bg-red-500 text-white m-0"><i class="flaticon-delete"></i></button>
      </form>

      <a class="button sandy-quality-button" href="{{ route('admin-docs-view', ['id' => $docs->id]) }}">{{ __('Guides') }}</a>
    </div>
  </div>
</div>
@endsection