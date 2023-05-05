<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Employee\Market\Game;
use Illuminate\Http\Request;

class SearchGameController extends Controller
{
    public function search(Request $request)
    {
        $games = [];
        foreach ($request->all() as $key => $category) {
            $games = Game::where($key, $category)->whereNull('deleted_at')->get();
        }
        $viewLoad = view('Admin.Layouts.games', compact('games'));

        return response()->json(['viewLoad' => $viewLoad->toHtml()]);
    }
}
