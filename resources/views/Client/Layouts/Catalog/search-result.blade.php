@if ($games->isEmpty())
    <h1 class="found-nothing">Ничего не найдено</h1>
@endif
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
            Отзывы: {{ $reviews->ultimate($game->id) }}
        </div>
    </a>
@endforeach
