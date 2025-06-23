<?php

namespace App\Repositories\RegistrationRepositories;

interface RegistrationRepositoryInterface
{
    public function registerUser(string $name, string $email, ?string $password, ?int $timezone_id, ?int $currency_id);
}
