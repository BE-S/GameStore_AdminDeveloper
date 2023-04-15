<div class="collection-category">
    <div class="name-category">
        Игры с категорией: {{ $category->name }}
    </div>
    <div class="games">
        @foreach ($blockCategory as $block)
            <a class="game" href="{{ route("get.game", $block->game->id) }}">
                <div class="price">{{ $block->game->price . ' руб.'}}</div>
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
                <div>
                    {{ bcdiv($row->game->price, 1, 2) . " руб."}}
                </div>
            </div>
        </div>
    </div>
@endforeach
