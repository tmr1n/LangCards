<?php

namespace App\Repositories\TimezoneRepositories;

use App\Models\Timezone;

interface TimezoneRepositoryInterface
{
    public function isExistRepositoryByNameRegion(string $nameRegion): bool;
    public function getRepositoryByNameRegion(string $nameRegion): ?Timezone;
    public function getRepositoryById(int $id): ?Timezone;

    public function saveNewTimezone(string $nameRegion, string $offset_UTC);
}
