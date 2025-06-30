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

    public function updateCurrencyIdByIdUser(int $userId, ?int $currencyId)
    {
        $this->model->where('id', $userId)->update([
            'currency_id' => $currencyId
        ]);
    }

    public function updateTimezoneIdByIdUser(int $userId, ?int $timezoneId)
    {
        $this->model->where('id', $userId)->update([
            'timezone_id' => $timezoneId
        ]);
    }

    public function isExistPasswordAccount(string $email): bool
    {
        $user = $this->model->where('email', $email)->select(['password'])->first();
        return $user->password !== null;
    }

    public function getDateOfEndVipStatusByIdUser(int $idUser)
    {
        return $this->model->where('id', '=', $idUser)->first()->vip_status_time_end;
    }

    public function getInfoAboutUsersForHistoryPurchaseSeeder()
    {
        return $this->model->select(['id', 'currency_id', 'vip_status_time_end'])->get();
    }

    public function updateEndDateOfVipStatusByIdUser(int $idUser, string $endDate): bool
    {
        return $this->model
                ->where('id', '=', $idUser)
                ->update(['vip_status_time_end' => $endDate]) > 0;
    }
}
