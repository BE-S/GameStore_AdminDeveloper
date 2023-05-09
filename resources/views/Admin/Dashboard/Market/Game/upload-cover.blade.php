@extends('Admin.Layouts.admin-panel')

@section('content')
    @include('Admin.Layouts.input-cover')

<script>
    $(function () {
        $('#game-cover').bind('click', function (e) {
            e.preventDefault();
            var formData = new FormData($('form')[0])
            var gameId = {{ isset($game) ? $game->id : null }}
            formData.append('gameId', gameId)

            $.ajax({
                url: '{{ route('post.dashboard.upload.game.cover.loading') }}',
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    console.log(result)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var errors = jqXHR.responseJSON.errors;

                    if (typeof errors['gameId'] !== 'undefined') {
                        console.log('11')
                    }
                    if (typeof errors['small'] !== 'undefined') {
                        console.log('12')
                    }
                    if (typeof errors['header'] !== 'undefined') {
                        console.log('13')
                    }
                    if (typeof errors['poster'] !== 'undefined') {
                        console.log('14')
                    }
                    if (typeof errors['screen'] !== 'undefined') {
                        console.log('15')
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
        });
    });
</script>
@endsection
