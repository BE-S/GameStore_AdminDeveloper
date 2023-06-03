@extends('Admin.Layouts.admin-panel', ['title' => 'Загрузка изображений'])

@section('content')

    @include('Admin.Layouts.input-cover')

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

        $('#send.cover').bind('click', function (e) {
            e.preventDefault();

            $(".not-exist").remove()

            var formData = new FormData($('#covers')[0])
            var gameId = {{ isset($uploadGame) ? $uploadGame->id : null }}
            formData.append('gameId', gameId)

            $.ajax({
                url: '{{ route('post.dashboard.upload.game.cover.loading') }}',
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result['Error']) {
                        alert(result['message'])
                    }
                    if (result['success']) {
                        location = '{{ route('get.dashboard.game', $uploadGame->id) }}'
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var errors = jqXHR.responseJSON.errors;

                    if (!errors) {
                        alert('Ошибка сервера');
                        return
                    }
                    if (typeof errors['small'] !== 'undefined') {
                        errorMessage('small', errors['small'])
                    }
                    if (typeof errors['store_header_image'] !== 'undefined') {
                        errorMessage('header', errors['store_header_image'])
                    }
                    if (typeof errors['poster'] !== 'undefined') {
                        errorMessage('poster', errors['poster'])
                    }
                    if (typeof errors['screen'] !== 'undefined') {
                        errorMessage('screen', errors['screen'])
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

        function errorMessage(nameCover, message)
        {
            $('#' + nameCover).find(".cover-load").remove()
            $('#' + nameCover).append('<div class="not-exist">' + message + '</div>')
        }
    });
</script>
@endsection
