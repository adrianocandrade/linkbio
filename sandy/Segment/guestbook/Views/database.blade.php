@extends('mix::layouts.master')
@section('content')
@section('head')
    <style>
        .list-items{
            background: #fad063;
            color: #fff;
            min-height: 269px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            word-break: break-word;
            padding: 10px 25px;
            border-radius: 10px;
            text-align: center;
        }

        .list-items:not(:last-child){
            margin-bottom: 15px;
        }
    </style>
@stop
<div>
    <div class="p-10">
        @if (!$db->isEmpty())
            @foreach ($db as $item)
                @php
                $database = $item->database;
                @endphp
                <div class="list-items p-10" style="background: {{ ao($database, 'color') }}">
                    {{ ao($database, 'content') }}
                </div>
            @endforeach
        @else
        @include('include.is-empty')
        @endif
    </div>
</div>
@endsection