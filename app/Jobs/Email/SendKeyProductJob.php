<?php

namespace App\Jobs\Email;

use App\Mail\KeyProductMail;
use Illuminate\Bus\Queueable;
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
    protected $amount;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $keyCode, $games, $amount)
    {
        $this->email = $email;
        $this->keyCode = $keyCode;
        $this->games = $games;
        $this->amount = $amount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new KeyProductMail($this->keyCode, $this->games, $this->amount));
    }
}
