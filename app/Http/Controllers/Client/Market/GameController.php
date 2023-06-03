<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Game;
use App\Models\Client\Market\GameDescription;
use App\Models\Item;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index($id)
    {
        $game = Game::find($id);

        return view('Client.Market.game', compact('game'));
    }

    public function test(Request $request)
    {
        $path = $request->file('main')->store('assets/game', 'public');

        return view('Client.Market.game', compact('path'));
    }
}

/*
    $input = [
            'game_id' => 1,
            'description' => 'Demo Title',
            'min_settings' => [
                'OS' => 'Windows 7 64-bit',
                'CPU' => 'Intel core 5',
                'Video card' => 'GTX 1050 ti'
            ],
            'max_settings' => [
                'OS' => 'Windows 10 64-bit',
                'CPU' => 'Intel core 7',
                'Video card' => 'GTX 1070 ti'
            ]
        ];

        $item = GameDescription::create($input);

transform: translateY(0%);
    position: relative;
    display: block;
    overflow: hidden;
*/
