<?php

namespace App\Models\Client\Market\Catalog;

use App\Models\Client\Market\Category;
use App\Models\Client\Market\Game;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedCategory extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function getExistenceId($id)
    {
        $categories = Category::all();
        $maxId = $categories->max("id");

        for ($id; $id <= $maxId; ++$id) {
            $category = $categories->find($id);
            if (!$category) {
                continue;
            }
            $recommendedCategory = RecommendedCategory::where("category_id", $id)->limit(7)->get();
            if ($recommendedCategory->isEmpty() || $recommendedCategory->count() < 7) {
                continue;
            }
            return $id;
        }
    }
}
