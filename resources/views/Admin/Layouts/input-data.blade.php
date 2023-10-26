<div class="container-data">
    <form id="data">
        <div class="form-group">
            <label>Название игры</label>
            <input type="text" name="name" value="{{ $game ? $game->name : null }}">
            <label class="error-name"></label>
        </div>
        <div class="form-group">
            <label>Цена игры</label>
            <input type="text" name="price" value="{{ $game ? $game->price : null }}">
            <label class="error-price"></label>
        </div>
        <div class="form-group">
            <label>Жанры</label>
            <div id="block-genres">
                <div id="genre-buttons" class="dropdown">
                    @foreach($game->genres() as $genreGame)
                        <button value="{{ $genreGame->id }}" class="btn btn-info block-genre" type="button">
                            <span class="select-genre">{{ $genreGame->name}}</span>
                        </button>
                    @endforeach
                </div>
                <div id="select-new-genre">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="add-genre">Добавить жанр</span>
                    </button>
                    <div class="dropdown-menu genres" aria-labelledby="dropdownMenuButton">
                        @foreach($game->excludeGenres() as $genre)
                            <a id="{{ $genre->id }}" class="dropdown-item genre" href="javascript:selectGenre({{ $genre->id }})">{{ $genre->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Издатель</label>
            <div id="select-new-publisher">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="select-publisher">{{ $game->publisher->name ?? 'Добавить издателя' }}</span>
                </button>
                <div class="dropdown-menu publishers" aria-labelledby="dropdownMenuButton">
                    @foreach($game->excludePublisher() as $publisher)
                        <a id="{{ $publisher->id }}" class="dropdown-item publisher" href="javascript:selectPublisher({{ $publisher->id }})">{{ $publisher->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Описание игры</label>
            <textarea id="summernote" type="text" name="description">{{ $game ? $game->description : null }}</textarea>
            <label class="error-description"></label>
        </div>
        <div class="form-group">
            <div>
                <label>Минимальные требования</label>
                <input type="text" name="min_settings[ОС]"  placeholder="ОС" value="{{ $game ? $game->min_settings['ОС'] : null }}">
                <input type="text" name="min_settings[Процессор]" placeholder="Процессор" value="{{ $game ? $game->min_settings['Процессор'] : null }}">
                <input type="text" name="min_settings[Видеокарта]" placeholder="Видеокарта" value="{{ $game ? $game->min_settings['Видеокарта'] : null }}">
            </div>
            <div>
                <label class="error-min"></label>
            </div>
        </div>
        <div class="form-group">
            <div>
                <label>Рекомендованные требования</label>
                <input type="text" name="max_settings[ОС]" placeholder="ОС" value="{{ $game ? $game->max_settings['ОС'] : null }}">
                <input type="text" name="max_settings[Процессор]" placeholder="Процессор" value="{{ $game ? $game->max_settings['Процессор'] : null }}">
                <input type="text" name="max_settings[Видеокарта]" placeholder="Видеокарта" value="{{ $game ? $game->max_settings['Видеокарта'] : null }}">
            </div>
            <div>
                <label class="error-max"></label>
            </div>
        </div>
        <div id="send" class="data">
            <div class="btn btn-primary">Отправить</div>
        </div>
    </form>
</div>

<script>
    /*window.onload = function () {
        toggleBlockGenre()
    }*/

    //Genres
    var genreId = @json(\App\Helpers\Collection::getColumnsFromCollection($game->genres(), 'id'));
    var genresArray = @json($genres);
    var addGenreList = $('.genres')

    //Publisher
    var selectedPublisher = '{{ $game->publisher->deleted_at ? null : $game->publisher->id }}';
    var publishers = @json($publishers);

    $(document).on('click', '.block-genre', function (e) {
        let id = $(this).val()
        $(this).remove()

        for (let i = 0; i < genreId.length; ++i) {
            if (genreId[i] == id) {
                genreId.splice(i, 1)
            }
        }
        for(let genre of genresArray) {
            if (id == genre['id']) {
                element = '<a id="' + genre['id'] + '" class="dropdown-item genre" href="javascript:selectGenre(' + genre['id'] + ')">' + genre['name'] + '</a>'
                addGenreList.append(element)
                $(".genre").sort(function(a, b) {
                    return $(a).text().localeCompare($(b).text());
                }).appendTo(".genres");
                break
            }
        }
        //toggleBlockGenre()
    })

    /*function toggleBlockGenre()
    {
        var genres = $('.block-genre')
        var genreButtons = $('#genre-buttons')

        if (genres.length == 0) {
            $('#genre-buttons').toggle()
        }
        if (genres.length == 1 && genreButtons[0].style.display === 'none') {
            $('#genre-buttons').toggle()
        }
    }*/

    function selectPublisher(idNew)
    {
        var blockPublisher = $('#' + idNew + '.publisher')
        removeFromList(blockPublisher)

        for(let publisher of publishers) {
            if (selectedPublisher && selectedPublisher == publisher['id']) {
                addButtonPublisher(publisher['id'], publisher['name'])
                break
            }
        }
        for(let publisher of publishers) {
            if (idNew == publisher['id']) {
                $('.select-publisher').text(publisher['name'])
                selectedPublisher = Number(idNew)
                break
            }
        }
    }

    function addButtonPublisher(id, name) {
        var buttonPublisher = ('<a id="' + id + '" class="dropdown-item publisher" href="javascript:selectPublisher(' + id + ')">' + name + '</a>')
        $('.publishers').append(buttonPublisher)

        $('.publisher').sort(function(a, b) {
            return $(a).text().localeCompare($(b).text());
        }).appendTo('.publishers');
    }

    function selectGenre(idNew)
    {
        var blockGenre = $('#' + idNew + '.genre')
        removeFromList(blockGenre)

        for(let genre of genresArray) {
            if (idNew == genre['id']) {
                addButtonGenre(idNew, genre['name'])
                genreId.push(Number(idNew))
                //toggleBlockGenre()
                break
            }
        }
    }

    function addButtonGenre(id, name) {
        var buttonGenre = ('<button class="btn btn-info block-genre" type="button" id="selectedGenre">' +
            '<span class="add-genre">' + name + '</span>' +
            '</button>')

        $('#genre-buttons').append(buttonGenre)
    }

    function removeFromList(blockGenre)
    {
        blockGenre.remove()
    }
</script>
