@extends('Admin.Layouts.admin-panel', ['title' => 'Администратор'])

@section('content')

    <div style="position:relative; display: flex; flex-direction: column">
        <div class="window-setting" id="user">
            <div class="info">
                <img src="{{ $user->avatar->path_small }}">
                <div class="name">{{ $user->name }}</div>
                <div class="date-reg">{{ $user->created_at }}</div>
            </div>
            <div class="data">
                @if ($employee->deleted_at)
                    <div>Снят с админа</div>
                @endif
                <div>Ид: {{ $user->id }}</div>
                <div>Почта: {{ $user->email }}</div>
                <div>Варификация: {{ $user->email_verified_at ? 'Да' : 'Нет' }}</div>
                <div>Роль: <span class="role">{{ $employee->role->name }}</span></div>
                <div class="info-ban">Блокировка: {{ isset($ban) ? 'Да' : 'Нет' }}</div>
            </div>
        </div>
        <div class="window-setting buttons">
            @if (auth()->user()->id != $user->id)
                    <div id="ban" class="btn btn-danger">{{ isset($ban) ? 'Разаблокировать' : 'Заблокировать' }}</div>
                    <div id="delete-admin" class="btn btn-danger">Снять админа</div>
            @endif
        </div>
        @isset($ban)
            <img class="image-ban active" src="/image/client/ban.png">
        @endisset
    </div>

    <script>
        $('#ban').bind('click', function (e) {
            $.ajax({
                url: '{{ route("get.dashboard.ban") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    userId: {{ $user->id }}
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result['error']) {
                        console.log(123)
                    }
                    if (result['success']) {
                        let element = $('.image-ban')
                        if (element.length > 0) {
                            $('.content').find('#ban').text('Заблокировать')
                            $('.content').find('.info-ban').text('Нет')
                            element.remove()
                        } else {
                            $('#user.window-setting').append('<img class="image-ban" src="/image/client/ban.png">')
                            $('.content').find('#ban').text('Разаблокировать')
                            $('.content').find('.info-ban').text('Да')
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var errors = jqXHR.responseJSON.errors; // Ошибки в формате JSON
                },
                statusCode: {
                    401: function (err) {
                        console.log(err);
                    },
                    500: function (err) {
                        console.log(err);
                    }
                }
            })
        })

        $('#delete-admin').bind('click', function (e) {
            $.ajax({
                url: '{{ route("get.dashboard.delete.employee") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    userId: {{ $user->id }}
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    console.log(result)
                    if (result['error']) {
                        console.log(result)
                    }
                    if (result['success']) {
                        $('.content').find('.role').text(' ' + 'Снят с администратора')
                        $('.content').find('#delete-admin').attr('id', 'static')
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var errors = jqXHR.responseJSON.errors; // Ошибки в формате JSON
                },
                statusCode: {
                    401: function (err) {
                        console.log(err);
                    },
                    500: function (err) {
                        console.log(err);
                    }
                }
            })
        })
    </script>

@endsection
