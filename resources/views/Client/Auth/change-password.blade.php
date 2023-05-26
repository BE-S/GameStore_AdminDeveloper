@extends('Client.Layouts.index')

@section('content')

    <style>
        .footer {
            position: absolute;
            bottom: 0;
        }
    </style>

    <div class='container w-28'>
        <div class="row mb-3">
                <div class="col-sm-10 w-100"><input type="password" class="form-control form-control-sm" id="InputPass" placeholder="Новый пароль"></div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-10 w-100">
                <input type="password" class="form-control form-control-sm" id="InputPassRepeat" placeholder="Ещё раз новый пароль">
            </div>
        </div>
        <button class="btn btn-primary mb-3" style="width: 100%" id="btn" data-page_tocken="{{ csrf_token() }}">Войти</button>
    </div>

    <script>
        $(function ()
        {
            var url = document.location.href

                $('#btn').bind('click', function (e) {
                    if ($('#InputPass').val() === $('#InputPassRepeat').val()) {
                        e.preventDefault();

                        $.ajax({
                            url: '{{ route('post.change-password') }}',
                            type: "POST",
                            data: {
                                password: $('#InputPass').val(),
                                job_hash: url.split('/').pop(),
                            },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (result) {
                                console.log("Success: ", result)
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
        })
    </script>
@endsection
