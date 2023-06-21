@if ($games->isEmpty())
    <h5 class="found-nothing">Ничего не найдено</h5>
@endif
@foreach($games as $game)
    <a href="{{ route('get.game', $game->id) }}" class="link-game">
        <img src="{{ $game->gameCover->store_header_image }}">
        <div>
            <p class="name">{{ $game->name }}</p>
            <p class="price">{{ $game->calculationDiscount() }} рублей</p>
        </div>
    </a>
@endforeach
