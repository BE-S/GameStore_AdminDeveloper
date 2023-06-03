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
            <h3 class="title">Регистрация</h3>
            <span class="server-message"></span>
            <form class="form-horizontal">
                <div class="error-message name"></div>
                <div class="form-group">
                    <input type="name" class="form-control" id="InputName" placeholder="Имя">
                </div>
                <div class="error-message email"></div>
                <div class="form-group">
                    <input type="email" class="form-control" id="InputEmail" placeholder="Почта">
                </div>
                <div class="form-group">
                    <div class="error-message password"></div>
                    <input type="password" class="form-control" id="InputPass" placeholder="Пароль">
                </div>
                <div class="form-group">
                    <input id="chlen" type="checkbox" class="checkbox">
                    <span class="check-label">Нажимая вы соглашаетесь с <a href="">Политикой</a> <a href="">cайта.</a></span>
                </div>
                <div class="btn signup">Зарегистрироваться</div>
                <a class="btn signin" href="{{ route("get.sig-in") }}">Авторизация</a>
            </form>
        </div>
    </div>

</div>
    <script>
        $(function ()
        {
            $('.signup').bind('click', function (e)
            {
                var isChecked = $('#chlen').prop('checked');
                e.preventDefault();
                if (!isChecked) {
                    $('.server-message').css('color', 'red').text("Для регитсрации примите политику сайта!")
                }
                if (isChecked) {
                    $.ajax({
                        url: '{{ route('post.sig-up.check') }}',
                        type: "POST",
                        data: {
                            name: $('#InputName').val(),
                            email: $('#InputEmail').val(),
                            password: $('#InputPass').val(),
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            clearError()
                            console.log(result)
                            if (result['error']) {
                                $('.server-message').css('color', 'red').text(result['message'])
                            }
                            if (result['success']) {
                                $('.server-message').css('color', '#4E4C97').text(result['message'])
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            var errors = jqXHR.responseJSON.errors;
                            clearError()

                            console.log(errors)
                            if (errors === undefined) {
                                return;
                            }
                            if (errors['name']) {
                                $('#InputName').css('border', '1px solid red')
                                $('.error-message.name').text(errors['name'])
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
                }
            })

            function clearError()
            {
                $('.error-message.exist').text('')
                $('.error-message.name').text('')
                $('.error-message.email').text('')
                $('.error-message.password').text('')
                $('#InputName').css('border', 'none')
                $('#InputEmail').css('border', 'none')
                $('#InputPass').css('border', 'none')
            }
        })
    </script>
@endsection
