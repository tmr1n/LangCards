<?php

namespace App\Repositories\TimezoneRepositories;

use App\Models\Timezone;

class TimezoneRepository implements TimezoneRepositoryInterface
{
    protected TimeZone $model;

    public function __construct(TimeZone $model)
    {
        $this->model = $model;
    }

    public function isExistRepositoryByNameRegion(string $nameRegion): bool
    {
        return $this->model->where('name', '=', $nameRegion)->exists();
    }

    public function getRepositoryByNameRegion(string $nameRegion): ?Timezone
    {
        return $this->model->where('name', '=', $nameRegion)->first();
    }

    public function getRepositoryById(int $id): ?Timezone
    {
        return $this->model->where('id', '=', $id)->first();
    }

    public function saveNewTimezone(string $nameRegion, string $offset_UTC): void
    {
        $newTimezone = new Timezone();
        $newTimezone->name = $nameRegion;
        $newTimezone->offset_utc = $offset_UTC;
        $newTimezone->save();
    }
}
