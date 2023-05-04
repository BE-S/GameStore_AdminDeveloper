@extends('Admin.Layouts.index')

@section('content')
    <div id="list-games">
        <div class="categories">
            <label id="category-published">
                <label for="radio-1" class="radio-label">
                    <input type="radio" id="published" name="published" value="true">
                    <span class="radio"></span>
                    <span class="text">Опубликованые</span>
                </label>
                <label for="radio-1" class="radio-label">
                    <input type="radio" id="published" name="published" value="false">
                    <span class="radio"></span>
                    <span class="text">Не опубликованые</span>
                </label>
            </label>
        </div>
    </div>
        <div class="collection-games">
            @include('Admin.Layouts.games')
        </div>
    </div>
    <script>
        $(function () {
            const buttons = document.querySelectorAll('#published');
            buttons.forEach(button => {
                button.addEventListener('click', sendCategory);
            });

            function sendCategory() {
                $.ajax({
                    url: '{{ route("post.dashboard.games.search") }}',
                    type: "POST",
                    data: {
                        is_published: getCategoryPublished()
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        $('.game').remove()
                        $('.collection-games').append(result['viewLoad'])
                        console.log(result)
                    },
                    statusCode: {
                        401: function (err) {
                            console.log(err)
                        },
                        500: function (err) {
                            console.log(err)
                        }
                    }
                })
            }

            function getCategoryPublished()
            {
                var published = document.getElementsByName('published');
                for (let i = 0; i <= 1; ++i) {
                    if (published[i].checked) {
                        published = published[i].value
                    }
                }
                return published
            }
        })
    </script>
@endsection
