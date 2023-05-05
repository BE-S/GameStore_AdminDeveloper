<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Jobs\Market\CartJob;
use App\Models\Client\Market\Game;
use Illuminate\Database\Eloquent\Model;
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
