@extends('Client.Layouts.index')

@section('content')
    <style>
        header,
        .footer {
            display: none;
        }

        main {
            margin: 0;
        }

        #block-ban {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-wrap: wrap;
            width: 75em;
        }

        .title {
            font-size: 3em;
            margin-top: 3em;
        }

        .message {
            font-size: 1.3em;
            margin-top: 1em;
            margin-bottom: 2em;
            text-align: center;
        }

        .link-index {
            font-size: 2em;
        }

        .link-index a {
            background-color: rgb(255 255 255 / 40%);
            color: white;
            padding: 0.5em 3em;
        }
    </style>

    <div id="block-ban">
        <div class="title">Ваш аккаунт заблокирован</div>
        <div class="message">Не нарушайте правила, если вы считаете что вас забанили по ошибке, направьте жалобу на нашу почту danil.dogi007@mail.ru</div>
        <div class="link-index">
            <a href="{{ route('get.index') }}">Перейти на главную</a>
        </div>
    </div>
@endsection
