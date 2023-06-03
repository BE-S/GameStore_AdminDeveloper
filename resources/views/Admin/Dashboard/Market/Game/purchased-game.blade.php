@extends('Admin.Layouts.admin-panel', ['title' => 'Покупка'])

@section('content')

    <div class="blocks">
        <div class="p-2 mb-2 bg-success text-white">
            <p>Ид покупки</p>
            <p>{{ $purchased->id }}</p>
        </div>
        <div class="p-2 mb-2 bg-primary text-white">
            <p>Ид пользователя</p>
            <p>{{ $purchased->user_id }}</p>
        </div>
        <div class="p-2 mb-2 bg-danger text-white">
            <p>Статус</p>
            <p>{{ $order->status }}</p>
        </div>
        <div class="p-2 mb-2 bg-warning text-white">
            <p>Ид заказа</p>
            <p>{{ $order->id }}</p>
        </div>
        <div class="p-2 mb-2 text-white" style="background: #A200CB">
            <p>Дата покупки</p>
            <p>{{ $purchased->created_at }}</p>
        </div>
    </div>

    <div style="display:flex; flex-direction: column; width: 100%; margin-right: 3em">
        <div class="applications">
            <p>Заявки</p>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Ид</th>
                    <th scope="col">Ид ключей</th>
                    <th scope="col">Админ</th>
                    <th scope="col">Пользователь</th>
                    <th scope="col">Покупка</th>
                    <th scope="col">Дата заявки</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Дата создания</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @isset($applicationReturns)
                    @foreach($applicationReturns as $applicationReturn)
                        <tr id="{{ $applicationReturn->id }}">
                            <td>{{ $applicationReturn->id }}</td>
                            <td>
                                @foreach($applicationReturn->key_id as $key => $keyId)
                                    {{ $keyId }}{{ $key == 0 ? ',' : '' }}
                                @endforeach
                            </td>
                            <td>{{ $applicationReturn->employee_id }}</td>
                            <td>{{ $applicationReturn->user_id }}</td>
                            <td>{{ $applicationReturn->purchase_id }}</td>
                            <td>{{ $applicationReturn->application_date }}</td>
                            <td class="status">{{ $applicationReturn->status }}</td>
                            <td>{{ $applicationReturn->created_at }}</td>
                            <td class="info-application">
                                @if ($applicationReturn->status != 'Отменён')
                                    <a href="javascript: cancelApplication({{ $applicationReturn->id }})" class="trash" style="background: red">
                                        <img src="/image/icon/trash.png" width="24px">
                                    </a>
                                @else
                                    <a href="javascript: activateApplication({{ $applicationReturn->id }})" class="reload" style="background: red">
                                        <img src="/image/icon/reload.png" width="24px">
                                    </a>
                               @endif
                            </td>
                        </tr>
                    @endforeach
                @endisset
                </tbody>
            </table>
            @if (!$applicationReturns)
                <div>Нет заявок</div>
            @endif
        </div>

        <div class="purchased">
            <div id="application-date">
                <label>Дата заявки</label>
                <input type="datetime" name="datetime" id="datetime" placeholder="0000-00-00 00:00">
            </div>
            @isset($applicationReturns)
                @foreach($games as $game)
                    <div class="product" id="{{ $game->id }}">
                        <img src="{{ "/storage/" . $game->gameCover->store_header_image }}">
                        <div class="info">Ид: {{ $game->id }}</div>
                        <div class="info">Стоимость: {{ $order->calculationDiscountPurchased($game->id) }}</div>
                        <div class="info">Скидка: {{ $order->getDiscountFromOrder($game->id) }}%</div>
                        <div class="info key" id="{{ $purchased->getKeyFromPurchased($game->id) }}">Ид ключа: {{ $purchased->getKeyFromPurchased($game->id) }}</div>
                        @if ($purchased->applicationReturn)
                            @foreach($purchased->applicationReturn->findtValueStatus() as $applicationReturn)
                                    @if (!$applicationReturn)
                                        <div class="mark-return">
                                            <input type="checkbox" class="mark">
                                        </div>
                                    @else
                                        @if ($applicationReturn->status == "Ожидание")
                                            <div class="info-application">
                                                <div class="p-3 mb-2 bg-info text-white">В заявке</div>
                                            </div>
                                        @elseif ($applicationReturn->status == "Выполнено")
                                            <div class="info-application">
                                                <div class="p-3 mb-2 bg-info text-white">Возвращёно</div>
                                            </div>
                                        @endif
                                    @endif
                            @endforeach
                        @else
                            <div class="mark-return">
                                <input type="checkbox" class="mark">
                            </div>
                        @endif
                    </div>
                @endforeach
            @endisset
            <div style="display: flex; justify-content: end; width: 68.5em">
                <div style="display: flex" class="back btn btn-danger">Назад</div>
                <div style="display: flex" class="return btn btn-danger">Создать заявку</div>
            </div>
        </div>
        <div style="display: flex; justify-content: end; margin-right: 3em;">
            <div class="new btn btn-danger">Новая заявка</div>
        </div>
    </div>
    <div class="alert change-message application" role="alert">ауцауцаац</div>

    <script>
        $('#datetime').mask('9999-99-99 99:99')

        $('.new.btn').bind('click', function (e) {
            activeBlock()
        })

        $('.back.btn').bind('click', function (e) {
            activeBlock()
        })

        function activeBlock()
        {
            $('.purchased').toggle('active')
            $('.new.btn').toggle('active')
            $('.table-hover').toggle('active')
            $('.applications p').toggle('active')
        }

        $('.return.btn').bind('click', function (e) {
            e.preventDefault();

            var elements = $('.product')
            var returnKey = []
            for (let element of elements) {
                if ($(element).find('.mark').prop('checked') == true) {
                    returnKey.push($(element).find('.info.key').attr('id'))
                }
            }

            $.ajax({
                url: '{{ route("post.dashboard.purchase.create.application") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    purchaseId: {{ $purchased->id }},
                    applicationDate: $('#datetime').val(),
                    returnKey: returnKey
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    console.log(result)
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

        function cancelApplication(id)
        {
            $.ajax({
                url: '{{ route("post.dashboard.purchase.delete.application") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    applicationId: id,
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result['error']) {
                        $('.change-message.application').removeClass('alert-success').addClass('alert-danger').text('Заяка уже отменена')
                    }
                    if (result['success']) {
                        var element = $('#' + id)
                        element.find('.trash img').attr('src', '/image/icon/reload.png')
                        element.find('.trash').attr('class', 'reload').attr('href', 'javascript: activateApplication(' + id +')')
                        element.find('.status').text('Отменён')
                        $('.change-message.application').removeClass('alert-danger').addClass('alert-success').text('Заявка отменена')
                    }
                    setTimeout(deleteMessage, 20000);
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
        }

        function activateApplication(id)
        {
            $.ajax({
                url: '{{ route("post.dashboard.purchase.activate.application") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    applicationId: id,
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    console.log(result)
                    if (result['error']) {
                        $('.change-message.application').removeClass('alert-success').addClass('alert-danger').text('Заявка уже активирована')
                    }
                    if (result['success']) {
                        var element = $('#' + id)
                        console.log(element.find('.status'))
                        element.find('.status').text('Ожидание')
                        element.find('.reload img').attr('src', '/image/icon/trash.png')
                        element.find('.reload').attr('class', 'trash').attr('href', 'javascript: cancelApplication(' + id +')')
                        $('.change-message.application').removeClass('alert-danger').addClass('alert-success').text('Заявка активирована')
                    }
                    setTimeout(deleteMessage, 20000);
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
        }

        function deleteMessage()
        {
            $('.change-message.cover').removeClass('alert-success')
        }
    </script>
@endsection
