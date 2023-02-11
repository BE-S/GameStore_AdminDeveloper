<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <title>Bootstrap Example</title>

    <link rel="stylesheet" href="/css/client/index.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
    <body>
        <header>
            <div id="search-field">
                <input type="text" placeholder="Поиск">
            </div>
            <nav id="navigation">
                <div id="left">
                    <span>Каталог</span>
                    <span>Категории</span>
                </div>
                <div id="right">
                    <span>
                        <img src="http://localhost:8080/image/icon/rus.png" class="icon">
                        Rub
                    </span>
                    <span>
                        <img src="http://localhost:8080/image/icon/cart.png" class="icon">
                        0
                    </span>
                </div>
            </nav>
        </header>
        <main>
            @yield('content')
        </main>
    </body>
</html>
