<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Market\ReviewRequest;
use App\Models\Client\Market\Review;
use Illuminate\Validation\ValidationException;
use PHPUnit\Exception;

class ReviewController extends Controller
{
    public function publish(ReviewRequest $request)
    {
        try {
            $review = new Review();
            $review->create([
                'user_id' => auth()->user()->id,
                'game_id' => $request->gameId,
                'review' => $request->review,
                'grade' => true,
            ]);
            return response()->json(['success' => 'Отзыв опубликован']);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => $exception->validator->errors()->all()
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'error' => 'Ошибка сервера'
            ]);
        }
    }
}
