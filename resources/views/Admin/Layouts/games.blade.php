@foreach($games as $key => $game)
    <a class="game" href="{{ route("get.dashboard.upload.game.data", $game->id) }}">
        <div class="game-cover">
            <picture class="image">
                <img src="{{ $game->gameCover->small }}">
            </picture>
        </div>
        <div class="name">
            {{ $game->name }}
        </div>
        <div class="union">
            <div class="count-key">
                @if (count($game->keyProduct) <= 0)
                    <div class="stop-out">
                        Нет в наличии
                    </div>
                @else
                    <div>В наличии {{ count($game->keyProduct) }} ключей</div>
                @endif
            </div>
            <div class="published">
                {{ $game->is_published ? "Опуликовано" : "Не опубликовано" }}
            </div>
        </div>
        <div class="price">
            {{ $game->price . " руб." }}
        </div>
    </a>
@endforeach
