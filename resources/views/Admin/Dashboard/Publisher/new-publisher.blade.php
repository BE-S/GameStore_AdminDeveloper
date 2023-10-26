@extends('Admin.Layouts.admin-panel', ['title' => 'Издатели'])

@section('content')

    <div id="publisher" style="position:relative; display: flex; flex-direction: row; flex-wrap: wrap;">
        <div id="user" class="window-setting" style="padding-bottom: 1em; margin-right: 2em; margin-bottom: 1em">
            <div class="info">
                <div class="publisher-avatar">
                    <div class="label">
                        <h3>Лого</h3>
                    </div>
                    <div class="image">
                        <label>Загрузить изображение</label>
                        <input id="upload-avatar" type="file">
                        <img id="avatar" src="">
                    </div>
                </div>
                <div class="publisher-name">
                    <input placeholder="Имя">
                </div>
                <button class="btn btn-danger trash">
                    Удалить издателя
                </button>
            </div>
        </div>
        <div class="group-buttons">
            <div class="add-publisher">
                <div class="inscription">+</div>
            </div>
            <div class="permit-publisher">
                <div class="inscription">Добавить</div>
            </div>
        </div>
        <div class="alert change-message cover" role="alert"></div>
    </div>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.image', function () {
                var load = this
                var fileInput = $(load).find('input')
                //var fileInput = document.getElementById('upload-avatar');

                $(fileInput).change(function () {
                    var img = new Image();

                    img.src = URL.createObjectURL(fileInput[0].files[0]);

                    img.onload = function () {
                        var canvasCircle = document.createElement('canvas');

                        let size = changeSize(img.width, img.height)
                        canvasCircle.width = size['width'];
                        canvasCircle.height = size['height'];
                        var ctxTwo = canvasCircle.getContext('2d');
                        ctxTwo.drawImage(img, 0, 0, canvasCircle.width, canvasCircle.height);
                        $(load).find('img').attr('src', canvasCircle.toDataURL('image.png'))
                        $(load).find('label').css('display', 'none')
                        $(load).find('img').css('opacity', '1').css('display', 'block')
                    };
                });
            })

            $('.permit-publisher').on('click', function () {
                var blocks = $('#user .info')
                var array = []

                for (let block of blocks) {
                    array.push({
                        'img': $(block).find('img').attr('src'),
                        'name': $(block).find('.publisher-name input').val()
                    })
                }

                $.ajax({
                    url: '{{ route("post.dashboard.add.publisher") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        publisher: array
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result['error']) {
                            $('.change-message.cover').removeClass('alert-success').addClass('alert-danger').text('Введены не все данные')
                        }
                        if (result['success']) {
                            var element = $('.window-setting')

                            for (let i = 0; i < element.length; ++i) {
                                if (i > 0) {
                                    element[i].remove()
                                }
                                if (i == 0) {
                                    $(element[i]).find('label').css('display', 'block')
                                    $(element[i]).find('#avatar').css('opacity', '0').css('display', 'none')
                                    $(element[i]).find('.publisher-name input').val('')
                                }
                            }
                            $('.change-message.cover').removeClass('alert-danger').addClass('alert-success').text('Данные добавлены')
                        }
                        setTimeout(deleteMessage, 5000);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var errors = jqXHR.responseJSON.errors // Ошибки в формате JSON
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

            function deleteMessage()
            {
                $('.change-message.cover').removeClass('alert-success').removeClass('alert-danger')
            }

            function changeSize(width, height) {
                for (let i = 2; ; ++i) {
                    if ((width / i) < 150 && (height / i) < 150) {
                        return {
                            'width': width / i,
                            'height': height / i
                        }
                    }
                }
            }

            /*function handleFileSelect(e) {
                fileInput.removeEventListener('change', handleFileSelect); // удалить слушателя события change
                fileInput.value = ''; // очистить значение элемента input
                fileInput.addEventListener('change', handleFileSelect); // добавить слушателя события change
            }*/

            $('.add-publisher').on('click', function () {
                var blocks = $('.window-setting')

                if (blocks.length == 1) {
                    $(blocks[0]).find('.trash').removeClass('not-active')
                }
                var block = $('#user').clone()
                block.find('label').css('display', 'block')
                block.find('#avatar').css('opacity', '0').css('display', 'none')
                block.find('.publisher-name input').val('')
                $('.group-buttons').before(block)
            })

            $('.trash').addClass('not-active')

            $(document).on('click', '.trash', function () {
                var form = $(this).closest('#user')
                form.remove()

                var blocks = $('.window-setting')
                if (blocks.length == 1) {
                    $(blocks[0]).find('.trash').addClass('not-active')
                    return
                }
            })
        })
    </script>

@endsection
