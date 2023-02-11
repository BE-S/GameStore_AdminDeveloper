<?php

namespace App\Http\Controllers\Employee\Product\List;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Game;
use App\Models\Client\Market\GameCover;
use Illuminate\Http\Request;
use Psr\Container\NotFoundExceptionInterface;

class ListUnfinishedProductController extends Controller
{
    //Продукты требующие догрузки скринов для страницы
    public function showPage($search = null)
    {
        try {
            if (is_null($search)) {
                $result = GameCover::whereNotNull('job_hash')->get();
                foreach ($result as $item) {
                    dd($item->joinGame);
                }
            } else {
                $result = Game::where('name', $search)->get();
                foreach ($result as $item) {
                    dd($item->joinGameCover);
                }
            }
        } catch (NotFoundExceptionInterface $e) {
            echo $e;
        }
    }
}
