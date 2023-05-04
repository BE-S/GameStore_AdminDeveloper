@extends('Admin.Layouts.index')

@section('content')

    <div class="window-setting">
        <img src="{{ '/storage/' . $game->gameCover->small }}">
        <div class="buttons">
            <div class="change-settings">
                <button type="button" id="description" class="btn btn-info">Изменить описание</button>
                <button type="button" id="screen" class="btn btn-info">Изменить скрины</button>
            </div>
            <button type="button" id="information" class="btn btn-primary">Информация</button>
            <button type="button" id="public" class="btn btn-success">{{ $game->is_published ? 'Снять с публикации' : 'Опубликовать' }}</button>
            <button type="button" id="delete" class="btn btn-danger">Удалить</button>
        </div>
    </div>
    <div class="window-content">
        <div class="change-data">
            @include('Admin.Layouts.input-data', $game)
            <div class="change-message data"></div>
        </div>
        <div class="change-cover">
            @include('Admin.Layouts.input-cover', $game)
            <div class="alert change-message cover" role="alert"></div>
        </div>
    </div>

    <script>
        $(function () {
            $('#description').bind('click', function (e) {
                if ($('.change-cover').css('display') !== 'none') {
                    $('.change-cover').toggle('active')
                }
                $('.change-data').toggle('active')
            })

            $('#screen').bind('click', function (e) {
                if ($('.change-data').css('display') !== 'none') {
                    $('.change-data').toggle('active')
                }
                $('.change-cover').toggle('active')
            })

            $('#game-info').bind('click', function (e) {
                e.preventDefault();
                const formDataMin = {};
                const formDataMax = {};

                $.ajax({
                    url: '{{ route("post.dashboard.upload.game.data.loading") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        gameId: {{ $game ? $game->id : null }},
                        name: $('input[name="name"]').val(),
                        price: $('input[name="price"]').val(),
                        description: $('textarea[name="description"]').val(),
                        min_settings: getArrayInput('min_settings', formDataMin),
                        max_settings: getArrayInput('max_settings', formDataMax),
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result['Error']) {
                            alert(result['message'])
                        }
                        if (result['updateData']) {
                            $('.change-message.data').text('Данные изменены')
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var errors = jqXHR.responseJSON.errors; // Ошибки в формате JSON

                        if (errors) {
                            if (typeof errors['name'] !== 'undefined') {
                                $('.error-name').text(errors['name'])
                            }
                            if (typeof errors['price'] !== 'undefined') {
                                $('.error-price').text(errors['price'])
                            }
                            if (typeof errors['description'] !== 'undefined') {
                                $('.error-description').text(errors['description'])
                            }
                            if (typeof errors['min_settings[ОС]'] !== 'undefined') {
                                $('.error-min').text(errors['min_settings[ОС]'])
                            }
                            if (typeof errors['min_settings[Процессор]'] !== 'undefined') {
                                $('.error-min').text(errors['min_settings[Процессор]'])
                            }
                            if (typeof errors['min_settings[Видеокарта]'] !== 'undefined') {
                                $('.error-min').text(errors['min_settings[Видеокарта]'])
                            }
                            if (typeof errors['max_settings[ОС]'] !== 'undefined') {
                                $('.error-max').text(errors['max_settings[ОС]'])
                            }
                            if (typeof errors['max_settings[Процессор]'] !== 'undefined') {
                                $('.error-max').text(errors['min_settings[Процессор]'])
                            }
                            if (typeof errors['max_settings[Видеокарта]'] !== 'undefined') {
                                $('.error-max').text(errors['min_settings[Видеокарта]'])
                            }
                        }
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

            function getArrayInput(nameArr, formData)
            {
                const form = $('#data');
                const formArray = form.serializeArray();

                for (let i = 0, n = formArray.length; i < n; ++i) {
                    const name = formArray[i].name;
                    const value = formArray[i].value;

                    if (name.includes('[') && name.includes(']')) {
                        const [groupName, fieldName] = name.split(/\[|\]/);
                        if (groupName === nameArr) {
                            formData[fieldName] = value;
                        }
                    }
                }
                return formData
            }
        })
    </script>

    <script>
        $(function () {
            $(".custom-file-input").change(function(e) {
                var label = $(this).next()

                if ($(this)[0].files[0]) {
                    $(label).text($(this)[0].files[0].name)
                } else {
                    $(label).text('Выбрать изображение')
                }
            });

            $('#game-cover').bind('click', function (e) {
                e.preventDefault();
                var formData = new FormData($('#covers')[0])
                var gameId = {{ $game ? $game->id : null }}
                formData.append('gameId', gameId)

                $.ajax({
                    url: '{{ route('post.dashboard.upload.game.cover.update.loading') }}',
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result['error']) {
                            $('.change-message.cover').removeClass('alert-success').addClass('alert-danger').text(result['error'])
                        }
                        if (result['success']) {
                            $('.change-message.cover').removeClass('alert-danger').addClass('alert-success').text('Данные изменены')
                        }
                        setTimeout(deleteMessage, 20000);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var errors = jqXHR.responseJSON.validationException;

                        if (errors === 'undefined') {
                            alert('Ошибка сервера!')
                        }

                        if (typeof errors['gameId'] !== 'undefined') {
                            console.log('11')
                        }
                        if (typeof errors['small'] !== 'undefined') {
                            console.log('12')
                        }
                        if (typeof errors['header'] !== 'undefined') {
                            console.log('13')
                        }
                        if (typeof errors['poster'] !== 'undefined') {
                            console.log('14')
                        }
                        if (typeof errors['screen'] !== 'undefined') {
                            console.log('15')
                        }
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
            });

            $('#public').bind('click', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('post.dashboard.publish') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        gameId: {{ $game ? $game->id : null }}
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result['publish']) {
                            $('#public').text('Снять с публикации')
                        } else {
                            $('#public').text('Опубликовать')
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var errors = jqXHR.responseJSON.errors;
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
            });

            $('#delete').bind('click', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('post.dashboard.delete') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        gameId: {{ $game ? $game->id : null }}
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result['success']) {
                            location = "{{ route('get.dashboard.games') }}"
                        }
                        if (result['error']) {
                            alert("Продукт не существует или уже был удалён")
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var errors = jqXHR.responseJSON.errors;
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
            });
        });

        function deleteMessage()
        {
            $('.change-message.cover').removeClass('alert-success')
        }
    </script>

@endsection
