@extends('Admin.Layouts.admin-panel', ['title' => 'Клиенты'])

@section('content')

    <table class="table table-hover">
        <thead>
        <tr>
            <th class="title" scope="col">Ид</th>
            <th class="title" scope="col">Имя</th>
            <th class="title" scope="col">Почта</th>
            <th class="title" scope="col">Телефон</th>
            <th class="title" scope="col">Варифицирован</th>
            <th class="title" scope="col">Блокировака</th>
            <th class="title" scope="col">Дата регистрации</th>
        </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
            <tr class="href-purchased" data-href="{{ route('get.dashboard.client', $client->id) }}">
                <th scope="row">{{ $client->id }}</th>
                <td>{{ $client->name }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone ?? 'Нет' }}</td>
                <td>{{ $client->email_verified_at ? 'Да' : 'Нет' }}</td>
                <td>{{ $client->ban ? 'Да' : 'Нет' }}</td>
                <td>{{ $client->created_at }}</td>
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
