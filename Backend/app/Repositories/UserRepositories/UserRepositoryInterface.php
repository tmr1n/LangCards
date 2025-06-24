<?php

namespace App\Repositories\UserRepositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getInfoUserAccountByEmail($email);

    public function updateCurrencyId(User $user, ?int $currencyId);

    public function updateTimezoneId(User $user, ?int $timezoneId);
}
