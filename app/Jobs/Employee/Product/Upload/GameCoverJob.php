<?php

namespace App\Jobs\Employee\Product\Upload;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
                $key, config('filesystems.path.localhost') . $cover->store('assets/game/'. $this->nameGame, 'public')
            );
        }
    }

    /**
     * Upload game cover.
     *
     * @return void
     */
    public function uploadCover($cover) : string
    {
        return config('filesystems.path.localhost') . $cover->store('assets/game/'. $this->nameGame, 'public');
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
                $temp,  config('filesystems.path.localhost') . $screen->store('assets/game/'. $this->nameGame .'/screen', 'public')
            );
        }
        $this->putUrl('screen', $temp);
    }

    public function deleteCover($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    public function deleteCovers($paths)
    {
        foreach ($paths as $path) {
            $this->deleteCover(Str::after($path,  config('filesystems.path.localhost')));
        }
    }

    protected function putUrl($key, $value)
    {
        $this->url->put($key, $value);
    }
}
