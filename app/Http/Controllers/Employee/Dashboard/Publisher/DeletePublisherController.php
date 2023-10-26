<?php

namespace App\Http\Controllers\Employee\Dashboard\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Employee\Market\Publisher;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class DeletePublisherController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $publisher = Publisher::findOrFail($request->publisherId);

            if ($publisher->deleted_at) {
                return response()->json([
                    'success' => true
                ]);
            }

            $publisher->delete();

            return response()->json([
                'success' => true
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'errors' => $exception
            ]);
        }
    }
}
