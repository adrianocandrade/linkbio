@extends('mix::layouts.master')
@section('title', __('Booking Calendar'))
@section('content')



<livewire:booking-block-mix-calendar-livewire :user_id="$user->id" :workspace_id="session('active_workspace_id')" :wire:key="'calendar-' . $user->id . '-' . (session('active_workspace_id') ?? 'default')"/>

@endsection