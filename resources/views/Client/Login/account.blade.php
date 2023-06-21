@extends('Client.Layouts.index', [$account = true])

@section('content')
    @include('Client.Layouts.Login.account-data')
    <div class="background block account">
        <div class="account-block">
            <div id="user">
                <div id="avatar">
                    <img src="{{ $user->avatar->path_big }}" width="100%" height="100%">
                </div>
                <h3 class="name">
                    {{ $user->name }}
                </h3>
                <div id="change-account">
                    Изменить профиль
                </div>
            </div>
                <div id="cards">
                    <div class="title">Карты</div>
                    @isset($bankCard)
                        @foreach($bankCard as $card)
                            <div class="bank-card">
                                <div class="number">{{ $card->number }}</div>
                                <div class="image-payment"><img src="{{ $card->paymentSystem->path_image }}" width="61%"></div>
                            </div>
                        @endforeach
                    @endisset
                    <div class="buttons">
                        @if($bankCard->count() > 0)
                            <button class="all">Все карты</button>
                        @endif
                        <button class="add">Добавить карту</button>
                    </div>
                </div>
        </div>
        <div id="history-purchase">
            <div class="title">История покупок</div>
                    @forelse($library as $key => $product)
                        <div class="game">
                            <div class="information">
                                <div class="cover">
                                    <img src="{{ $product->game->gameCover->small }}">
                                </div>
                                <div id="description">
                                    <div class="left">
                                        <div>Название: {{ $product->game->name }}</div>
                                        <div>Дата покупки: {{ $product->created_at ? $product->created_at->format('d.m.Y') : "Недавно" }}</div>
                                    </div>
                                    <div class="right">
                                            <div>Стоимость: {{ $product->game->price . " рублей" }}</div>
                                            <div>Скидка: {{ $product->discount_amount . "%" }}</div>
                                            <div>Сумма:
                                                @if ($product->discount_amount == 0)
                                                    {{ $product->game->price }}
                                                @else
                                                    {{--Переделать этот метод--}}
                                                    {{ $product->calculationDiscount() . " рублей"}}
                                                @endif
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-copy">
                                @foreach($product->purchase->order->keyProducts as $keyProduct)
                                    @if ($keyProduct->game_id == $product->game_id)
                                        <button onclick="copyText('{{ $keyProduct->key_code }}')">
                                            Скопировать ключ
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @empty
                <div>Купите игр</div>
            @endforelse
        </div>
        <div class="copy-text">
            <div class="alert alert-success" role="alert">Ключ скопирован!</div>
        </div>
    </div>
    <script>
        function copyText(keyCode) {
            navigator.clipboard.writeText(keyCode)
                .then(() => {
                    touchAlert()
                    setTimeout(touchAlert, 5000)
                })
                .catch(err => {
                    console.log('Something went wrong', err);
                });
        }
        var alert = document.querySelector('.alert')

        function touchAlert()
        {
            alert.classList.toggle('active')
        }
    </script>
    <form class="card-form">
        <div class="close">
            x
        </div>
        <div id="add-card">
            <div class="block-number">
                <label>Номер</label>
                <input id="number" type="number-card" minlength="18" maxlength="18">
            </div>
            <div class="secret-date">
                <div class="block-expiry">
                    <label>Истекает</label>
                    <input id="expiry" type="expiry" placeholder="xx/xx">
                </div>
                <div class="block-cvc">
                    <label>cvc</label>
                    <input id="cvc" type="cvc" minlength="3" maxlength="3" placeholder="cvc">
                </div>
            </div>
            <div class="button">
                <div id="accept" type="submit">Добавить</div>
            </div>
        </div>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script>
        $(function () {
            const closeButton = document.querySelector('.card-form')

            $("#number").mask("9999 9999 9999 9999");
            $("#expiry").mask("99/99");

            $('.close').bind('click', function (e) {
                closeButton.classList.toggle('active')
            })

            $('.add').bind('click', function (e) {
                closeButton.classList.toggle('active')
            })

            $('#change-account').bind('click', function (e) {
                $('.background.account').toggle('active')
                $('.background.change').toggle('active')
                $('.footer').attr('class', 'footer down')
                $('#basic').attr('class', 'active')
            })

            $('#accept').bind('click', function (e) {
                $.ajax({
                    url: '{{ route('post.add-card') }}',
                    type: "POST",
                    data: {
                        number: $('#number').val(),
                        expiry: $('#expiry').val(),
                        cvc: $('#cvc').val(),
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result["error"]) {
                            alert(result["message"]);
                            return
                        }

                        let buttonAll = document.querySelectorAll(".all")
                        closeButton.classList.toggle('active')
                        createCard(result['number'], result['image'])

                        if (buttonAll.length < 1) {
                            createButtonAllCards()
                        }
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
            })

            function createCard(number, image)
            {
                const cards = document.querySelector('#cards')
                const buttons = document.querySelector('.buttons')

                var divBankCard = document.createElement("div")
                divBankCard.classList.add("bank-card")

                var imageCard = document.createElement("img")
                imageCard.src = '/storage/' + image
                imageCard.style.width = '61%'

                var divImage = document.createElement("div")
                divImage.classList.add("image-payment")

                var divNumber = document.createElement("div")
                divNumber.classList.add("number")
                divNumber.innerHTML = number

                divBankCard.append(divNumber)
                divImage.append(imageCard)
                divBankCard.append(divImage)
                cards.insertBefore(divBankCard, buttons)
            }

            function createButtonAllCards()
            {
                const buttons = document.querySelector('.buttons')

                var buttonAll = document.createElement("button");
                buttonAll.classList.add("all");
                buttonAll.innerHTML = "Все карты"

                buttons.prepend(buttonAll)
            }
        })
    </script>
@endsection
