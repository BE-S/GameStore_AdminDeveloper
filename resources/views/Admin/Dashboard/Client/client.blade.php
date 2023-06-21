@extends('Admin.Layouts.admin-panel', ['title' => 'Клиент'])

@section('content')

    <div style="position:relative; display: flex; flex-direction: column">
        <div class="window-setting" id="user">
            <div class="info">
                <img src="{{ $client->avatar->path_small }}">
                <div class="name">{{ $client->name }}</div>
                <div class="date-reg">{{ $client->created_at }}</div>
            </div>
            <div class="data">
                <div>Ид: {{ $client->id }}</div>
                <div>Почта: {{ $client->email }}</div>
                <div>Варификация: {{ $client->email_verified_at ? 'Да' : 'Нет' }}</div>
                <div>Блокировка: <span class="info-ban">{{ isset($ban) ? 'Да' : 'Нет' }}</span></div>
            </div>
        </div>
        <div class="window-setting buttons">
            <div id="ban" class="btn btn-danger">{{ isset($ban) ? 'Разаблокировать' : 'Заблокировать' }}</div>
        </div>
        @isset($ban)
            <img class="image-ban active" src="/public/image/client/ban.png">
        @endisset
    </div>
    <div class="user-widgets">
        @include('Admin.Dashboard.Widgets.Small-box.order', compact('cart'))
    </div>

    <script>
        $('#ban').bind('click', function (e) {
            $.ajax({
                url: '{{ route("get.dashboard.ban") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    userId: {{ $client->id }}
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    console.log(result)
                    if (result['error']) {
                        console.log(123)
                    }
                    if (result['success']) {
                        let element = $('.image-ban')

                        if (element.length > 0) {
                            $('.content').find('#ban').text('Заблокировать')
                            $('.content').find('.info-ban').text(' ' + 'Нет')
                            element.remove()
                        } else {
                            $('#user.window-setting').append('<img class="image-ban" src="/public/image/client/ban.png">')
                            $('.content').find('#ban').text('Разаблокировать')
                            $('.content').find('.info-ban').text(' ' + 'Да')
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
    </script>

@endsection
