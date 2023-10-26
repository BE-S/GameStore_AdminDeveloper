<?php

namespace App\Models\Client\Market\Catalog;

use App\Models\Client\Market\Product\Genres;
use App\Models\Client\Market\Product\Game;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedGenre extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function getExistenceId($id)
    {
        $categories = Genres::all();
        $maxId = $categories->max("id");

        for ($id; $id <= $maxId; ++$id) {
            $category = $categories->find($id);
            if (!$category) {
                continue;
            }
            $recommendedCategory = RecommendedGenre::where("genre_id", $id)->limit(7)->get();
            if ($recommendedCategory->isEmpty() || $recommendedCategory->count() < 7) {
                continue;
            }
            return $id;
        }
    }
}
