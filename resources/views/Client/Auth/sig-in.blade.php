@extends('Client.Layouts.index')

@section('content')

<div class="container-fluid">

    <div class="offset-md-4 col-md-4 offset-sm-3 col-sm-6">
        <div class="form-container">
            <h3 class="title">Вход в Аккаунт</h3>
            <span class="server-message"></span>
            <form class="form-horizontal">
                <div class="error-message email"></div>
                <div class="form-group">
                    <input type="email" class="form-control" id="InputEmail" placeholder="Почта">
                </div>
                <div class="error-message password"></div>
                <div class="form-group">
                    <input type="password" class="form-control" id="InputPass" placeholder="Пароль">
                </div>
                <div class="btn signup">Вход</div>
                <a class="btn signin" href="{{ route("get.sig-up") }}">Регистрация</a>
            </form>
        </div>
    </div>

</div>

    <script>
        $(function ()
        {
            $('.signup').bind('click', function (e)
            {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('post.sig-in.check') }}',
                    type: "POST",
                    data: {
                        email: $('#InputEmail').val(),
                        password: $('#InputPass').val()
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
                            location = result['success']
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var errors = jqXHR.responseJSON.errors;
                        clearError()

                        if (errors['email']) {
                            $('#InputEmail').css('border', '1px solid red')
                            $('.error-message.email').text(errors['email'])
                        }
                        if (errors['password']) {
                            $('#InputPass').css('border', '1px solid red')
                            $('.error-message.password').text(errors['password'])
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
                $('#InputEmail').css('border', 'none')
                $('#InputPass').css('border', 'none')
            }
        })
    </script>
@endsection
