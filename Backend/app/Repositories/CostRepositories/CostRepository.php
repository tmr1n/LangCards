<?php

namespace App\Repositories\CostRepositories;

use App\Models\Cost;

class CostRepository implements CostRepositoryInterface
{
    protected Cost $model;

    public function __construct(Cost $model)
    {
        $this->model = $model;
    }

    public function isExistByTariffIdAndCurrencyId(int $tariffId, int $currencyId)
    {
        return $this->model->where('tariff_id','=', $tariffId)->where('currency_id','=',$currencyId)->exists();
    }

    public function saveNewCost(float $cost, int $tariffId, int $currencyId)
    {
        $newCost = new Cost();
        $newCost->cost = $cost;
        $newCost->currency_id = $currencyId;
        $newCost->tariff_id = $tariffId;
        $newCost->save();
    }
}
