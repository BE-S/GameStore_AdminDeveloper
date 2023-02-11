@extends('Client.Layouts.index')

@section('content')
    <header>
        {{$user->name}}
        {{$user->last_name}}
    </header>
@endsection
