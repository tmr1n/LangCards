<?php

namespace Database\Seeders;

use App\Repositories\RegistrationRepositories\RegistrationRepositoryInterface;
use App\Repositories\UserRepositories\UserRepositoryInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected RegistrationRepositoryInterface $registrationRepository;

    public function __construct(RegistrationRepositoryInterface $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'chinyonov_vlad',
                'email' => 'vlad2000100600@gmail.com',
                'avatar_url' => null,
                'password' => '78Aeq4883',
                'type_user' => 'user',
                'currency_id' => null,
                'timezone_id' => null,
                'vip_status_time_end' => null
            ]
        ];
        foreach ($data as $user) {
            if($this->registrationRepository->isExistUserByEmail($user['email'])) {
                continue;
            }
            $this->registrationRepository->registerUser($user['name'],$user['email'], $user['password'], $user['timezone_id'], $user['currency_id'], $user['avatar_url'], $user['type_user'], $user['vip_status_time_end']);
        }

    }
}
