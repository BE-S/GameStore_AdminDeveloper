<div class="container">
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
            <label>Описание игры</label>
            <textarea type="text" name="description">{{ $game ? $game->description : null }}</textarea>
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
        <input type="submit" id="game-info">
    </form>
</div>
