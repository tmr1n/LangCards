<?php

namespace App\Repositories\ApiLimitRepositories;

use App\Models\ApiLimit;
use Carbon\Carbon;

class ApiLimitRepository implements ApiLimitRepositoryInterface
{
    protected ApiLimit $model;
    public function __construct(ApiLimit $apiLimit)
    {
        $this->model = $apiLimit;
    }
    public function findOrCreateByDate(string $date)
    {
        return $this->model->firstOrCreate(['day' => $date]);
    }

    public function incrementRequestCount(ApiLimit $apiLimit)
    {
        $apiLimit->increment('request_count');
    }

    public function deleteInfoBeforeCurrentDay()
    {
        $this->model->where('day', '<', Carbon::today())->delete();
    }
}
