<?php

namespace App\Repositories\ApiLimitRepositories;

use App\Models\ApiLimit;
use Carbon\Carbon;

class ApiLimitRepository implements ApiLimitRepositoryInterface
{
    protected ApiLimit $apiLimit;
    public function __construct(ApiLimit $apiLimit)
    {
        $this->apiLimit = $apiLimit;
    }
    public function findOrCreateByDate(string $date)
    {
        return $this->apiLimit->firstOrCreate(['day' => $date]);
    }

    public function incrementRequestCount(ApiLimit $apiLimit)
    {
        $apiLimit->increment('request_count');
    }

    public function deleteInfoBeforeCurrentDay()
    {
        $this->where('day', '<', Carbon::today())->delete();
    }
}
