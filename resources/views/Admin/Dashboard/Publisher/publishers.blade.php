@extends('Admin.Layouts.admin-panel', ['title' => 'Издатели'])

@section('content')

    <table class="table table-hover">
        <thead>
        <tr>
            <th class="title" scope="col">Логотип</th>
            <th class="title" scope="col">Ид</th>
            <th class="title" scope="col">Имя</th>
            <th class="title" scope="col">Дата регистрации</th>
        </tr>
        </thead>
        <tbody>
        @foreach($publishers as $publisher)
            <tr class="href-purchased" data-href="{{ route('get.dashboard.publisher', $publisher->id) }}">
                <td><img src="{{ $publisher->avatar->path ?? 'default' }}"></td>
                <th scope="row">{{ $publisher->id }}</th>
                <td>{{ $publisher->name }}</td>
                <td>{{ $publisher->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <script>
        jQuery(document).ready(function($) {
            $(".href-purchased").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>

@endsection
