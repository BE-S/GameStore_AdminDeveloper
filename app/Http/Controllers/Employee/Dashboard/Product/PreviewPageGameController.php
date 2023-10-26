<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Product\Game;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PreviewPageGameController extends Controller
{
    public function getPage(Request $request)
    {
        try {
            $credentials = $request->validate([
                'gameId' => 'required|integer'
            ]);
            $game = Game::findOrFail($credentials['gameId']);

            $loadView = view("Admin.Dashboard.Widgets.preview", compact('game'));
            return response()->json(['loadView' => $loadView->toHtml()]);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }
}
