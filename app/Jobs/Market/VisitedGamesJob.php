<?php

namespace App\Jobs\Market;

use App\Models\Client\Login\VisitedGame;
use Illuminate\Contracts\Queue\ShouldQueue;

class VisitedGamesJob implements ShouldQueue
{
     /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function recordVisit($gameId)
    {
        $visitedGame = new VisitedGame();
        $visitUser = $visitedGame->getVisit($gameId);

        if ($visitUser) {
            $visits = $visitUser->visit;
            $count = 0;

            foreach ($visits as $key => $visit) {
                if ($visit['game_id'] == $gameId) {
                    ++$visits[$key]['count'];
                    ++$count;
                }
            }
            if ($count == 0) {
                array_push($visits, ['game_id' => $gameId, 'count' => 1]);
            }
            $visitUser->change($visits);
        } else {
            $visitedGame->add($gameId);
        }
    }
}
