@extends('Client.Layouts.index')

@section('content')

    <div class="search background block">
        <div class="search-text">
            По вашему запросу <span id="query">{{ $query }}</span> найдено {{ count($games) }} продуктов
        </div>
        <div class="result">
            @foreach($games as $game)
                <a href="{{ route('get.game', $game->id) }}" class="link-game">
                    <img src="{{ '/storage/' . $game->gameCover->small }}">
                    <div class="inscription">
                        <div class="name">{{ $game->name }}</div>
                        <div class="price">
                            @if (count($game->keyProduct) <= 0)
                                <div class="stop-out">
                                    Нет в наличии
                                </div>
                            @else
                                @if ($game->discount)
                                    <span class="standard-price">{{ bcdiv($game->price, 1, 2) . " руб." }}</span>
                                @endif
                                <span class="calculation-amount">
                                    {{ $game->calculationDiscount() . " руб." }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="grade">
                        Оценка
                    </div>
                </a>
            @endforeach
        </div>
    </div>

@endsection
