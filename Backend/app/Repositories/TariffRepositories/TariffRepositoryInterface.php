<?php

namespace App\Repositories\TariffRepositories;

interface TariffRepositoryInterface
{
    public function saveNewTariff(string $name, int $days, bool $statusActive);

    public function isExistTariff(string $name, int $days);
}
