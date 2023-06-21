<div class="block-text background-color" id="review">
    <div class="main-inscription">Отзывы</div>

    @auth()
        <div class="container" id="create-review">
            <div class="review-content" style="padding: 0; display: flex; flex-direction: column;">
                <div style="flex-direction: row; align-items: flex-start;">
                    <div class="user-review">
                        <img src="{{ $account->avatar->path_small }}" alt="Avatar" style="width:90px">
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
        <div class="container read" id="{{ $review->id }}">
            <div class="review-content read">
                <div class="user-review">
                    <img src="{{$review->user->avatar->path_small }}" alt="Avatar" style="width:90px">
                </div>
                <div class="review-text">
                    <p><span>{{$review->user->name}} </span>{{ Carbon\Carbon::parse($review->created_at)->isoFormat('DD MMMM YYYY') }}</p>
                    <p>{{ $review->review }}</p>
                </div>
                <div class="grade {{ $review->grade ? 'yes' : 'no' }}">{{ $review->grade ? 'Рекомендую' : 'Не рекомендую' }}</div>
            </div>
            <div class="data-preview">
                <div class="container-emoji">
                    <div class="review-emoji">
                        @include('Client.Widgets.Game.reviewEmoji', compact('review'))
                    </div>
                </div>
                @auth
                    <div class="menu-emoji">
                        <img class="menu" src="/image/icon/points menu.png">
                        <div class="emoji-list">
                            <div class="window">
                                @foreach($emojiAll as $emoji)
                                    <a href="javascript:putReview({{ $review->id }}, {{ $emoji->id }});" class="background-emoji">
                                        <img src="{{ $emoji->path }}">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endauth
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
            url: '{{ route('post.review') }}',
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

    function putReview(reviewId, emojiId)
    {
        $.ajax({
            url: '{{ route('post.emoji') }}',
            type: "POST",
            data: {
                reviewId: reviewId,
                emojiId: emojiId,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                var element = $('#' + reviewId).find('.block-emoji.' + emojiId)

                if (result['success']) {
                    if (element.length) {
                        if (result['num'] > 0) {
                            element.find('p').text(result['num'])
                        } else {
                            element.remove()
                        }
                    } else {
                        console.log(result)
                        var a = $('<a class="block-emoji ' + emojiId + '" href="javascript:putReview(' + reviewId + ', ' + emojiId + ')"> <img src="' + result['path'] + '"> <p class="count-emoji">' + result['num'] + '</p> </a>');
                        $('#' + reviewId).find('.review-emoji').append(a)
                        if (result['previous']) {
                            let lastEmoji = $('#' + reviewId).find('.block-emoji.' + result['previous']).find('.count-emoji')
                            let count = lastEmoji.text()
                            lastEmoji.text(count - 1)
                        }
                    }
                }
                checkCountEmoji(reviewId)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var errors = jqXHR.responseJSON.errors; // Ошибки в формате JSON

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
    }

    setInterval(getCountEmoji, 5000)

    function checkCountEmoji(reviewId)
    {
        var emoji = $('#' + reviewId).find('.block-emoji')

        for (let i = 0; i < emoji.length; ++i) {
            let count = emoji[i]
            let element = $(count).find('.count-emoji').text()
            if (element <= 0) {
                $(count).remove()
            }
        }
    }

    function updateCountEmoji(reviewId, countNew, emojiId)
    {
        var emoji = $('#' + reviewId).find('.block-emoji')

        if (emoji.length > 1 && emojiId == 0) {
            emoji.remove()
        }

        for (let i = 0; i < emoji.length; ++i) {
            let elementEmojiId = $(emoji[i]).attr('class').split(' ')[1]
            if (elementEmojiId == emojiId) {
                let count = emoji[i]
                let element = $(count).find('.count-emoji').text()
                if (element != countNew) {
                    $('#' + reviewId).find('.block-emoji.' + emojiId).find('.count-emoji').text(countNew)
                    console.log(element)
                }
            }
        }
        checkCountEmoji(reviewId)
    }

    function getCountEmoji()
    {
        var container = $('.container.read')
        var reviews = []

        for (let i = 0; i < container.length; ++i) {
            reviews.push($(container[i]).attr('id'))
        }

        $.ajax({
            url: '{{ route('post.update.emoji') }}',
            type: "POST",
            data: {
                reviewId: reviews,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                if (result['success']) {
                    const emoji = result['countEmoji']

                    for (let key in emoji) {
                        const emojiPage = $('#' + key).find('.block-emoji')

                        if (emoji[key].length < emojiPage.length && emojiPage.length >= 1) {
                            let emojiIdPage = []
                            //let emojiIdServer = []
                            for (let i = 0; i < emojiPage.length; ++i) {
                                emojiIdPage[i] = $(emojiPage[i]).attr('class').split(' ')[1]
                            }
                            var uniqueEmojiPage = emojiIdPage
                            /*for (let key2 in emoji[key]) {
                                emojiIdServer[key2] = emoji[key][key2]['emoji_id']
                            }
                            /*var newArray = emojiIdPage.filter(function(element) {
                                return emojiIdServer.indexOf(element) === -1;
                            });*/

                            for (let i = 0; i < emoji[key].length; ++i) {
                                for (let j = 0; j < emojiIdPage.length; ++j) {
                                    if (emoji[key][i]['emoji_id'] == emojiIdPage[j]) {
                                        delete uniqueEmojiPage[j]
                                        break
                                    }
                                }
                            }

                            for (let i in uniqueEmojiPage) {
                                $('#' + key).find('.block-emoji.' + uniqueEmojiPage[i]).remove()
                            }
                            continue
                        }
                        if (emoji[key].length >= 1 && emojiPage.length < emoji[key].length) {
                            let emojiIdPage = []
                            //let emojiIdServer = []
                            var newEmojiServer = emoji[key]

                            /*
                            for (let i = 0; i < emojiPage.length; ++i) {
                                emojiIdPage[i] = $(emojiPage[i]).attr('class').split(' ')[1]
                            }
                            for (let key2 in emoji[key]) {
                                emojiIdServer[key2] = emoji[key][key2]['emoji_id']
                            }
                            var newArray = emojiIdServer.filter(function(element) {
                                return emojiIdPage.indexOf(element) === -1;
                            });
                            */

                            for (let i = 0; i < emojiPage.length; ++i) {
                                emojiIdPage[i] = $(emojiPage[i]).attr('class').split(' ')[1]
                            }

                            for (let i = 0; i < emoji[key].length; ++i) {
                                for (let j = 0; j < emojiIdPage.length; ++j) {
                                    if (emoji[key][i]['emoji_id'] == emojiIdPage[j]) {
                                        delete newEmojiServer[i]
                                        break
                                    }
                                }
                            }

                            /*
                             for (let i = 0; i < emojiIdServer.length; ++i) {
                                for (let j = 0; j < emojiIdPage.length; ++j) {
                                    if (emojiIdServer[key][i] == emojiIdPage[key][i]) {
                                        delete emojiIdServer[key][i]
                                    }
                                }
                            }
                            */

                            /*for (let i = 0; i < emojiIdServer.length; ++i) {
                                for (let j = 0; j < emoji[key].length; ++j) {
                                    if (newArray[i] == emoji[key][j]['emoji_id']) {
                                        newEmojiServer[i] = emoji[key][j]
                                    }
                                }
                            }*/
                            for (let i in newEmojiServer) {
                                var a = $('<a class="block-emoji ' + newEmojiServer[i]['emoji_id'] + '" href="javascript:putReview(' + key + ', ' + newEmojiServer[i]['emoji_id'] + ')"> <img src="' + newEmojiServer[i]['path'] + '"> <p class="count-emoji">' + newEmojiServer[i]['num'] + '</p> </a>');
                                $('#' + key).find('.review-emoji').append(a)
                            }
                            continue
                        }
                        if (emoji[key].length > 0) {
                            let count = emoji[key][0]['num']
                            let emojiId = emoji[key][0]['emoji_id']
                            updateCountEmoji(key, count, emojiId)
                        }
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var errors = jqXHR.responseJSON.errors; // Ошибки в формате JSON

                if (!errors) {
                    $('.server-message').text('Ошибка сервера');
                    return;
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
