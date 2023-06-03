@extends('Client.Layouts.index')

@section('content')

    <style>
        .footer {
            position: absolute;
            bottom: 0;
        }
    </style>

    <div class="container-fluid">
        <div class="offset-md-4 col-md-4 offset-sm-3 col-sm-6">
            <div class="form-container">
                <h3 class="title">Восстановление пароля</h3>
                <span class="server-message"></span>
                <form class="form-horizontal">
                    <div class="error-message email"></div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-sm" id="InputPass" placeholder="Новый пароль">
                    </div>
                    <div class="error-message password"></div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-sm" id="InputPassRepeat" placeholder="Повторите пароль">
                    </div>
                    <div class="btn change">Изменить пароль</div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(function ()
        {
            var url = document.location.href

                $('.btn.change').bind('click', function (e) {
                    console.log(1)
                    clearError()

                    if ($('#InputPass').val() === $('#InputPassRepeat').val()) {
                        e.preventDefault();

                        $.ajax({
                            url: '{{ route('post.change-password') }}',
                            type: "POST",
                            data: {
                                password: $('#InputPass').val(),
                                jobHash: url.split('/').pop(),
                            },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (result) {
                                if (result['error']) {
                                    $('.server-message').css('color', 'red').text(result['message'])
                                }
                                if (result['success']) {
                                    $('.server-message').css('color', 'black').text(result['message'])
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                var errors = jqXHR.responseJSON.errors;

                                if (!errors) {
                                    alert('Ошибка сервера')
                                    return;
                                }
                                if (errors['email']) {
                                    $('#InputEmail').css('border', '1px solid red')
                                    $('.error-message.email').text(errors['email'])
                                }
                                if (errors['password']) {
                                    $('#InputPass').css('border', '1px solid red')
                                    $('.error-message.password').text(errors['password'])
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
                    } else {
                        alert('Пароли не совпадают');
                    }
                })

            function clearError()
            {
                $('.server-message').text('')
                $('.error-message.email').text('')
                $('.error-message.password').text('')
                $('#InputEmail').css('border', 'none')
                $('#InputPass').css('border', 'none')
            }
        })
    </script>
@endsection
