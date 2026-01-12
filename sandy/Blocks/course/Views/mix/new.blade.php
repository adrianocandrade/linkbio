@extends('mix::layouts.master')
@section('title', __('New Course'))
@section('footerJS')
<script src="{{ url('assets/js/vendor/tinymce/tinymce.min.js') }}" data-barba-script></script>
<script src="{{ url('assets/js/vendor/tinymce/sr.js') }}" data-barba-script></script>
<script data-barba-script>
app.utils.Smalltinymce();
</script>
@stop
@section('content')
@includeIf('include.back-header', ['route' => route('sandy-blocks-course-mix-dashboard'), 'can_save' => true])
<form action="{{ route('sandy-blocks-course-mix-new-course-post') }}" method="post" enctype="multipart/form-data" class="mix-padding-10 dy-submit-header">
    @csrf
    <div class="card customize mb-10">
        <div class="card-header">
            <p class="title">{{ __('New Course') }}</p>
            <p class="subtitle">{{ __('Add a new course below.') }}</p>
        </div>
    </div>
    <div class="card customize mb-10">
        <div class="avatar-upload sandy-upload-modal-open mb-5">
            <div class="avatar">
                <div class="image lozad"></div>
            </div>
            <input type="file" class="avatar-upload-input" name="banner">
            <div class="content">
                <h5>{{ __('Banner') }}</h5>
                <p class="text-sticker">{{ __('Browse') }}</p>
            </div>
        </div>
        <div class="card-header">
            <div class="form-input mb-7 active">
                <label>{{ __('Name') }}</label>
                <input type="text" name="name" class="bg-w">
            </div>
            <div class="form-input active bio-tox">
                <label>{{ __('Description') }}</label>
                <textarea rows="4" name="description" class="bg-w editor"></textarea>
            </div>
            <div class="form-input mt-7">
                <label class="initial">{{ __('Course Level') }}</label>
                <select id="course-level" class="nice-select bg-w" multiple="" name="course_level[]">
                    <option value="beginner">{{ __('Beginner') }}</option>
                    <option value="advanced">{{ __('Advanced') }}</option>
                    <option value="intermediate">{{ __('Intermediate') }}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="text-base my-7 font-bold">{{ __('Price') }}</div>
    <div class="mort-main-bg p-5 rounded-2xl relative z-10 mt-5">
        <div class="form-input mb-5">
            <label class="initial">{{ __('Price Type') }}</label>
            <select name="price_type" class="bg-w" data-sandy-select=".select-shift">
                <option value="1">{{ __('Fixed Price') }}</option>
            </select>
        </div>
        <div class="select-shift">
            <div class="form-input hide" data-sandy-open="1">
                <label>{{ __('Price') }}</label>
                <input type="text" name="price" class="bg-w">
            </div>
        </div>
    </div>
    <div class="text-base my-7 font-bold">{{ __('Expiry') }}</div>
    <div class="card customize mb-10">
        <div class="sandy-tabs">
            <div class="grid grid-cols-2 gap-4">
                <label class="sandy-big-checkbox relative sandy-tabs-link">
                    <input type="radio" name="expiry_type" value="0" checked="" class="sandy-input-inner">
                    <div class="checkbox-inner rounded-2xl rounded-none card-shadow">
                        <div class="checkbox-wrap">
                            <div class="content">
                                <h1>{{ __('Forever') }}</h1>
                                <p>{{ __('Course does not expire.') }}</p>
                            </div>
                            <div class="icon">
                                <div class="active-dot">
                                    <i class="la la-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
                
                <label class="sandy-big-checkbox sandy-tabs-link">
                    <input type="radio" name="expiry_type" value="1" class="sandy-input-inner">
                    <div class="checkbox-inner rounded-2xl rounded-none card-shadow">
                        <div class="checkbox-wrap">
                            <div class="content">
                                <h1>{{ __('Expire on') }}</h1>
                                <p>{{ __('Set days to expire after purchase.') }}</p>
                            </div>
                            <div class="icon">
                                <div class="active-dot">
                                    <i class="la la-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="sandy-tabs-item"></div>
            <div class="sandy-tabs-item">
                <div class="card-header mt-5">
                    <div class="form-input active">
                        <label>{{ __('Set expiry days') }}</label>
                        <input type="number" name="expry_days" class="bg-w">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-base my-7 font-bold">{{ __('Course Includes or Requirments') }}</div>
    <div class="card customize mb-5">
        <div class="bg-white p-5 rounded-2xl">
            <div data-dynamic-wrapper>
                <div class="mb-5" data-dynamic-item="" data-items-name="includes">
                    <div class="flex">
                        <div class="form-input w-full mr-4">
                            <label class="">{{ __('Includes') }}</label>
                            <input type="text" data-item-name="includes" value="You will learn how to be code">
                        </div>
                        <a class="ml-auto flex items-center cursor-pointer" data-dynamic-remove=""><i class="flaticon-delete"></i></a>
                    </div>
                </div>
                <div class="mb-5" data-dynamic-item="" data-items-name="includes">
                    <div class="flex">
                        <div class="form-input w-full mr-4">
                            <label class="">{{ __('Includes') }}</label>
                            <input type="text" data-item-name="includes" value="Free and easy to use">
                        </div>
                        <a class="ml-auto flex items-center cursor-pointer" data-dynamic-remove=""><i class="flaticon-delete"></i></a>
                    </div>
                </div>
                
            </div>
            <a href="#" class="text-sticker m-0 bg-gray-200" data-dynamic-add>{{ __('Add') }}</a>
        </div>
    </div>
    {!! sandy_upload_modal() !!}

        <button class="shadow-none w-full button bg-gray-200 text-black toast-custom-close sandy-loader-flower mt-10">{{ __('Save') }}</button>
</form>
<div data-dynamic-template hidden>
    <div class="mb-5" data-dynamic-item="" data-items-name="includes">
        <div class="flex">
            
            <div class="form-input w-full mr-4">
                <label class="">{{ __('Includes') }}</label>
                <input type="text" data-item-name="includes">
            </div>
            <a class="ml-auto flex items-center cursor-pointer" data-dynamic-remove><i class="flaticon-delete"></i></a>
        </div>
    </div>
</div>
@endsection