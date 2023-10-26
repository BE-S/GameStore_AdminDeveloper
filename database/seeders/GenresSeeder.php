<?php

namespace Database\Seeders;

use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\Genres;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenresSeeder extends Seeder
{
    private $genres = [
        "Шутер",
        "Стратегия",
        "Выживание",
        "Головоломка",
        "Гачи трейдинг",
        "Экшен",
        "Квест",
        "RPG",
        "Симулятор",
        "Казуал",
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->genres as $genre) {
            Genres::create([
                "name" => $genre,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }
}
