<div class="container-cover">
    <form id="covers">
        <div id="small" class="form-group">
            <div class="input-group mb-3 input">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">Заглавное изображение</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="small">
                    <label class="custom-file-label" for="inputGroupFile01">Выбрать изображение</label>
                </div>
            </div>
            @isset($game)
                @if ($game->gameCover->small)
                    <div class="cover-load">
                        <img src="{{ $game->gameCover->small }}" width="200em">
                    </div>
                @else
                    <div class="not-exist">Изображение отсутсвует</div>
                @endif
            @endisset
        </div>
        <div id="header" class="form-group">
            <div class="input-group mb-3 input">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon02">Изображение для поиска</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile02" aria-describedby="inputGroupFileAddon01" name="store_header_image">
                    <label class="custom-file-label" for="inputGroupFile02">Выбрать изображение</label>
                </div>
            </div>
            @isset($game)
                @if ($game->gameCover->store_header_image)
                    <div class="cover-load">
                        <img src="{{ $game->gameCover->store_header_image }}" width="200em">
                    </div>
                @else
                    <div class="not-exist">Изображение отсутсвует</div>
                @endif
            @endisset
        </div>
        <div id="poster" class="form-group">
            <div class="input-group mb-3 input">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon03">Постер</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile03" aria-describedby="inputGroupFileAddon01" name="poster">
                    <label class="custom-file-label" for="inputGroupFile03">Выбрать изображение</label>
                </div>
            </div>
            @isset($game)
                @if ($game->gameCover->poster)
                    <div class="cover-load">
                        <img src="{{ $game->gameCover->poster }}" width="200em">
                    </div>
                @else
                    <div class="not-exist">Изображение отсутсвует</div>
                @endif
            @endisset
        </div>
        <div id="screens" class="form-group">
            <div class="input-group mb-3 input">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon04">Скриншоты</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon01" multiple name="screen[]">
                    <label class="custom-file-label" for="inputGroupFile04">Выбрать изображение</label>
                </div>
            </div>
            @isset($game)
                @if ($game->gameCover->screen)
                    <div class="cover-load">
                        @foreach($game->gameCover->screen as $screen)
                            <img src="{{ $screen }}" width="200em">
                        @endforeach
                    </div>
                @else
                    <div class="not-exist">Изображения отсутсвуют</div>
                @endif
            @endisset
        </div>
        <div id="background" class="form-group">
            <div class="input-group mb-3 input">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon05">Задний фон</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile05" aria-describedby="inputGroupFileAddon01" name="background_image">
                    <label class="custom-file-label" for="inputGroupFile05">Выбрать изображение</label>
                </div>
            </div>
            @isset($game)
                @if ($game->gameCover->background_image)
                    <div class="cover-load">
                        <img src="{{ $game->gameCover->background_image }}" width="200em">
                    </div>
                @else
                    <div class="not-exist">Изображение отсутсвует</div>
                @endif
            @endisset
        </div>
        <div id="send" class="cover">
            <div class="btn btn-primary">Отправить</div>
        </div>
    </form>
</div>

<script>
    $(function () {
        $(".custom-file-input").change(function (e) {
            var label = $(this).next()

            if ($(this)[0].files[0]) {
                $(label).text($(this)[0].files[0].name).css('color', 'black')
            } else {
                $(label).text('Выбрать изображение').css('color', 'black')
            }
        })
    })
</script>
