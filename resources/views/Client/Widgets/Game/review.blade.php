<div class="block-text background-color" id="review">
    <div class="main-inscription">Отзывы</div>
    @foreach($reviews as $review)
        <div class="container">
            <div class="review-content">
                <div class="user-review">
                    <img src="{{'/storage/' . $review->user->avatar->path_small }}" alt="Avatar" style="width:90px">
                </div>
                <div class="review-text">
                    <p><span>{{$review->user->name}}. </span>{{ $review->created_at }}</p>
                    <p>{{ $review->review }}</p>
                </div>
            </div>
            <div class="data-preview">
                <div class="emoji">emoji</div>
            </div>
        </div>
    @endforeach
</div>
