@extends('Client.Layouts.index')

@section('content')

    <style>
        .footer {
            position: absolute;
            bottom: 0;
        }
        .message {
            width: 72em;
        }
    </style>

    <div class="message">
        <h1>Ошибка оплаты заказа</h1>
        <h3>Попробуйте оплатить товар повторно или обратитесь в техподдержку по почте danil.dogi007@mail.ru с возникшей проблемой.</h3>
    </div>
@endsection
