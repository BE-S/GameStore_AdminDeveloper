    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($sliderGames as $key => $slider)
                @if ($key == 0)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                @else
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}" aria-label="Slide {{$key + 1}}"></button>
                @endif
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($sliderGames as $slider)
                <div class="carousel-item">
                    <a href="{{ route("get.game", $slider->game->id) }}">
                        <div class="main-screen">
                            <img src="{{ $slider->game->gameCover->small }}">
                        </div>
                    </a>
                    <div class="screens">
                        @foreach($slider->game->gameCover->screen as $key => $screen)
                            @if ($key < 3)
                                <div>
                                    <img src="{{ $screen }}">
                                </div>
                            @else
                                @continue
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

<script>
    let slide = $('.carousel-item').first()
    slide.attr('class', 'carousel-item active')
</script>
