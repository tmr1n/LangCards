<?php

namespace App\Repositories\PromocodeRepositories;

use App\Models\Promocode;

class PromocodeRepository implements PromocodeRepositoryInterface
{
    protected Promocode $model;

    public function __construct(Promocode $model)
    {
        $this->model = $model;
    }

    public function isExistPromocode(string $code): bool
    {
        return $this->model->where('code','=', $code)->exists();
    }

    public function saveNewPromocode(string $code, int $tariff_id): void
    {
        $newPromocode = new Promocode();
        $newPromocode->code = $code;
        $newPromocode->tariff_id = $tariff_id;
        $newPromocode->save();
    }

    public function getPromocodeByCode(string $code): ?Promocode
    {
        return $this->model->with(['tariff'])->where('code','=', $code)->first();
    }

    public function deactivatePromocodeByCode(string $code)
    {
        $this->model->where('code', $code)->update([
            'active' => false
        ]);
    }

    public function deactivatePromocodeByPromocode(Promocode $promocode)
    {
        $promocode->active = false;
        $promocode->save();
    }
}
