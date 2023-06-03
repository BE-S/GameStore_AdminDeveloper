<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div>
        <div class="carousel-indicators" id="buttons">
            @foreach($game->gameCover->screen as $key => $path)
                <div class="button active" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" aria-label="Slide {{$key}}">
                    <img src="{{ asset('/storage/' . $path) }}">
                </div>
            @endforeach
        </div>
    </div>
    <div class="carousel-inner">
        @foreach($game->gameCover->screen as $key => $path)
            <div class="carousel-item">
                <img src="{{ asset('/storage/' . $path) }}" class="d-block w-100" alt="...">
            </div>
        @endforeach
        <button id="back" class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button id="next" class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

