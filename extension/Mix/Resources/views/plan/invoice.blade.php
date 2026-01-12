<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>{{ __('Invoice') }}</title>
      <!-- Styles -->
      <link href="{{ gs('assets/icons/icons.bundle.css') }}" rel="stylesheet">
      <!-- tailwind -->
      <link href="{{ gs('assets/css/tailwind.min.css') }}" rel="stylesheet">
      <link href="{{ gs('assets/css/app.css') }}" rel="stylesheet">
      {!! \SandyCaptcha::head() !!}
   </head>
   <body>
      <div class="invoice-wrapper mt-10 px-5">
         <div class="invoice-header px-3">
            <div class="left">
               <h3>{{ __('Invoice') }}</h3>
            </div>
            <div class="right">
               <div class="controls">
                  <a href="{{ route('user-mix-purchase-plan', $plan->id) }}" class="action">
                     <i class="sni sni-arrow-left-c text-lg"></i>
                  </a>
                  <a href="Javascript::void" class="action" onclick="window.print()">
                     <i class="sni sni-printer text-lg"></i>
                  </a>
                  <a href="#" class="action html-to-canvas-download" data-html=".invoice-body" data-name="plan-invoice">
                     <i class="flaticon-download-1 text-lg"></i>
                  </a>
               </div>
            </div>
         </div>
         <div class="invoice-body card border-0">
            <div class="invoice-card">
               <div class="invoice-section is-flex is-bordered">
                  <div class="h-avatar is-large mb-5 sm:mb-0">
                     <img class="ob-cover" src="{{ logo('light') }}" alt=" " data-user-popover="6">
                  </div>
                  <div class="end">
                     <h3 class="mb-3">{{ __('New invoice') }}</h3>
                     <span>{{ __('Issued on') }}: {{ Carbon\Carbon::now()->toFormattedDateString() }}</span>
                     <span>{{ __('Issued by') }}: {{ $user->name }}</span>
                  </div>
               </div>
               <div class="meta mx-12 p-5 my-8 card-shadow rounded-2xl">
                  @foreach ($invoiceField as $key => $value)
                  <div class="flex justify-between">
                     <small class="text-sm">{{ ao($value, 'name') }}</small>
                     <small>{{ settings("invoice.$key") }}</small>
                  </div>
                  @endforeach
               </div>
               

               <div class="invoice-section is-flex is-bordered">
                  <div class="h-avatar mb-5 sm:mb-0">
                     <img class="object-cover h-full" src="{{ avatar() }}" alt=" ">
                  </div>
                  <div class="meta">
                     <small class="block">{{ __('Name') }} - {{ $user->name }}</small>
                     <small class="block">{{ __('Email') }} - {{ $user->email }}</small>
                  </div>
                  <div class="end is-left text-right">
                     <h3>{{ __('Status') }}</h3>
                     <p class="text-sm">{{ __('Unpaid') }}</p>
                     <form action="{{ route('user-mix-plan-payment-post', $plan->id) }}" method="post">
                        @csrf
                        <div class="my-5 flex justify-center">
                           {!! \SandyCaptcha::html() !!}
                        </div>
                        <input type="hidden" name="gateway" value="{{ $gateway }}">
                        <input type="hidden" name="duration" value="{{ $duration }}">
                        <button class="button sm no-shadow mt-4">{{ __('Pay now') }}</button>
                     </form>
                  </div>
               </div>
               <div class="invoice-section">
                  <div class="flex-table">
                     <!--Table header-->
                     <div class="flex-table-header">
                        <span>{{ __('Product') }}</span>
                        <span>{{ __('Quantity') }}</span>
                        <span>{{ __('Price') }}</span>
                        <span>{{ __('Duration') }}</span>
                        <span>{{ __('Total') }}</span>
                     </div>
                     <div class="flex-table-item">
                        <div class="flex-table-cell is-media" data-th="">
                           <div>
                              <span class="item-name dark-inverted fs-11px">{{ $plan->name }}</span>
                           </div>
                        </div>
                        <div class="flex-table-cell" data-th="{{ __('Quantity') }}">
                           <span class="light-text fs-11px">1</span>
                        </div>
                        <div class="flex-table-cell" data-th="{{ __('Price') }}">
                           <span class="tag fs-11px">{{ nr(ao($plan->price, "$duration")) }}</span>
                        </div>
                        <div class="flex-table-cell" data-th="{{ __('Gateway') }}">
                           <span class="tag fs-11px">{{ $gateway }}</span>
                        </div>
                        <div class="flex-table-cell" data-th="{{ __('Total') }}">
                           <span class="tag fs-11px">{{ nr(ao($plan->price, "$duration")) }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="flex-table sub-table">
                     <!--Table item-->
                     <div class="flex-table-item shadow-none">
                        <div class="flex-table-cell is-grow is-vhidden" data-th=""></div>
                        <div class="flex-table-cell cell-end is-vhidden" data-th=""></div>
                        <div class="flex-table-cell is-vhidden" data-th=""></div>
                        <div class="flex-table-cell" data-th="">
                           <span class="table-label">{{ __('Quantity') }}</span>
                        </div>
                        <div class="flex-table-cell has-text-right" data-th="">
                           <span class="table-total dark-inverted">1</span>
                        </div>
                     </div>
                     <!--Table item-->
                     <div class="flex-table-item shadow-none">
                        <div class="flex-table-cell is-grow is-vhidden" data-th=""></div>
                        <div class="flex-table-cell cell-end is-vhidden" data-th=""></div>
                        <div class="flex-table-cell is-vhidden" data-th=""></div>
                        <div class="flex-table-cell" data-th="">
                           <span class="table-label">{{ __('Subtotal') }}</span>
                        </div>
                        <div class="flex-table-cell has-text-right" data-th="">
                           <span class="table-total dark-inverted">{{ nr(ao($plan->price, "$duration")) }}</span>
                        </div>
                     </div>
                     <!--Table item-->
                     <div class="flex-table-item shadow-none">
                        <div class="flex-table-cell is-grow is-vhidden" data-th=""></div>
                        <div class="flex-table-cell cell-end is-vhidden" data-th=""></div>
                        <div class="flex-table-cell is-vhidden" data-th=""></div>
                        <div class="flex-table-cell" data-th="">
                           <span class="table-label">{{ __('Total') }}</span>
                        </div>
                        <div class="flex-table-cell has-text-right" data-th="">
                           <span class="table-total is-bigger dark-inverted">{!! price_with_cur(settings('payment.currency'), ao($plan->price, "$duration")) !!}</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      @include('include.mix-tag.mix-footer-tag')
   </body>
</html>