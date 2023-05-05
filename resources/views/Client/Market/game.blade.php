@extends('Client.Layouts.index')

@section('content')
    <link rel="stylesheet" href="/css/client/game-slider.css">

    @if (!$game->is_published)
        <div id="published">
            <div>Не опубликовано</div>
        </div>
    @endif

    @include('Client.Layouts.Game.slider-game', $game)

    @include('Client.Layouts.Game.information-game', compact('game', 'cartGame'))

    <script>
        function addToCart(id) {
            $.ajax({
                url: '{{ route('post.add.cart') }}',
                type: "POST",
                data: {
                    gameId: id
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result['Error']) {
                        alert(result['message'])
                        return;
                    }
                    if (result['Duplicate']) {
                        alert("Товар уже добавлен")
                        return;
                    }
                    location = result
                },
                statusCode: {
                    401: function (err) {
                        console.log(err);
                    },
                    500: function (err) {
                        console.log(err);
                    }
                }
            })
        }
    </script>
@endsection
