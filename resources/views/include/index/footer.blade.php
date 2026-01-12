<footer class="footer">
   <div class="footer-center center">
      <div class="footer-row">
         <div class="footer-col">
            <a class="footer-logo" href="{{ url('/') }}">
               <img class="some-icon" src="{{ logo() }}" alt="{{ config('app.name') }}">
            </a>
            <p class="text-base">
               {!! __t('Start collecting money, feedbacks, emails, anonymous notes and more.') !!}
            </p>
            <div class="flex mt-5">
               
               <a href="#" class="sandy-btn register-modal-open">
                  <span class="background"></span>
                  <span class="hover"></span>
                  <span class="text">{{ __('Get Started') }}</span>
               </a>
            </div>
         </div>
         <div class="footer-col">
            <div class="footer-group">
               <div class="footer-head">{{ __('Page') }}
                  <svg class="icon icon-arrow-bottom">
                     <use xlink:href="{{ url('assets/image/svg/sprite.svg#icon-arrow-bottom') }}"></use>
                  </svg>
               </div>
               <div class="footer-body">
                  <div class="footer-menu">
                     <a class="footer-link" href="{{ route('pricing-index') }}">{{ __('Pricing') }}</a>
                     @if (Route::has('discover-index'))
                     <a class="footer-link" href="{{ route('discover-index') }}">{{ __('Discover') }}</a>
                     @endif
                  </div>
               </div>
            </div>
            @if (!\App\Models\Blog::where('status', 1)->orderBy('total_views', 'DESC')->limit(2)->get()->isEmpty())
            <div class="footer-group hidden">
               <div class="footer-head">{{ __('Blog') }}
                  <svg class="icon icon-arrow-bottom">
                     <use xlink:href="{{ gs('assets/image/svg/sprite.svg#icon-arrow-bottom') }}"></use>
                  </svg>
               </div>
               <div class="footer-body">
                  <div class="footer-menu">
                     @foreach (\App\Models\Blog::where('status', 1)->orderBy('total_views', 'DESC')->limit(2)->get() as $item)
                     @php
                     $thislocation = $item->type == 'internal' ? route('index-blog-single', $item->location) : $item->location;
                     $thistarget = $item->type == 'internal' ? '_self' : '_blank';
                     @endphp
                     <a class="footer-link" href="{{ $thislocation }}" target="{{ $thistarget }}">{{ $item->name }}</a>
                     @endforeach
                  </div>
               </div>
            </div>
            @endif
         </div>
         <div class="footer-col">
            <div class="footer-category mb-5 text-xs font-bold uppercase">{{ __('Join us today! 🔥') }}</div>
            <form method="GET" action="{{ route('user-register') }}" class="subscription-btn-wrapper">
               <input class="subscription-input" type="email" name="email" placeholder="Enter your email" required="">
               <button class="subscription-btn">
               <i class="sni sni-arrow-right"></i>
               </button>
            </form>
         </div>
      </div>
      <div class="footer-foot">
         <div class="footer-copyright flex items-center">{!! __t('Copyright © :date :website. All rights reserved.', ['date' => date('Y'), 'website' => config('app.name')]) !!}</div>
         <div class="footer-note flex items-center mt-7 md:mt-0">
            @if (!\App\Models\Page::where('status', 1)->
            whereIn('location', ['politica-de-privacidade', 'termos-de-uso', 'politica-de-cookies'])
            ->orderBy('total_views', 'DESC')->get()->isEmpty())
            <div class="footer-terms mr-7">
               <ul class="pricing-lists md:flex justify-center text-center">
               @foreach (\App\Models\Page::where('status', 1)->
               whereIn('location', ['politica-de-privacidade', 'termos-de-uso', 'politica-de-cookies'])
               ->orderBy('total_views', 'DESC')->get() as $item)
                  @php
                     $thislocation = $item->type == 'internal' ? route('index-page-single', $item->location) : $item->location;
                     $thistarget = $item->type == 'internal' ? '_self' : '_blank';
                  @endphp
                  <li><a class="footer-link" href="{{ $thislocation }}" target="{{ $thistarget }}">{{ $item->name }}</a></li>
               @endforeach
               </ul>
            </div>
            @endif
         </div>
         <div class="footer-note flex items-center mt-7 md:mt-0">
            <div class="context-social">
               <div class="social-links">
                  @foreach (socials() as $key => $items)
                  @if (!empty(settings("social.$key")))
                  <a class="social-link is-index" target="_blank" href="{{ settings("social.$key") }}">
                     <i class="{{ ao($items, 'icon') }}"></i>
                     {{ ao($items, 'svg') }}
                  </a>
                  @endif
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</footer>