@extends('Client.Layouts.index')

@section('content')
    <link rel="stylesheet" href="/css/client/catalog-slider.css">

    @include("Client.Layouts.Catalog.slider-catalog", $sliderGames)

    @include("Client.Layouts.Catalog.banner")

    @include("Client.Layouts.Catalog.recommended", $recommendedGames)

    <div id="more-games" style="width: 100%"></div>
    <div id="loading">Загрузка</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            var $element = $('#loading')
            var category = 1;
            var maxCategory = 1;
            var actionScroll = true;

            $(window).scroll(function() {
                var scroll = $(window).scrollTop() + $(window).height()
                //Если скролл до конца елемента
                //var offset = $element.offset().top + $element.height();
                //Если скролл до начала елемента
                var offset = $element.offset().top

                if (scroll > offset && actionScroll && category <= maxCategory) {
                    actionScroll = false;
                    alert("Загрузка")
                    $.ajax({
                        url: '{{ route('post.load.game') }}',
                        type: "POST",
                        data: {
                            categoryId: category,
                        },
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            if (result['End']) {
                                actionScroll = false;
                                $('#loading').attr('style', 'display: none;')
                                $('.footer').attr('style', 'display: flex;')
                                return;
                            }

                            var loadElement = document.createElement('div')
                            loadElement.className = 'loading-block'
                            loadElement.innerHTML = result['viewLoad']

                            $('#more-games').append(loadElement)
                            category = ++result['categoryId']
                            maxCategory = result['maxCategory']
                            actionScroll = true;
                        },
                        statusCode: {
                            401: function (err) {
                                console.log(err)
                            },
                            500: function (err) {
                                console.log(err)
                            }
                        }
                    })
                }
            });
        });
    </script>
@endsection

