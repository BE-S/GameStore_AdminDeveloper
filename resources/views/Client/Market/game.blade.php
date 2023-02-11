@extends('Client.Layouts.index')

@section('content')

    @include('Client.Layouts.Slider.slider-game', $game->gameCover)

    <div class="block-text" id="add-cart">
        <div class="text-left background-color padding-block">
            Купить ключ для стима {{$game->name}}
        </div>
        <div class="text-right background-color padding-block">
            <button>В корзину</button>
        </div>
    </div>

    <div class="block-text background-color padding-block" id="description">
        <div>
            {!!$game->description!!}
        </div>
    </div>

    <div class="block-text background-color" id="system-requirements">
        <div class="main-inscription">Системные требования</div>
        <div class="system">
            <div class="text-left padding-block">
                <div class="child-inscription">Минимальные</div>
                <table>
                @foreach($game->min_settings as $system => $characteristic)
                    <tr>
                        <td>{{$system}}</td>
                        <td>{{$characteristic}}</td>
                    </tr>
                @endforeach
                </table>
            </div>
            <div class="text-right padding-block">
                <div class="child-inscription">Рекомендованные</div>
                <table>
                    @foreach($game->max_settings as $system => $characteristic)
                        <tr>
                            <td>{{$system}}</td>
                            <td>{{$characteristic}}</td>
                        </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>

    <div class="block-text" id="reviews">

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
@endsection



{{--const carousel = document.getElementsByClassName('button')--}}
{{--var height = 0--}}
{{--var maxHeightCarousel = 6 * 100--}}

{{--if (height < maxHeightCarousel) {--}}
{{--alert(1)--}}
{{--$('#back').bind('click', function (e) {--}}
{{--height += 100--}}
{{--shiftImage(height)--}}
{{--})--}}

{{--$('#next').bind('click', function (e) {--}}
{{--height -= 100--}}
{{--shiftImage(height)--}}
{{--})--}}
{{--}--}}

{{--function shiftImage(height) {--}}
{{--for (let i = 0; i < maxHeightCarousel; ++i) {--}}
{{--carousel[i].style.transform = 'translateY(' + height + '%)'--}}
{{--}--}}
{{--}--}}
