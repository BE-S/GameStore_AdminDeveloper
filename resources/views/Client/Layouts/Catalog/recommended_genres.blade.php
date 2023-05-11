<div class="collection-category">
    <div class="name-category">
        Игры с категорией: {{ $category->name }}
    </div>
    <div class="games">
        @foreach ($blockCategory as $block)
            <a class="game" href="{{ route("get.game", $block->game->id) }}">
                @if ($block->game->discount && count($block->game->keyProduct) > 0)
                    <div class="discount">
                        {{ $block->game->discount->amount . "%" }}
                    </div>
                @endif
                <div class="price">
                    @if (count($block->game->keyProduct) <= 0)
                        <div class="stop-out">
                            Нет в наличии
                        </div>
                    @else
                        @if ($block->game->discount)
                            <span class="standard-price">{{ bcdiv($block->game->price, 1, 2) . " руб." }}</span>
                        @endif
                        <span class="calculation-amount">
                        {{ $block->game->calculationDiscount() . " руб." }}
                    </span>
                    @endif
                </div>
                <div class="game-cover">
                    <picture class="image">
                        <img src="{{ "/storage/" . $block->game->gameCover->poster }}">
                    </picture>
                </div>
            </a>
        @endforeach
    </div>
</div>
@foreach($rowCategory as $row)
    <div class="category-row">
        <div class="background-row">
            <div class="name">
                {{ $row->game->name }}
            </div>
            <a class="covers" href="{{ route("get.game", $row->game->id) }}">
                <picture class="image">
                    @if ($row->game->discount && count($row->game->keyProduct) > 0)
                        <div class="discount">
                            {{ $row->game->discount->amount . "%" }}
                        </div>
                    @endif
                    <img src="{{ "/storage/" . $row->game->gameCover->small }}">
                </picture>
                <div class="screens">
                @foreach($row->game->gameCover->screen as $key => $screen)
                    @if ($key < 3)
                        <div class="screen">
                            <img src="{{ "/storage/" . $screen}}">
                        </div>
                    @else
                        @continue
                    @endif
                @endforeach
                </div>
            </a>
            <div class="price">
                @if (count($row->game->keyProduct) <= 0)
                    <div class="stop-out">
                        Нет в наличии
                    </div>
                @else
                    @if ($row->game->discount)
                        <span class="standard-price">{{ bcdiv($row->game->price, 1, 2) . " руб." }}</span>
                    @endif
                    <span class="calculation-amount">
                        {{ $row->game->calculationDiscount() . " руб." }}
                    </span>
                @endif
            </div>
        </div>
    </div>
@endforeach
