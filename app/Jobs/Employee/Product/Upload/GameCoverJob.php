<?php

namespace App\Jobs\Employee\Product\Upload;


use Illuminate\Contracts\Queue\ShouldQueue;

class GameCoverJob implements ShouldQueue
{
    public $url;
    protected $nameGame;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($nameGame)
    {
        $this->url = collect();
        $this->nameGame = $nameGame;
    }

    /**
     * Upload game covers.
     *
     * @return void
     */
    public function uploadCovers($covers)
    {
        $temp = collect();
        foreach ($covers as $key => $cover) {
            $this->putUrl(
                $key, $cover->store('assets/game/'. $this->nameGame, 'public')
            );
        }
    }

    /**
     * Upload game screen.
     *
     * @return void
     */
    public function uploadScreen($screens)
    {
        $temp = array();

        foreach ($screens as $key => $screen) {
            array_push(
                $temp, $screen->store('assets/game/'. $this->nameGame .'/screen', 'public')
            );
        }
        $this->putUrl('screen', $temp);
    }

    protected function putUrl($key, $value)
    {
        $this->url->put($key, $value);
    }
}
