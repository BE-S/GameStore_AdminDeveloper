@extends('Admin.Layouts.admin-panel', ['title' => 'Админы'])

@section('content')

    <table class="table table-hover">
        <thead>
        <tr>
            <th class="title" scope="col">Ид</th>
            <th class="title" scope="col">Имя</th>
            <th class="title" scope="col">Почта</th>
            <th class="title" scope="col">Телефон</th>
            <th class="title" scope="col">Роль</th>
            <th class="title" scope="col">Варифицирован</th>
            <th class="title" scope="col">Блокировака</th>
            <th class="title" scope="col">Дата регистрации</th>
        </tr>
        </thead>
        <tbody>
        @foreach($employees as $employee)
            <tr class="href-purchased" data-href="{{ route('get.dashboard.employee', $employee->id) }}">
                <th scope="row">{{ $employee->user->id }}</th>
                <td>{{ $employee->user->name }}</td>
                <td>{{ $employee->user->email }}</td>
                <td>{{ $employee->user->phone ?? 'Нет' }}</td>
                <td>{{ $employee->deleted_at ? "Снят" : $employee->role->name }}</td>
                <td>{{ $employee->user->email_verified_at ? 'Да' : 'Нет' }}</td>
                <td>{{ $employee->user->ban ? 'Да' : 'Нет' }}</td>
                <td>{{ $employee->user->created_at }}</td>
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
