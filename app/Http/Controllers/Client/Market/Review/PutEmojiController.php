<?php

namespace App\Http\Controllers\Client\Market\Review;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Review\Emoji;
use App\Models\Client\Market\Review\ReviewEmoji;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PutEmojiController extends Controller
{
    public function putEmoji(Request $request)
    {
        try {
            $review = Review::findOrFail($request->reviewId);
            $emoji = Emoji::findOrFail($request->emojiId);
            $reviewEmoji = ReviewEmoji::where('review_id', $review->id)->where('user_id', Auth::user()->id)->whereNull('deleted_at')->first();

            if ($reviewEmoji) {
                $reviewEmoji->update([
                   'deleted_at' => Carbon::now()
                ]);
            }
            if (isset($reviewEmoji->emoji_id) && $reviewEmoji->emoji_id == $emoji->id) {
                return response()->json([
                    'success' => true,
                    'num' => count(ReviewEmoji::where('review_id', $review->id)->where('emoji_id', $emoji->id)->whereNull('deleted_at')->get())
                ]);
            }

            ReviewEmoji::create([
                'user_id' => Auth::user()->id,
                'review_id' => $review->id,
                'emoji_id' => $emoji->id,
            ]);

            return response()->json([
                'success' => true,
                'path' => $emoji->path,
                'num' => $review->reviewEmojiCount->pluck('num')[0] ?? 0,
                'previous' => $reviewEmoji->emoji_id ?? null,
            ]);
        } catch (ValidationException $exception) {
            return response()->json(['error' => $exception->validator->errors()->all()]);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
