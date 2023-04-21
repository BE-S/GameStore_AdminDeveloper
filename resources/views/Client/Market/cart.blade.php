@extends('Client.Layouts.index')

@section('content')
    <div class="background block cart" style="text-align: center">
        <div class="title">Корзина с покупочками</div>
        <div class="games">
            @isset($cartGames)
                @foreach($cartGames as $game)
                    <div id="{{ $game->id }}" class="game">
                        <div class="cover">
                            <img src="{{ "/storage/" . $game->gameCover->small }}">
                        </div>
                        <div id="description">
                            <div class="left">
                                <div>Название: {{ $game->name }}</div>
                            </div>
                            <div class="right">
                                <div>Стоимость: {{ bcdiv($game->calculationDiscount(), 1, 2) . " руб." }}</div>
                                <a class="trash" href="javascript:deleteCart({{ $game->id }})">
                                    <img src="http://localhost:8080/image/icon/trash.png">
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <div class="buttons">
            <div class="buy-game">
                <div class="amount">Итого: {{ bcdiv($amountCart, 1, 2) }} Рублей</div>
                <div id="buy">Купить</div>
            </div>
            <div class="delete-cart">
                <div id="btn">Удалить все товары</div>
            </div>
        </div>
        <div class="info">
            <div>
                После совершения покупки ключ прийдёт на вашу почту.
            </div>
        </div>
    </div>

    <script>
        function deleteCart(id) {
            $.ajax({
                url: '{{ route('post.delete.cart') }}',
                type: "POST",
                data: {
                    gameId: id
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result['Error']) {
                        alert(result['message'])
                        return;
                    }
                    if (result['Success']) {
                        let allGame = document.getElementsByClassName('game')
                        let game = document.getElementById(id)
                        game.remove()
                        $("#count-games").text(allGame.length)
                        $(".amount").text("Итого: " + result['Amount'] + " Рублей");
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
    </script>
    <script>
        $(function () {
            var game = document.getElementsByClassName('game')

            $('#btn').bind('click', function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('post.all.delete.cart') }}',
                    type: "POST",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result['Error']) {
                            alert(result['message'])
                            return;
                        }
                        if (result['Success']) {
                            $("div").remove(".game")
                            $("#count-games").text("0")
                            $(".amount").text("Итого: " + result['Amount'] + " Рублей");
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
        })
    </script>
    <script>
        $(function () {
            $('#buy').bind('click', function (e) {
                var game = document.getElementsByClassName('game')
                var cartGames = new Array()

                for (let i = 0; i < game.length; ++i) {
                    cartGames[i] = game[i].id
                }

                e.preventDefault();

                $.ajax({
                    url: '{{ route('get.buy.game') }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        cartGames: cartGames,
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result['Error'] && result['notExist']) {
                            alert("Игра " + result['notExist'] + " расродана");
                        }
                        location = result
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
        })
    </script>
@endsection
