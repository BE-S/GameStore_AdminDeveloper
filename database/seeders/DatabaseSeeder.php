<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Client\Market\Product\Genres;
use App\Models\Client\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            ClientSeeder::class,
            GenresSeeder::class,
            GameSeeder::class,
            GameCoverSeeder::class,
            SystemPaymentsSeeder::class,
            EmojiSeeder::class,
            RecommendedGamesSeeder::class,
            KeyProductSeeder::class,
            DiscountsSeeder::class,
            OrderSeeder::class,
            PurchasedGamesSeeder::class,
            LibrarySeeder::class
        ]);
    }
}
