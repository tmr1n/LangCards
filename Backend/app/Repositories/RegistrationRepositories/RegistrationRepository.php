<?php

namespace App\Repositories\RegistrationRepositories;

use App\Models\User;

class RegistrationRepository implements RegistrationRepositoryInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function registerUser(string $name, string $email, ?string $password, ?int $timezone_id, ?int $currency_id): void
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->timezone_id = $timezone_id;
        $user->currency_id = $currency_id;
        $user->save();
    }
}
