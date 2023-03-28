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
                <a id="sig-in" href="{{ route("get.sig-in") }}">Купить</a>
            @endguest

            @auth()
                @if (empty($hasProductUser))
                    {{ $price . " руб." }}
                    <a id="buy" href="{{ route("get.buy.game", $game->id) }}">Купить</a>
                @else
                    В библиотеке
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

    <div class="block-text" id="reviews">

    </div>
@endsection



{{--const carousel = document.getElementsByClassName('button')--}}
{{--var height = 0--}}
{{--var maxHeightCarousel = 6 * 100--}}

{{--if (height < maxHeightCarousel) {--}}
{{--alert(1)--}}
{{--$('#back').bind('click', function (e) {--}}
{{--height += 100--}}
{{--shiftImage(height)--}}
{{--})--}}

{{--$('#next').bind('click', function (e) {--}}
{{--height -= 100--}}
{{--shiftImage(height)--}}
{{--})--}}
{{--}--}}

{{--function shiftImage(height) {--}}
{{--for (let i = 0; i < maxHeightCarousel; ++i) {--}}
{{--carousel[i].style.transform = 'translateY(' + height + '%)'--}}
{{--}--}}
{{--}--}}
