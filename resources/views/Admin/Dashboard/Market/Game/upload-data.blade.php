@extends('Admin.Layouts.admin-panel')

@section('content')
    @include('Admin.Layouts.input-data')

    <script>
        $(function () {
            $('#game-info').bind('click', function (e) {
                e.preventDefault();

                const formDataMin = {}
                const formDataMax = {}

                $.ajax({
                    url: '{{ route("post.dashboard.upload.game.data.update.loading") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        name: $('input[name="name"]').val(),
                        price: $('input[name="price"]').val(),
                        description: $('textarea[name="description"]').val(),
                        min_settings: getArrayInput('min_settings', formDataMin),
                        max_settings: getArrayInput('max_settings', formDataMax),
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result['Error']) {
                            alert(result['message'])
                        }
                        location = result['href']
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var errors = jqXHR.responseJSON.errors; // Ошибки в формате JSON

                        if (errors) {
                            if (typeof errors['name'] !== 'undefined') {
                                $('.error-name').text(errors['name'])
                            }
                            if (typeof errors['price'] !== 'undefined') {
                                $('.error-price').text(errors['price'])
                            }
                            if (typeof errors['description'] !== 'undefined') {
                                $('.error-description').text(errors['description'])
                            }
                            if (typeof errors['min_settings[ОС]'] !== 'undefined') {
                                $('.error-min').text(errors['min_settings[ОС]'])
                            }
                            if (typeof errors['min_settings[Процессор]'] !== 'undefined') {
                                $('.error-min').text(errors['min_settings[Процессор]'])
                            }
                            if (typeof errors['min_settings[Видеокарта]'] !== 'undefined') {
                                $('.error-min').text(errors['min_settings[Видеокарта]'])
                            }
                            if (typeof errors['max_settings[ОС]'] !== 'undefined') {
                                $('.error-max').text(errors['max_settings[ОС]'])
                            }
                            if (typeof errors['max_settings[Процессор]'] !== 'undefined') {
                                $('.error-max').text(errors['min_settings[Процессор]'])
                            }
                            if (typeof errors['max_settings[Видеокарта]'] !== 'undefined') {
                                $('.error-max').text(errors['min_settings[Видеокарта]'])
                            }
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

            function getArrayInput(nameArr, formData)
            {
                const form = $('#data');
                const formArray = form.serializeArray();

                for (let i = 0, n = formArray.length; i < n; ++i) {
                    const name = formArray[i].name;
                    const value = formArray[i].value;

                    if (name.includes('[') && name.includes(']')) {
                        const [groupName, fieldName] = name.split(/\[|\]/);
                        if (groupName === nameArr) {
                            formData[fieldName] = value;
                        }
                    }
                }
                return formData
            }
        })
    </script>
@endsection
