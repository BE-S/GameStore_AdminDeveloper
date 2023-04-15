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
                            <span>
                                {{ $recommended->game->calculationDiscount() . " руб." }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
</div>
