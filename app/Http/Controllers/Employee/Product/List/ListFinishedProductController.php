<?php

namespace App\Http\Controllers\Employee\Product\List;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Game;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class ListFinishedProductController extends Controller
{
    protected $product;

    //Все продукты $search = null
    //Продукты с категорией $search = категория
    public function showPage($name)
    {
        try {
            $products = Game::all();

            return view('', $products);
        } catch (Exception $e) {
            echo $e;
        }
    }
}
