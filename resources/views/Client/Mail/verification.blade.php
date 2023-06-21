<style>
    .background {
        background-image: url("https://xn--80affc8aioghc.xn--p1ai//public/image/background/background_default.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        color: white;
        font-family: 'Ubuntu', sans-serif;
        letter-spacing: 0.05vw;
    }

    .confirmation-block {
        width: 100%;
        text-align: center;
        padding: 20em 0px;
    }
</style>

<div class="background">
    <table class="confirmation-block">
        <tr>
            <td>
                <a class="button" href="{{ route($nameView, $jobHash) }}" style="color: white; background: #ffffff38; font-size: 2vw; padding: 1em 3em; border-radius: 1em; text-decoration: none">
                    Подтвердить
                </a>
            </td>
        </tr>
    </table>
</div>
