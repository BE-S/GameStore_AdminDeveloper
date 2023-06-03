@extends('Admin.Layouts.admin-panel', ['title' => 'Покупки'])

@section('content')

    <table class="table table-hover">
        <thead>
        <tr>
            <th class="title" scope="col">Ид покупки</th>
            <th class="title" scope="col">Ид пользователя</th>
            <th class="title" scope="col">Ид заказа</th>
            <th class="title" scope="col">Оплаченная сумма</th>
            <th class="title" scope="col">Дата покупки</th>
        </tr>
        </thead>
        <tbody>
        @foreach($purchasedGames as $purchasedGame)
            <tr class="href-purchased" data-href="{{ route('get.dashboard.purchase.game', $purchasedGame->id) }}">
                <th scope="row">{{ $purchasedGame->id }}</th>
                <td>{{ $purchasedGame->user_id }}</td>
                <td>{{ $purchasedGame->merchant_order_id }}</td>
                <td>{{ $purchasedGame->amount_payment }}</td>
                <td>{{ $purchasedGame->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <script>
        jQuery(document).ready(function($) {
            $(".href-purchased").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>

@endsection
