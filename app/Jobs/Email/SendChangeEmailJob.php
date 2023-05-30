<?php

namespace App\Jobs\Email;

use App\Mail\ChangeEmail;
use App\Mail\Verification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendChangeEmailJob implements ShouldQueue
{
    protected $email;
    protected $jobHash;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $jobHash)
    {
        $this->email = $email;
        $this->jobHash = $jobHash;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new ChangeEmail($this->jobHash, $this->email));
    }
}
