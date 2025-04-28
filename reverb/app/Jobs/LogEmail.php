<?php

namespace App\Jobs;

use App\Events\MailLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class LogEmail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected array $userData)
    {
        $this->onQueue('log');
    }

    public function handle()
    {
        Log::info('Application B: Processing user data', ['userData' => $this->userData]);
        event(new MailLog($this->userData));
    }
}
