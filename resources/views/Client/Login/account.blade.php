@extends('Client.Layouts.index')

@section('content')
    <header>
        {{$user->name}}
        {{$user->last_name}}
        {{$user->email}}
    </header>
@endsection
