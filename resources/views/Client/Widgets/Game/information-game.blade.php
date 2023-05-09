<div class="block-text" id="add-cart">
    <div class="text-left background-color padding-block">
        Купить ключ для стима {{$game->name}}
    </div>
    <div class="text-right background-color padding-block">
        @guest()
            <a id="sig-in" href="{{ route("get.sig-in") }}">Авторизоваться</a>
        @endguest

        @auth()
            @if (count($game->keyProduct) <= 0)
                <div class="stop-out" style="justify-content: end">
                    Нет в наличии
                </div>
            @else
                @if ($game->discount)
                    <span class="standard-price">{{ bcdiv($game->price, 1, 2) . " руб." }}</span>
                @endif
                <span class="calculation-amount">
                            {{ $game->calculationDiscount() . " руб." }}
                        </span>
                @isset($cartGame)
                    @if ($cartGame)
                        <a class="to-cart" href="{{ route("get.cart") }}">В корзине</a>
                    @else
                        <a class="to-cart" href="javascript:addToCart({{$game->id}});">В корзину</a>
                    @endif
                @endisset
            @endif
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
