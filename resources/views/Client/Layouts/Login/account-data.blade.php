<div id class="background block change">
    <div class="panel-account">
        <ul>
            <li class="select">Основное</li>
            <li>Почта</li>
            <li>Пароль</li>
        </ul>
    </div>
    <div class="block-settings">
    <div id="basic" class="active">
        <div>
            <div class="block-avatar">
                <div class="avatar square"><img id="square" class="image" src="{{ "/storage/" . $user->avatar->path_big }}" width="301px" height="301px"></div>
                <div class="avatar circle"><img id="circle" class="image circle-avatar" src="{{ "/storage/" . $account->avatar->path_small }}"></div>
                <div id="upload-content">
                    <input type="file" name="avatar" id="upload-account">
                    <div class="fake-input">Выбрать файл</div>
                </div>
            </div>
        </div>
        <div class="block-name">
            <label>Имя</label>
            <input name="name" value="{{ $user->name }}" placeholder="Имя">
        </div>
        <button id="change-basic">Изменить</button>
    </div>
    <div id="email">
        <div class="block-email">
            <label>Введите новую почта</label>
            <input name="email" placeholder="Почта">
        </div>
        <button id="change-email">Изменить</button>
    </div>
    <div id="password">
        <div class="block-password">
            <div class="old">
                <label>Введите старый пароль</label>
                <input type="password" name="password" placeholder="Старый пароль">
            </div>
            <div class="first-new">
                <label>Введите новый пароль</label>
                <input type="password" name="password" placeholder="Новый пароль">
            </div>
            <div class="first-new">
                <label>Повторите новый пароль</label>
                <input type="password" name="password" placeholder="Новый пароль">
            </div>
        </div>
        <button id="change-password">Изменить</button>
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

            canvasSquare.width = 301;
            canvasSquare.height = 301;
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
        $(this).addClass('select')

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
                console.log(result)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var errors = jqXHR.responseJSON.validationException

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
        console.log($('input[name="email"]').val())
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
                console.log(result)
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
        var pass = $('#pass').val()
        var newPass = $('#newPass').val()
        var repeatPass = $('#repeatPass').val()

        if (!pass) {
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
        }
    })
</script>
