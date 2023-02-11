<?php

namespace App\Jobs\Employee\Product\Upload;

use App\Models\Client\Market\Game;
use App\Models\Client\Market\GameCover;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GameDescriptionJob implements ShouldQueue
{
    protected $credentials;

    /**
     * Create a new job instance.
     *
     * @param $credentials object
     * @return void
     */
    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Check if the game exists
     *
     * @return object
     */
    public function checkGame()
    {
        return Game::where('name', $this->credentials['name'])->first();
    }

    /**
     * Create new entry in DB games.
     *
     * @return object
     */
    public function createGame()
    {
        return Game::create([
            'name' => $this->credentials['name'],
            'price' => $this->credentials['price'],
            'description' => $this->credentials['description'],
            'max_settings' => $this->credentials['max_settings'],
            'min_settings' => $this->credentials['min_settings'],
            'developer_id' => 1,
            'published_id' => 1,
        ]);
    }

    public function createHashCover($game_id)
    {
        return GameCover::create([
            'game_id' => $game_id,
            'job_hash' => md5(mt_rand(32, 60)),
        ]);
    }
}
