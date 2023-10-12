<?php

namespace Database\Seeders;

use App\Models\Client\Market\Review\Emoji;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmojiSeeder extends Seeder
{
    private $emojis = [
        "agony",
        "angry",
        "astonisment",
        "astonisment with sadness",
        "cry",
        "cyclops",
        "face",
        "grin",
        "laughter",
        "love",
        "nice",
        "pandemic",
        "poop",
        "sadness",
        "send",
        "sleep",
        "smile",
        "unsmile",
        "very astonisment",
        "wink",
    ];

    private $path = "public/image/icon/emoji/";
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->emojis as $emoji) {
            Emoji::create([
                "name" => $emoji,
                "path" => $this->path . $emoji . ".png",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }
}
