@extends('Admin.Layouts.index')

@section('panel')

<div class="background-admin">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Вход в админ панель</p>
                <span class="server-message"></span>
                <form>
                    <div class="error-message email"></div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" id="InputEmail" placeholder="Почта">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="error-message password"></div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="InputPass" placeholder="Пароль">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Запомнить
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <div class="btn btn-primary btn-block">Вход</div>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</div>

    <script>
        $(function ()
        {
            $('.btn-primary').bind('click', function (e)
            {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('post.admin.login.check') }}',
                    type: "POST",
                    data: {
                        email: $('#InputEmail').val(),
                        password: $('#InputPass').val(),
                        remember: $('#remember').prop('checked'),
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
                            location = result['href']
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var errors = jqXHR.responseJSON.errors;
                        clearError()

                        if (result) {
                            alert('Ошибка сервера');
                            return;
                        }
                        if (errors['email']) {
                            $('#InputEmail').css('border', '1px solid red')
                            $('.error-message.email').css('color', 'red').text(errors['email'])
                        }
                        if (errors['password']) {
                            $('#InputPass').css('border', '1px solid red')
                            $('.error-message.password').css('color', 'red').text(errors['password'])
                        }
                    },
                    statusCode:{
                        401:function(err) {
                            console.log(err);
                        },
                        500:function(err) {
                            console.log(err);
                        }
                    }
                })
            })

            function clearError()
            {
                $('.server-message').text('')
                $('.error-message.email').text('')
                $('.error-message.password').text('')
                $('#InputEmail').css('border', '1px solid #ced4da')
                $('#InputPass').css('border', '1px solid #ced4da')
            }
        })
    </script>
@endsection
