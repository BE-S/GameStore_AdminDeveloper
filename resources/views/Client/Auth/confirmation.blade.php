@extends('Client.Layouts.index')

@section('content')

    <style>
        .footer {
            position: absolute;
            bottom: 0;
        }
    </style>

    <div class='container w-50 verification'>
        <div>{{ $message }}</div>
    </div>
@endsection
