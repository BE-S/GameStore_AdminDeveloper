<?php

namespace App\Jobs\Email;

use App\Mail\KeyProductMail;
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
    protected $key_code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $key_code)
    {
        $this->email = $email;
        $this->key_code = $key_code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new KeyProductMail($this->key_code));
    }
}
