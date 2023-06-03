<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Market\CreateReviewRequest;
use App\Models\Client\Market\Review;
use Illuminate\Http\Request;

class CreateReview extends Controller
{
    public function review(CreateReviewRequest $request)
    {
        $credentials = $request->validated();
        $reviewModel = new Review();
        $review = isset($credentials['reviewId']) ? $reviewModel->find($credentials['reviewId']) : null;
        $review ? $review->updateReview() : $reviewModel->createdReview($credentials);

        return response()->json([
            'success' => true,
            'message' => $reviewModel->find($review->id)
        ]);
    }
}
