@extends('Client.Layouts.index')

@section('content')
<div class='container w-50'>
    <div class="row mb-3">
        <div class="col-sm-10 w-100">
            <input type="name" class="form-control form-control-sm" id="InputName" placeholder="Имя">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-10 w-100">
            <input type="name" class="form-control form-control-sm" id="InputLastName" placeholder="Фамилия">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-10 w-100">
            <input type="email" class="form-control form-control-sm" id="InputEmail" placeholder="Почта">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-10 w-100">
            <input type="password" class="form-control form-control-sm" id="InputPass" placeholder="Пароль">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-10 w-100">
            <input type="password" class="form-control form-control-sm" id="InputPassRepeat" placeholder="Ещё раз пароль">
        </div>
    </div>
    <button class="btn btn-primary mb-3" style="width: 100%" id="btn" data-page_tocken="{{ csrf_token() }}">Войти</button>
</div>
    <script>
        $(function ()
        {
            $('#btn').bind('click', function (e)
            {
                    e.preventDefault();

                    $.ajax({
                        url: '{{ route('post.sig-up.check') }}',
                        type: "POST",
                        data: {
                            name: $('#InputName').val(),
                            last_name: $('#InputLastName').val(),
                            email: $('#InputEmail').val(),
                            password: $('#InputPass').val(),
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (responce) {
                            if (responce['result']) {
                                console.log('Для входа в аккаунт подтвердите его через почту')
                            } else {
                                console.log('Аккаунт с такой почтой существует')
                            }
                            console.log(responce['result'])
                        },
                        statusCode: {
                            401:function(err) {
                                console.log(err);
                            },
                            500:function(err) {
                                console.log(err);
                            }
                        }
                    })
            })
        })
    </script>
@endsection
