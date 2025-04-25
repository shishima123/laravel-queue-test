<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class LogEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected User $user)
    {
        $this->onQueue('log');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(0.5);
        Log::info('Mail to: ' . $this->user->email, [$this->user]);
    }

    public function tags(): array
    {
        return ['log'];
    }
}
