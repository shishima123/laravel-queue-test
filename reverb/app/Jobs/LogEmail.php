<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LogEmail implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('log');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo 'reverb';
    }
}
