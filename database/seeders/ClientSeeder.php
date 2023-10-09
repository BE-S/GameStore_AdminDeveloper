<?php

namespace Database\Seeders;

use App\Helpers\HashHelper;
use App\Models\Client\Login\Avatar;
use App\Models\Client\Login\Cart;
use App\Models\Client\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            "name" => "The pidorasus",
            "email" => "danil.dogi007.danil@mail.ru",
            "email_verified_at" => Carbon::now(),
            "password" => HashHelper::generateHashPass("333999"),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        Avatar::create([
            "user_id" => $user->id,
            "path_small" => "assets/avatar/default_small.png",
            "path_big" => "assets/avatar/default_big.png",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        Cart::create([
            "user_id" => $user->id,
            "games_id" => [],
        ]);
    }
}
