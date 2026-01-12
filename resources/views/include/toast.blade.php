<div>
  @if ($message = Session::get('error'))
  <div class="sandy-fixed-toast hide">
    <div class="toast-inner bg-red-500 text-white">
      {{ $message }}
    </div>
  </div>
  @endif
  
  @if ($message = Session::get('success'))
  <div class="sandy-fixed-toast success hide">
    <div class="toast-inner">
      {{ $message }}
    </div>
  </div>
  @endif
  @if ($message = Session::get('info'))
  <div class="sandy-fixed-toast hide">
    <div class="toast-inner bg-yellow-200">
      {{ $message }}
    </div>
  </div>
  @endif
  
  @if(!$errors->isEmpty())
  @foreach ($errors->all() as $error)
  <div class="sandy-fixed-toast hide">
    <div class="toast-inner bg-red-500 text-white">
      {{ $error }}
    </div>
  </div>
  @endforeach
  @endif
</div>
<!-- End. Toasts -->