@extends('Admin.Layouts.admin-panel', ['title' => 'Издатели'])

@section('content')

    <div id="publisher" style="position:relative; display: flex; flex-direction: column">
        <div class="window-setting" id="user">
            <div class="info">
                <div class="publisher-avatar">
                    <div class="image">
                        <img id="avatar" src="{{ $publisher->avatar->path ?? 'default' }}">
                        <input type="file">
                    </div>
                </div>
                <div class="publisher-name">
                    <input class="ready-name" placeholder="Имя" value="{{ $publisher->name }}">
                </div>
                <div class="date-reg">{{ $publisher->created_at }}</div>
            </div>
        </div>
        <div class="window-setting buttons">
            <div id="change-publisher" class="btn btn-danger">Изменить</div>
            <div id="delete-publisher" class="btn btn-danger">Удалить издателя</div>
        </div>
    </div>
    <div class="alert change-message cover" role="alert"></div>

    <script>
        var image = $('.publisher-avatar')
        var fileInput = $('.publisher-avatar input')

        $(fileInput).change(function () {
            var img = new Image();
            img.src = URL.createObjectURL(fileInput[0].files[0]);
            img.onload = function () {
                var canvasCircle = document.createElement('canvas');

                let size = changeSize(img.width, img.height)
                canvasCircle.width = size['width'];
                canvasCircle.height = size['height'];
                var ctxTwo = canvasCircle.getContext('2d');
                ctxTwo.drawImage(img, 0, 0, canvasCircle.width, canvasCircle.height);
                $(image).find('img').attr('src', canvasCircle.toDataURL('image.png'))
                $(image).find('label').css('display', 'none')
                $(image).find('img').css('opacity', '1').css('display', 'block')
            };
        });

        function changeSize(width, height) {
            for (let i = 2; ; ++i) {
                if ((width / i) < 150 && (height / i) < 150) {
                    return {
                        'width': width / i,
                        'height': height / i
                    }
                }
            }
        }

        $('#change-publisher').bind('click', function (e) {
            $.ajax({
                url: '{{ route("post.dashboard.change.publisher") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    publisherId: {{ $publisher->id }},
                    image: $(image).find('#avatar').attr('src'),
                    name: $('.ready-name').val()
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result['error']) {
                        $('.change-message.cover').removeClass('alert-success').addClass('alert-danger').text('Ошибка')
                    }
                    if (result['success']) {
                        $('.change-message.cover').removeClass('alert-danger').addClass('alert-success').text('Данные изменены')
                    }
                    setTimeout(deleteMessage, 5000);
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

        function deleteMessage()
        {
            $('.change-message.cover').removeClass('alert-success').removeClass('alert-danger')
        }

        $('#delete-publisher').bind('click', function (e) {
            $.ajax({
                url: '{{ route("post.dashboard.delete.publisher") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    publisherId: {{ $publisher->id }}
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result['success']) {
                        location = '{{ route('get.dashboard.publishers') }}'
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
