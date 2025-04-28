<?php

namespace App\Jobs;

use App\Models\User;
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

    public function handle(): void
    {
        \Log::info('Application A: Pushed user data to queue', ['userData' => $this->userData]);
    }

    public function tags(): array
    {
        return ['log'];
    }
}
