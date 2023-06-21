@extends('Client.Layouts.index')

@section('content')

    <style>
        .footer {
            position: absolute;
            bottom: 0;
        }
		
		@media (max-width: 828px) {
			.footer {
				position: relative;
				margin-top: 3em;
			}
		}
    </style>

<div class="container-fluid">
    <div class="offset-md-4 col-md-4 offset-sm-3 col-sm-6">
        <div class="form-container">
            <h3 class="title">Восстановить пароль</h3>
            <span class="server-message"></span>
            <form class="form-horizontal">
                <div class="error-message email"></div>
                <div class="form-group">
                    <input type="email" class="form-control" id="InputEmail" placeholder="Почта">
                </div>
                <div style="text-transform: none" class="btn restore">Восстановить пароль</div>
                <a class="btn signup" href="{{ route("get.sig-up") }}">Авторизация</a>
            </form>
        </div>
    </div>
</div>

    <script>
        $(function ()
        {
            $('.btn.restore').bind('click', function (e)
            {
				$('.server-message').text('')
                e.preventDefault();

                $.ajax({
                    url: '{{ route('post.recovery-login') }}',
                    type: "POST",
                    data: {
                        email: $('#InputEmail').val(),
                        pathname: document.location.pathname,
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
