<?php

namespace App\Repositories\ApiLimitRepositories;

use App\Models\ApiLimit;

interface ApiLimitRepositoryInterface
{
    public function findOrCreateByDate(string $date);

    public function incrementRequestCount(ApiLimit $apiLimit);

    public function deleteInfoBeforeCurrentDay();
}
