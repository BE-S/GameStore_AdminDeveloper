@extends('Client.Layouts.index')

@section('content')
    <link rel="stylesheet" href="/css/client/game-slider.css">

    @include('Client.Layouts.Game.slider-game', $game)

    <div class="block-text" id="add-cart">
        <div class="text-left background-color padding-block">
            Купить ключ для стима {{$game->name}}
        </div>
        <div class="text-right background-color padding-block">
            @guest()
                <a id="sig-in" href="{{ route("get.sig-in") }}">Авторизоваться</a>
            @endguest

            @auth()
                @if ($game->discount)
                    <span class="standard-price">{{ bcdiv($game->price, 1, 2) . " руб." }}</span>
                @endif
                    <span class="calculation-amount">
                        {{ $game->calculationDiscount() . " руб." }}
                    </span>
                @if ($cartGame)
                    <a class="to-cart" href="{{ route("get.cart") }}">В корзине</a>
                @else
                    <a class="to-cart" href="javascript:addToCart({{$game->id}});">В корзину</a>
                @endif
                @else
            @endauth
        </div>
    </div>

    <div class="block-text background-color padding-block" id="description">
        <div>
            {!!$game->description!!}
        </div>
    </div>

    <div class="block-text background-color" id="system-requirements">
        <div class="main-inscription">Системные требования</div>
        <div class="system">
            <div class="text-left padding-block">
                <div class="child-inscription">Минимальные</div>
                <table>
                @foreach($game->min_settings as $system => $characteristic)
                    <tr>
                        <td>{{$system}}</td>
                        <td>{{$characteristic}}</td>
                    </tr>
                @endforeach
                </table>
            </div>
            <div class="text-right padding-block">
                <div class="child-inscription">Рекомендованные</div>
                <table>
                    @foreach($game->max_settings as $system => $characteristic)
                        <tr>
                            <td>{{$system}}</td>
                            <td>{{$characteristic}}</td>
                        </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>

    <div class="block-text" id="reviews">

    </div>

    <script>
        function addToCart(id) {
            $.ajax({
                url: '{{ route('post.add.cart') }}',
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
                    if (result['Duplicate']) {
                        alert("Товар уже добавлен")
                        return;
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
        }
    </script>
@endsection
