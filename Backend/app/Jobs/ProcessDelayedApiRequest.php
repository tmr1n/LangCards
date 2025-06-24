<?php

namespace App\Jobs;

use App\Enums\TypeRequestApi;
use App\Services\ApiServices\ApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDelayedApiRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $ipAddress;
    protected TypeRequestApi $typeRequest;
    protected int $userId;
    /**
     * Create a new job instance.
     */
    public function __construct(string $ipAddress,int $userId, TypeRequestApi $typeRequest)
    {
        $this->ipAddress = $ipAddress;
        $this->userId = $userId;
        $this->typeRequest = $typeRequest;
    }

    /**
     * Execute the job.
     */
    public function handle(ApiService $apiService): void
    {
        $apiService->makeRequest($this->ipAddress, $this->userId, $this->typeRequest);
    }
}
