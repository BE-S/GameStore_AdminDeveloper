<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Emoji;
use App\Models\Client\Market\Review;
use App\Models\Client\Market\ReviewEmoji;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
                    'count' => $review->reviewEmoji->pluck('count')
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
                'count' => $review->reviewEmojiCount->pluck('count'),
                'previous' => $reviewEmoji->emoji_id ?? null,
            ]);
        } catch (ValidationException $exception) {
            return response()->json(['error' => $exception->validator->errors()->all()]);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
