<!DOCTYPE html>
<html>
    <head>
        <title>Laravel 9 Send Email Example</title>
        <link rel="stylesheet" href="/css/client/mail.css">
    </head>
    <body>
        <div>
            @foreach($games as $key => $game)
                <div>
                    {{ $game->name }}
                </div>
                <div>
                    {{ $keyCode[$key] }}
                </div>
            @endforeach
        </div>
    </body>
</html>
