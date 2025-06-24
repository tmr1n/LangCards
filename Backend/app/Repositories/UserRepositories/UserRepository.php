<?php

namespace App\Repositories\UserRepositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected User $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }
    public function getInfoUserAccountByEmail($email): ?User
    {
        return $this->model->where('email', $email)->select(['id', 'name', 'email', 'type_user', 'currency_id', 'timezone_id','vip_status_time_end'])->first();
    }

    public function updateCurrencyId(User $user, ?int $currencyId): void
    {
        $user->currency_id = $currencyId;
        $user->save();
    }

    public function updateTimezoneId(User $user, ?int $timezoneId): void
    {
        $user->timezone_id = $timezoneId;
        $user->save();
    }
}
