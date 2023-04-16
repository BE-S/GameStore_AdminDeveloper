<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RedirectJob implements ShouldQueue
{

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function redirectPastUrl() :string
    {
        $url =  empty(session("paste_url")) ? route("get.index") : session("paste_url");
        session()->put("paste_url", "");

        return $url;
    }

    public function redirectGetRequest($url, $param = array())
    {
        if ($param) {
            return $url . '?' . http_build_query($param);
        }
        return $url;
    }
}
