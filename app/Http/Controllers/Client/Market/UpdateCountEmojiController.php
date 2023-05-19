<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Emoji;
use App\Models\Client\Market\Review;
use Illuminate\Http\Request;

class UpdateCountEmojiController extends Controller
{
    public function updateEmoji(Request $request)
    {
        $emoji = [];
        $reviews = Review::whereIn('id', $request->reviewId)->get();

        foreach ($reviews as $review) {
            if (count($review->reviewEmojiCount) > 0) {
                foreach ($review->reviewEmojiCount as $key => $valueEmoji) {
                    $emojiId = $review->reviewEmojiCount[$key]['emoji_id'];
                    $review->reviewEmojiCount[$key]['path'] = Emoji::find($emojiId)->path;
                }
            }
            $emoji[$review->id] = $review->reviewEmojiCount;
        }

        return response()->json([
            'success' => true,
            'countEmoji' => $emoji
        ]);
    }
}
