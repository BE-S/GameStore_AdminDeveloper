@foreach($games as $game)
    <a href="{{ route('get.game', $game->id) }}" class="link-game">
        <img src="{{ '/storage/' . $game->gameCover->store_header_image }}">
        <div>
            <p class="name">{{ $game->name }}</p>
            <p class="price">{{ $game->price }}</p>
        </div>
    </a>
@endforeach
