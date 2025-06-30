<?php

namespace App\Repositories\TariffRepositories;

use App\Models\Tariff;

class TariffRepository implements TariffRepositoryInterface
{
    protected Tariff $model;

    public function __construct(Tariff $model)
    {
        $this->model = $model;
    }


    public function saveNewTariff(string $name, int $days, bool $statusActive)
    {
        $newTariff = new Tariff();
        $newTariff->name = $name;
        $newTariff->days = $days;
        $newTariff->is_active = $statusActive;
        $newTariff->save();
    }

    public function isExistTariff(string $name, int $days)
    {
        return $this->model->where('name', '=', $name)->where('days', '=', $days)->exists();
    }

    public function getAllIdTariffs()
    {
        return $this->model->pluck('id')->toArray();
    }
}
