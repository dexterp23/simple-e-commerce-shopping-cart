<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LowStockNotificationJob implements ShouldQueue
{
    use Queueable;

    public $tries = 5;
    public $timeout = 60;
    public $backoff = 10;

    protected int $productId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        app('LowStockNotificationService')->handle($this->productId);
    }
}
