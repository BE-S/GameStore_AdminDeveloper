<div id="category-adventure">
        <div class="block-title">
            <div class="content">
                Окунитесь в мир приключений
            </div>
        </div>
        <div class="collection-games">
            @foreach($recommendedGames as $key => $recommended)
                <a class="game" href="{{ route("get.game", $recommended->game->id) }}">
                    <div class="game-cover">
                        <picture class="image">
                            <img src="{{ "/storage/" . $recommended->game->gameCover->small }}">
                        </picture>
                        <div class="price">
                            @if (count($recommended->game->keyProduct) <= 0)
                                <div class="stop-out">
                                    Нет в наличии
                                </div>
                            @else
                                @if ($recommended->game->discount)
                                    <span class="standard-price">{{ bcdiv($recommended->game->price, 1, 2) . " руб." }}</span>
                                @endif
                                <span class="calculation-amount">
                                    {{ $recommended->game->calculationDiscount() . " руб." }}
                                </span>
                            @endif
                        </div>
                        @if ($recommended->game->discount && count($recommended->game->keyProduct) > 0)
                            <div class="discount">
                                {{ $recommended->game->discount->amount . "%" }}
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
</div>
