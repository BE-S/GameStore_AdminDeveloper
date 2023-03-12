<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div>
        <div class="carousel-indicators" id="buttons">
            @foreach($game->gameCover->screen as $key => $path)
                <div class="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" aria-label="Slide {{$key}}">
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

<script>
    var height = 0;
    var maxHeightCarousel = -5 * 100;

    const carouselFull = document.getElementsByClassName('carousel-item')
    const carouselSmall = document.getElementsByClassName('button')

    var i = 0;
    var carouselLength = carouselFull.length;

    let slide = $('.carousel-item').first()
    slide.attr('class', 'carousel-item active');

    let button = $('.button').first()
    button.attr('class', 'button');
    carouselSmall[i].classList.toggle('active')

    $('#back').bind('click', function (e) {
        if (i > 0) {
            shiftScreen(i ,--i)
            shiftScreenY(height += 100)
        }
    })

    $('#next').bind('click', function (e) {
        if (i < carouselLength - 1) {
            shiftScreen(i, ++i)
            shiftScreenY(height -= 100)
        }
    })

    function shiftScreen(current, next)
    {
        carouselFull[current].classList.toggle('end')
        carouselFull[next].classList.toggle('start')

        carouselFull[current].classList.toggle('active')
        carouselFull[next].classList.toggle('active')

        carouselSmall[current].classList.toggle('active')
        carouselSmall[next].classList.toggle('active')

        setTimeout(startAnimation, 1000, current, next);
    }

    function shiftScreenY(height)
    {
        for (let i = 0; i < carouselSmall.length; ++i) {
            carouselSmall[i].style.transform = 'translateY(' + height + '%)'
        }
    }

    function startAnimation(current, next) {
        carouselFull[current].classList.toggle('end')
        carouselFull[next].classList.toggle('start')
    }
</script>

