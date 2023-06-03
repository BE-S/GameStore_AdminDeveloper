@extends('Client.Layouts.index')

@section('content')

    <div class="search background block">
        <div id="search-info">
            <div class="search-text">
                По вашему запросу <span id="query">{{ $query }}</span> найдено <span id="count-search">{{ $countFound }}</span>
            </div>
            <div class="result">
                @include('Client.Layouts.Catalog.search-result', compact('games', 'reviews'))
            </div>
        </div>
        <div id="search-categories">
            <div class="block">
                <div class="title">Цена</div>
                <p>
                    <input class="category discount" type="checkbox">
                    <label>Скидки</label>
                </p>
            </div>
            <div class="block">
                <div class="title">Категории</div>
                @foreach($categories as $key => $category)
                    <p>
                        @if ($genresId)
                            @foreach($genresId as $genreId)
                                <input class="category genre" type="checkbox" {{ $category->id == $genreId ? 'checked="true"' : null }} value="{{ $category->id }}">
                            @endforeach
                        @else
                            <input class="category genre" type="checkbox" value="{{ $category->id }}">
                        @endif

                        <label>{{ $category->name }}</label>
                    </p>
                @endforeach
            </div>
        </div>
    </div>

<script>
    $(function () {
        const buttons = document.querySelectorAll('.category');
        buttons.forEach(button => {
            button.addEventListener('click', sendCategory);
        });

        function sendCategory() {
            var discount = document.getElementsByClassName('discount');

            var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            var newUrl = baseUrl + '';
            history.pushState(null, null, newUrl);

            $.ajax({
                url: '{{ route("post.search.property") }}',
                type: "POST",
                data: {
                    search: "{{ $query }}",
                    properties: {
                        'discount': discount[0].checked,
                    },
                    categories: getCategory()
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    $('.link-game').remove()
                    $('.found-nothing').remove()
                    $('#count-search').empty()
                    $('.result').append(result['viewLoad'])
                    $('#count-search').append(result['countLoad'])
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

        function getCategory()
        {
            var genre = document.getElementsByClassName('genre');
            var genreArr = {}
            for (let i = 0; i < genre.length; ++i) {
                if (genre[i].checked) {
                    genreArr[i] = genre[i].value
                }
            }
            return genreArr
        }
    })
</script>

@endsection
