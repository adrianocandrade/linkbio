@extends('mix::layouts.master')
@section('title', __('Wizard'))
@section('content')
@section('head')
<style>
.header, header, .floaty-bar{
display: none !important;
}
#content{
display: flex !important;
flex-direction: column !important;
}
.h-avatar.is-upload{
padding: 14px !important;
}
.h-avatar.is-upload img, .h-avatar.is-upload .solid-color, .h-avatar.is-upload video, .h-avatar.is-upload .image {
position: relative !important;
}
.h-avatar.is-upload::before{
border-radius: inherit !important;
}
</style>
@stop
<div class="onboarding-wizard sandy-tabs my-auto mix-padding-10">
    <div class="onboarding-step-bar">
        
        <div class="font-12 text-gray onboarding-step-bar-caption"></div>
    </div>
    <div class="onboarding-items">
        
        <div class="sandy-tabs-item" >
            <div>
                <div class="font-bold text-lg">Magic setup ✨</div>
                <div class="text-gray-400 text-xs mb-10">Use your existing content to instantly customize your page.</div>
                <div class="form-input is-link always-active active mt-5">
                    <label>{{ __('Instagram') }}</label>
                    <div class="is-link-inner">
                        <div class="side-info">
                            <div class="flex items-center text-black">
                                <i class="la la-instagram mr-2"></i>
                                <p>@</p>
                            </div>
                        </div>
                        <input type="text" name="social[instagram]" placeholder="{{ __('Your Instagram Username') }}" class="bg-w" value="{{ user('username') }}">
                    </div>
                </div>
                <div class="form-input is-link always-active active mt-5">
                    <label>{{ __('Facebook') }}</label>
                    <div class="is-link-inner">
                        <div class="side-info">
                            <div class="flex items-center text-black">
                                <i class="la la-facebook mr-2"></i>
                                <p>@</p>
                            </div>
                        </div>
                        <input type="text" name="social[facebook]" placeholder="{{ __('Your Facebook Username') }}" class="bg-w">
                    </div>
                </div>
                <div class="form-input is-link always-active active mt-5">
                    <label>{{ __('Twitter') }}</label>
                    <div class="is-link-inner">
                        <div class="side-info">
                            <div class="flex items-center text-black">
                                <i class="la la-twitter mr-2"></i>
                                <p>@</p>
                            </div>
                        </div>
                        <input type="text" name="social[twitter]" placeholder="{{ __('Your Twitter Username') }}" value="{{ user('username') }}" class="bg-w">
                    </div>
                </div>
            </div>
        </div>
        <div class="sandy-tabs-item" >
            <div class="hidden">
                <div class="font-bold text-lg">{{ __('Setting up your page. 😻') }}</div>
                <div class="text-gray-400 text-xs mb-10">Use your existing content to instantly customize your page.</div>
            </div>
            
            <div class="h-avatar h-32 w-32 is-upload is-outline-dark text-2xl mb-5 rounded-full remove-after" data-generic-preview=".h-avatar">
                
                {!! avatar($user->id, true) !!}
                <input type="file" name="avatar" accept="image/*">
                <div class="sandy-file-name"></div>
            </div>
            
            <div class="form-input">
                <label>{{ __('A little about you') }}</label>
                <textarea rows="4" name="bio">{{ $user->bio }}</textarea>
            </div>




            <div class="grid grid-cols-2 gap-4 mt-5">
                <label class="sandy-big-checkbox is-html-demo">
                    <input type="radio" class="sandy-input-inner" name="settings[radius]" value="round" checked="">

                    <div class="checkbox-inner h-full items-center">    
                        <div class="html-demo-bio">
                            <div class="flex w-full">
                                <div>
                                    <div class="html-demo-avatar"></div>
                                </div>
                                <div class="w-full ml-2">
                                    
                                    <div class="html-demo-description h-2"></div>
                                    <div class="html-demo-description h-2 mt-2"></div>
                                </div>
                            </div>
                            <div class="html-demo-description"></div>
                            <div class="html-demo-socials">
                                <div class="html-demo-social-item"></div>
                                <div class="html-demo-social-item"></div>
                                <div class="html-demo-social-item"></div>
                                <div class="html-demo-social-item"></div>
                            </div>
                        </div>
                    </div>
                </label>
                <label class="sandy-big-checkbox is-html-demo">
                    <input type="radio" class="sandy-input-inner" name="settings[radius]" value="round" checked="">
                    <div class="checkbox-inner h-full items-center">
                        
                        <div class="html-demo-bio">
                            <div class="flex w-full flex-col">
                                <div class="flex justify-center">
                                    
                                    <div class="html-demo-avatar"></div>
                                </div>
                                <div class="w-full">
                                    
                                    <div class="html-demo-description h-2"></div>
                                    <div class="html-demo-description h-2 mt-2"></div>
                                </div>
                            </div>
                            <div class="html-demo-description"></div>
                            <div class="html-demo-socials justify-center">
                                <div class="html-demo-social-item"></div>
                                <div class="html-demo-social-item"></div>
                                <div class="html-demo-social-item"></div>
                                <div class="html-demo-social-item"></div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>

        </div>

        <div class="sandy-tabs-item">
            

            <div class="grid grid-cols-2 gap-4 mt-5">
                <label class="sandy-big-checkbox is-html-demo">
                    <input type="radio" class="sandy-input-inner" name="settings[radius]" value="round" checked="">

                    <div class="checkbox-inner h-full items-center">
                        
                        <div class="html-demo-bio has-bio-background w-full">

                            <div class="html-demo-background-main"></div>
                            <div class="flex w-full flex-col">
                                <div class="flex">
                                    
                                    <div class="html-demo-avatar"></div>
                                </div>
                                <div class="w-full">
                                    
                                    <div class="html-demo-description h-2"></div>
                                    <div class="html-demo-description h-2 mt-2"></div>
                                </div>
                            </div>
                            <div class="html-demo-description"></div>
                        </div>
                    </div>
                </label>
                <label class="sandy-big-checkbox is-html-demo">
                    <input type="radio" class="sandy-input-inner" name="settings[radius]" value="round" checked="">
                    <div class="checkbox-inner h-full items-center">
                        
                        <div class="html-demo-bio has-bio-banner w-full">

                            <div class="html-demo-background-banner"></div>
                            <div class="flex w-full flex-col">
                                <div class="flex">
                                    
                                    <div class="html-demo-avatar"></div>
                                </div>
                                <div class="w-full">
                                    
                                    <div class="html-demo-description h-2"></div>
                                    <div class="html-demo-description h-2 mt-2"></div>
                                </div>
                            </div>
                            <div class="html-demo-description"></div>
                        </div>
                    </div>
                </label>
            </div>
        </div>
        <div class="sandy-tabs-item" id="plan-page">
            <div class="plan-item js-plan-item is-active m-0">
                <div class="plan-star">⭐</div>
                <div class="plan-category">
                    <div class="plan-icon">
                    <svg class="svg-icon orion-svg-icon w-5 h-5 stroke-current text-white"><use xlink:href="http://yettitest.ng/assets/image/svg/orion-svg-sprite.svg#smiley-1"></use></svg>
                </div>
                <div class="plan-text">Individual</div>
            </div>
            <h3 class="plan-title title title_sm">Professional</h3>
            <div class="plan-price"><span class="plan-money">$19.99</span> /month</div>
            <ul class="plan-list">
                <li><svg class="svg-icon orion-svg-icon "><use xlink:href="http://yettitest.ng/assets/image/svg/orion-svg-sprite.svg#plan-box"></use></svg> 1 user</li>
                <li>2 TB of secure storage</li>
                <li>Premium productivity features and simple, secure file sharing</li>
            </ul>
            <a class="button" href="#popup-contact" data-effect="mfp-zoom-in">Try free for 30 days</a>
        </div>
    </div>
    <div class="sandy-tabs-item">
        <div class="text-center flex flex-col items-center">
            <div>
                <img src="{!! \Bio::emoji('Smiling_Face_with_Heart_Eyes') !!}" alt="Smiling_Face_with_Heart_Eyes" class="w-10">
            </div>
            <div class="font-bold text-lg">{{ __('Your page is ready! 🥳') }}</div>
            <div class="text-gray-400 text-xs">Use your existing content to instantly customize your page.</div>
        </div>
        <div class="mt-5 form-input">
            <input type="text" value="{{ bio_url($user->id) }}" disabled="" readonly="">
        </div>
        <button class="text-xs flex items-center copy-btn mt-3" data-copy="{{ bio_url(user('id')) }}" data-after-copy="{{ __('Copied') }}">
        {{ __('Copy') }}
        <i class="icon flaticon2-copy ml-2"></i>
        </button>
        <a href="{{ route('user-mix') }}" class="mt-5 button w-full">{{ __('Start Mixing') }}</a>
    </div>
</div>
<div class="onboarding-menu mt-5">
    <a class="sandy-tabs-link onboarding-menu-item button active">{{ __('Proceed') }}</a>
    <a class="sandy-tabs-link onboarding-menu-item button">{{ __('Proceed') }}</a>
    <a class="sandy-tabs-link onboarding-menu-item button">{{ __('Proceed') }}</a>
    <a class="sandy-tabs-link onboarding-menu-item button">{{ __('Proceed') }}</a>
    <a class="sandy-tabs-link onboarding-menu-item button">{{ __('Proceed') }}</a>
</div>
</div>
@endsection