<div class="block-text background-color" id="review">
    <div class="main-inscription">Отзывы</div>

    @auth()
        <div class="container" id="create-review">
            <div class="review-content" style="padding: 0; display: flex; flex-direction: column;">
                <div style="flex-direction: row; align-items: flex-start;">
                    <div class="user-review">
                        <img src="{{'/storage/' . $account->avatar->path_small }}" alt="Avatar" style="width:90px">
                    </div>
                    <div class="review-text">
                        <textarea id="review-text" name="review" style="margin-bottom: 0; color: white" placeholder="Оставить отзыв"></textarea>
                        <div id="recommended">
                            <div>Рекомендуете игру?</div>
                            <input type="button" class="grade yes" value="Да">
                            <input type="button" class="grade no" value="Нет">
                        </div>
                        <div class="server-message"></div>
                    </div>
                </div>
                <div style="padding: 0; align-items: end;">
                    <div id="change-review">Назад</div>
                    <a id="review-publish" href="javascript:review({{$game->id}});">Опубликовать</a>
                </div>
            </div>
        </div>
    @endauth
    @foreach($reviews as $review)
        <div class="container">
            <div class="review-content read">
                <div class="user-review">
                    <img src="{{'/storage/' . $review->user->avatar->path_small }}" alt="Avatar" style="width:90px">
                </div>
                <div class="review-text">
                    <p><span>{{$review->user->name}} </span>{{ Carbon\Carbon::parse($review->created_at)->isoFormat('DD MMMM YYYY') }}</p>
                    <p>{{ $review->review }}</p>
                </div>
                <div class="grade {{ $review->grade ? 'yes' : 'no' }}">{{ $review->grade ? 'Рекомендую' : 'Не рекомендую' }}</div>
            </div>
            <div class="data-preview">
                <div class="emoji">emoji</div>
            </div>
        </div>
    @endforeach
</div>

<script>
    var gameId;

    $('.grade').bind('click', function (e) {
        var button = (this).value
        var grade = button == 'Да' ? true : false

        $.ajax({
            url: '{{ route('put.review') }}',
            type: "POST",
            data: {
                gameId: gameId,
                review: $('textarea[name="review"]').val(),
                grade: grade,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                console.log(result)
                if (result['success']) {
                    $('.server-message').css('display', 'flex')
                    $('.server-message').css('color', '#00de00')
                    $('#create-review .review-text').css('margin', '0')
                    $('#create-review .user-review').css('display', 'none')
                    $('#change-review').css('display', 'none')
                    $('#recommended').css('display', 'none')
                    $('.server-message').text(result['success']);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var errors = jqXHR.responseJSON.errors; // Ошибки в формате JSON

                if (!errors) {
                    $('.server-message').text('Ошибка сервера');
                    return;
                }
                offRecommended()
                $('.server-message').css('display', 'flex')
                if (errors['review']) {
                    $('.server-message').text(errors['review']);
                }
                if (errors['error']) {
                    $('.server-message').text('Ошибка сервера');
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

    function review(id) {
        gameId = id
        onRecommended()
    }
    $('#change-review').bind('click', function (e) {
        offRecommended()
    })

    function onRecommended()
    {
        $('#review-publish').css('display', 'none')
        $('#review-text').css('display', 'none')
        $('#recommended').css('display', 'flex')
        $('#change-review').css('display', 'flex')
        $('#create-review .review-text').css('padding-top', '0')
    }
    function offRecommended()
    {
        $('#review-publish').css('display', 'flex')
        $('#review-text').css('display', 'flex')
        $('#recommended').css('display', 'none')
        $('#change-review').css('display', 'none')
        $('#create-review .review-text').css('padding-top', '2em')
    }
</script>
