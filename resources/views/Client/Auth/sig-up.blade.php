@extends('Client.Layouts.index')

@section('content')
{{--<div class='container w-50'>--}}
{{--    <div class="row mb-3">--}}
{{--        <div class="col-sm-10 w-100">--}}
{{--            <input type="name" class="form-control form-control-sm" id="InputName" placeholder="Имя">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row mb-3">--}}
{{--        <div class="col-sm-10 w-100">--}}
{{--            <input type="email" class="form-control form-control-sm" id="InputEmail" placeholder="Почта">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row mb-3">--}}
{{--        <div class="col-sm-10 w-100">--}}
{{--            <input type="password" class="form-control form-control-sm" id="InputPass" placeholder="Пароль">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row mb-3">--}}
{{--        <div class="col-sm-10 w-100">--}}
{{--            <input type="password" class="form-control form-control-sm" id="InputPassRepeat" placeholder="Ещё раз пароль">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <button class="btn btn-primary mb-3" style="width: 100%" id="btn" data-page_tocken="{{ csrf_token() }}">Войти</button>--}}
{{--</div>--}}

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
                    <input type="checkbox" class="checkbox">
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
            var isChecked = $('.checkbox').prop('checked');

            $('.signup').bind('click', function (e)
            {
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
