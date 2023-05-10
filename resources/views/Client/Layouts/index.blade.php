<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <title>Bootstrap Example</title>

    <link rel="stylesheet" href="/css/client/index.css">
    <link rel="stylesheet" href="/css/client/adaptive/index-adaptive.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
    <body>
        <header>
            <nav id="navigation">
                <div class="index">
                    <div id="search-field">
                        <input id="insertedSpace" type="text" autocomplete="off" placeholder="Поиск">
                        <div id="search-result"></div>
                    </div>
                        <div id="links">
                            <div class="left">
                                <a href="{{ route("get.index") }}">Каталог</a>
                                <a>Категории</a>
                            </div>
                            <div class="right">
                                <span>
                                    <img src="http://localhost:8080/image/icon/rus.png" class="icon">
                                    Rub
                                </span>
                                <span>
                                    <a href="{{ route("get.cart") }}">
                                        <img src="http://localhost:8080/image/icon/cart.png" class="icon">
                                        <span id="count-games">{{ isset($countCart) ? $countCart : 0 }}</span>
                                    </a>
                                </span>
                            </div>
                        </div>

                </div>
                @auth()
                    @if (url()->current() != route('get.account'))
                        <div class="nav-account">
                            <a id="account" href="{{ route("get.account") }}">
                                <img class="image" src="{{ asset('/storage/' . $account->avatar->path_small) }}">
                                <div>{{ $account->name }}</div>
                                <li class="nav-item dropdown">
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" href="{{ route('get.logout') }}">Выйти</a>
                                    </div>
                                </li>
                            </a>
                    @endif
                @endauth
                @guest()
                    @if (url()->current() != route('get.sig-up') && url()->current() != route('get.sig-in'))
                        <a href="{{ route("get.sig-in") }}">Авторизация</a>
                    @endif
                @endguest
            </nav>
        </header>
        <main>
            @yield('content')
        </main>
    </body>
    <footer class="footer">
        <div class="links">
            <div class="social-network">
                <a href="https://vk.com/"><img src="http://localhost:8080/image/icon/Social%20network/VK.png"></a>
                <a href="https://web.telegram.org/"><img src="http://localhost:8080/image/icon/Social%20network/telegram.png"></a>
                <a href="https://twitter.com/"><img src="http://localhost:8080/image/icon/Social%20network/twitter.png"></a>
                <a href="https://www.instagram.com/"><img src="http://localhost:8080/image/icon/Social%20network/instagram.png"></a>
            </div>
            <div class="up">Вверх</div>
        </div>
        <div class="author">Made by BES</div>
        <div class="purchases">
            <span>
                <a>
                    <img src="http://localhost:8080/image/icon/rus.png" class="icon">
                    <span id="currency">Rub</span>
                </a>
            </span>
            <span>
                <a href="{{ route("get.cart") }}">
                    <img src="http://localhost:8080/image/icon/cart.png" class="icon">
                    <span id="count-games">{{ empty(session()->get('Cart')) ? 0 : count(session()->get('Cart')) }}</span>
                </a>
            </span>
        </div>
    </footer>
    <script>
        $(function ()
        {
            $('input').keydown(function(e) {
                if(e.keyCode === 13) {
                    let name = $('#insertedSpace').val()
                    location = 'http://localhost:8080/search/' + name
                }
            });

            $('body').on('change', function(event) {
                console.log(event.target)
                if (!$(event.target).is('#search-result')) {
                    $('#search-result').css('display', 'none')
                    $('#search-result').empty()
                }
                if ($(event.target).is('#insertedSpace')) {
                    $('#search-result').css('display', 'flex')
                }
            });

            $("#insertedSpace").keyup(function (e) {
                let name = $('#insertedSpace').val()

                if (name.length <= 0) {
                    $('#search-result').css('display', 'none')
                }

                if (name.length > 0) {
                    let last = name.length - 1

                    if (name[last].charCodeAt(0) < 49 && name[last].charCodeAt(0) > 57) {
                        return;
                    }

                    if (name[last].charCodeAt(0) < 97 && name[last].charCodeAt(0) > 122
                        || name[last].charCodeAt(0) < 1072 && name[last].charCodeAt(0) > 1103) {
                        return;
                    }

                    e.preventDefault();

                    $.ajax({
                        url: '{{ route('post.search') }}',
                        type: "POST",
                        data: {
                            query: $('#insertedSpace').val(),
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            if ($('#search-result')) {
                                $('#search-result').empty()
                            }
                            $('#search-result').append(result['viewLoad'])
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
            })
        })
    </script>
</html>
