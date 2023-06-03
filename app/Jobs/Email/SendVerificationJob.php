<?php

namespace App\Jobs\Email;

use App\Mail\Verification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendVerificationJob implements ShouldQueue
{
    protected $email;
    protected $jobHash;
    protected $nameView;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $jobHash, $nameView)
    {
        $this->email = $email;
        $this->jobHash = $jobHash;
        $this->nameView = $nameView;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new Verification($this->jobHash, $this->nameView));
    }
}
