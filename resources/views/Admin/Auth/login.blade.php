@extends('Admin.Layouts.index')

@section('content')
    <div class='container w-28'>
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
        <button class="btn btn-primary mb-3" style="width: 100%" id="btn" data-page_tocken="{{ csrf_token() }}">Войти</button>
    </div>

    <script>
        $(function ()
        {
            $('#btn').bind('click', function (e)
            {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('post.admin.login.check') }}',
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
                        console.log("Success: ", result)
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
        })
    </script>
@endsection
