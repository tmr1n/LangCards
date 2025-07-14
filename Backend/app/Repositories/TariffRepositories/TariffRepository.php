<?php

namespace App\Repositories\TariffRepositories;

use App\Models\Tariff;
use Illuminate\Database\Eloquent\Collection;

class TariffRepository implements TariffRepositoryInterface
{
    protected Tariff $model;

    public function __construct(Tariff $model)
    {
        $this->model = $model;
    }


    public function saveNewTariff(string $name, int $days, bool $statusActive): void
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

    public function getActiveTariffsForUserCurrency(int $userCurrencyId): Collection
    {
        return $this->model->where('is_active', true)
            ->whereHas('costs', function ($query) use ($userCurrencyId) {
                $query->where('is_active', true)
                    ->whereHas('currency', function ($q) use ($userCurrencyId) {
                        $q->where('id', $userCurrencyId);
                    });
            })
            ->with(['costs' => function ($query) use ($userCurrencyId) {
                $query->where('is_active', true)
                    ->whereHas('currency', function ($q) use ($userCurrencyId) {
                        $q->where('id', $userCurrencyId);
                    })
                    ->with(['currency' => function ($q) use ($userCurrencyId) {
                        $q->where('id', $userCurrencyId);
                    }]);
            }])
            ->get();
    }

    public function getAllActiveTariffs()
    {
        return $this->model
            ->where('is_active', '=', true)
            ->whereHas('costs', function ($query) {
                $query->where('is_active', true);
            })
            ->with(['costs' => function ($query)
            {
                $query->where('is_active', true)->with(['currency']);
            }])
            ->get();
    }
}
