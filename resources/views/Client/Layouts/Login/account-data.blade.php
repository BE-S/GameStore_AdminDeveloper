<div id class="background block change" style="display: none">
    <div class="panel-account">
        <ul>
            <li id="begin" class="select">Основное</li>
            <li>Почта</li>
            <li>Пароль</li>
            <li class="to-account">В профиль</li>
        </ul>
    </div>
    <div class="block-settings">
    <div id="basic">
        <div>
            <div class="block-avatar">
                <div class="avatar square"><img id="square" class="image" src="{{ $user->avatar->path_big }}" width="301px" height="301px"></div>
                <div class="avatar circle"><img id="circle" class="image circle-avatar" src="{{ $account->avatar->path_small }}"></div>
                <div id="upload-content">
                    <input type="file" name="avatar" id="upload-account">
                    <div class="fake-input">Выбрать файл</div>
                </div>
            </div>
        </div>
        <div class="block-name">
            <label>Имя</label>
            <input name="name" placeholder="Новое имя">
        </div>
        <div style="display: flex">
            <button id="change-basic">Изменить</button>
            <div class="server-message"></div>
        </div>
    </div>
    <div id="email">
        <div class="block-email">
			<label>Введите новую почта</label>
			<input name="email" placeholder="Почта">
		</div>
		<div style="display: flex;">
			<button id="change-email">Изменить</button>
			<div class="server-message"></div>
		</div>
    </div>
	<div id="password">
        <div class="block-password">
            <div class="old">
                <label>Введите старый пароль</label>
                <input type="password" id="pass" placeholder="Старый пароль">
            </div>
            <div class="new">
                <label>Введите новый пароль</label>
                <input type="password" id="newPass" placeholder="Новый пароль">
            </div>
            <div class="new">
                <label>Повторите новый пароль</label>
                <input type="password" id="repeatPass" placeholder="Новый пароль">
            </div>
        </div>
        <div style="display: flex">
            <button id="change-password">Изменить</button>
            <div class="server-message"></div>
        </div>
    </div>
    </div>
    </div>
</div>

<script>
    const fileInput = document.getElementById('upload-account');
    const imagePreview = document.getElementById('square');
    const imagePreviewTwo = document.getElementById('circle');
    var uploadSquare
    var uploadCircle
    var changeImage = false

    fileInput.addEventListener('change', (event) => {
        var img = new Image();
        img.src = URL.createObjectURL(fileInput.files[0]);

        img.onload = function() {
            var canvasSquare = document.createElement('canvas');
            var canvasCircle = document.createElement('canvas');

            canvasSquare.width = 500;
            canvasSquare.height = 500;
            var ctxOne = canvasSquare.getContext('2d');
            ctxOne.drawImage(img, 0, 0, canvasSquare.width, canvasSquare.height);
            uploadSquare = canvasSquare.toDataURL('image.png');
            imagePreview.src = uploadSquare

            canvasCircle.width = 135;
            canvasCircle.height = 135;
            var ctxTwo = canvasCircle.getContext('2d');
            ctxTwo.drawImage(img, 0, 0, canvasCircle.width, canvasCircle.height);
            uploadCircle = canvasCircle.toDataURL('image.png');
            imagePreviewTwo.src = uploadCircle
        };
        handleFileSelect(event)
    });

    function handleFileSelect(e) {
        fileInput.removeEventListener('change', handleFileSelect); // удалить слушателя события change
        fileInput.value = ''; // очистить значение элемента input
        fileInput.addEventListener('change', handleFileSelect); // добавить слушателя события change
    }

    $('.panel-account li').on('click', function() {
        $('.panel-account .select').attr('class', '')
        $('div .active').attr('class', '')

        if ($(this).text() == 'В профиль') {
            $('#begin').addClass('select')
        }

        if ($(this).text() == 'Основное') {
            $('#basic').attr('class', 'active')
        }
        if ($(this).text() == 'Почта') {
            $('#email').attr('class', 'active')
        }
        if ($(this).text() == 'Пароль') {
            $('#password').attr('class', 'active')
        }
    });
</script>
<script>
    $('#change-basic').bind('click', function (e) {
        var name = $('input[name="name"]').val()
		$('#basic .server-message').text('')
		
        $.ajax({
            url: '{{ route('post.change.avatar') }}',
            type: "POST",
            data: {
                uploadSquare: uploadSquare,
                uploadCircle: uploadCircle,
                name: name
            },
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                if (result['error']) {
                    $('#basic .server-message').css('color', 'red').text(result['message'])
                }
                if (result['success']) {
                    $('#basic .server-message').css('color', 'lime').text('Данные изменёны')
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var errors = jqXHR.responseJSON.errors
				console.log(errors)
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
    })
    $('#change-email').bind('click', function (e) {
		$('#email .server-message').text('')
        $.ajax({
            url: "{{ route('post.change.email') }}",
            type: "POST",
            data: {
                email: $('input[name="email"]').val()
            },
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                if (result['error']) {
                    $('#email .server-message').css('color', 'red').text(result['message'])
                }
                if (result['success']) {
                    $('#email .server-message').css('color', 'lime').text('Ссылка для смены пароля отправлена на указанную почту')
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
    })
    $('#change-password').bind('click', function (e) {
		$('#password .server-message').text('')
		
        var pass = $('#pass').val()
        var newPass = $('#newPass').val()
        var repeatPass = $('#repeatPass').val()

        if (!pass || !newPass || !repeatPass) {
            $('#password .server-message').css('color', 'red').text('Ввдите пароль')
			return
        }

        if (newPass == repeatPass) {
            $.ajax({
                url: '{{ route('post.change.password') }}',
                type: "POST",
                data: {
                    oldPass: pass,
                    newPass: newPass,
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
					console.log(result)
					if (result['error']) {
                        $('#password .server-message').css('color', 'red').text('Введён не правильный пароль')
                    }
                    if (result['success']) {
                        $('#password .server-message').css('color', 'lime').text('Пароль изменён')
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
			$('#password .server-message').css('color', 'red').text('Пароли не совпадают')
		}
    })

    $('.to-account').bind('click', function (e) {
        $('.background.account').toggle('active')
        $('.background.change').toggle('active')
        $('.footer').attr('class', 'footer')
    })
</script>
