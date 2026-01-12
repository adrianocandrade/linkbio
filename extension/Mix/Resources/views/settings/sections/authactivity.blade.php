@extends('mix::layouts.master')
@section('title', __('Auth Activities'))
@section('namespace', 'user-mix-settings-authactivity')
@section('content')
<div class="mix-padding-10">
  <div class="card customize mb-10">
    <div class="card-header">
      <p class="title">{{ __('Auth Activities') }}</p>
      <p class="subtitle">{{ __('Track previous activities under your account.') }}</p>
    </div>
  </div>
  <div class="user-list" hidden>
    <div class="activity-reaction">
      <i class="la la-key"></i>
    </div>
    <p class="user-list-title">
      <a class="bold">A Successful Login</a> on a <a class="highlighted">Windows</a> os with <a class="highlighted">FireFox</a> browser on an 127.171.136 ip address
    </p>
    <p class="user-list-timestamp">3 minutes ago</p>
  </div>
  <div class="overflow-x-auto">
    
    @foreach ($activity as $name => $values)
    <div class="h6 mb-7">{{ __($name) }}</div>
    <table class="custom-table mb-10">
      <tbody>
        <tr>
          <th>{{ __('Date/Time') }}</th>
          <th>{{ __('Message') }}</th>
          <th>{{ __('Ip') }}</th>
          <th>{{ __('Os') }}</th>
          <th>{{ __('Browser') }}</th>
        </tr>
        @foreach ($values as $item)
        <tr>
          <td>{{ Carbon\Carbon::parse($item->created_at)->toDateString() }}</td>
          <td>{{ $item->message }}</td>
          <td>{{ $item->ip }}</td>
          <td>{{ $item->os }}</td>
          <td>{{ $item->browser }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endforeach
  </div>
</div>
@endsection