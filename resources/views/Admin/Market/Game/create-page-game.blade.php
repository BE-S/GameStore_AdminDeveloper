@extends("Admin.Layouts.index")

@section('content')

    <div class="container">
        @if (is_null($product))
            <form action="{{ route('post.upload.description.data') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Имя игры</label>
                    <input type="text"  name="name">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form-group">
                    <label>Желаемая цена игры</label>
                    <input type="text" name="price">
                    @error('price')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form-group">
                    <label>Описание игры</label>
                    <input type="text" name="description">
                    @error('description')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form-group">
                    <div>
                        <label>минималки</label>
                        <input type="text" name="min_settings[]" placeholder="ОС">
                        <input type="text" name="min_settings[]" placeholder="Процессор">
                        <input type="text" name="min_settings[]" placeholder="Видеокарта">
                    </div>
                    <div>
                        @error('min_settings')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label>максималки</label>
                        <input type="text" name="max_settings[]" placeholder="ОС">
                        <input type="text" name="max_settings[]" placeholder="Процессор">
                        <input type="text" name="max_settings[]" placeholder="Видеокарта">
                    </div>
                    <div>
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                    </div>
                </div>
                <input type="submit">
            </form>
        @else
            <form action="{{ route("post.upload.covers.data") }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Основное изображение</label>
                    <input type="file" name="main">
                </div>
                <div class="form-group">
                    <label>Малое изображение</label>
                    <input type="file" name="small">
                </div>
                <div class="form-group">
                    <label>Заглавное изображение в магазине</label>
                    <input type="file" name="header">
                </div>
                <div class="form-group">
                    <label>Скриншоты</label>
                    <input type="file" multiple name="screen[]">
                </div>
                <div class="form-group">
                    <label>Фон страницы</label>
                    <input type="file" name="background">
                </div>
                {{--            <img src="{{asset('/storage/uploads/AhgZMSpVQ0CEdzTL0YsHsLsLZUkuS2aa2HbKzaqU.jpg')}}">--}}
                <input type="submit">
            </form>
        @endif
    </div>
@endsection
