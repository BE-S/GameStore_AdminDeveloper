@foreach ($review->reviewEmojiCount as $reviewEmoji)
    <a class="block-emoji {{ $reviewEmoji->emoji->id }}" href="javascript:putReview({{ $review->id }}, {{ $reviewEmoji->emoji->id }});">
        <img src="{{ $reviewEmoji->emoji->path }}">
        <p class="count-emoji">{{ $reviewEmoji->count }}</p>
    </a>
@endforeach
