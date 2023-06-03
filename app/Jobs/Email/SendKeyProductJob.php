<?php

namespace App\Jobs\Email;

use App\Mail\KeyProductMail;
use App\Models\Client\Market\Game;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendKeyProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $keyCode;
    protected $games;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $keyCode, $gameId)
    {
        $this->email = $email;
        $this->keyCode = $keyCode;
        $this->games = Game::whereIn("id", $gameId)->get();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new KeyProductMail($this->keyCode, $this->games));
    }
}
