<?php

namespace App\Providers;

use App\Repositories\CurrencyRepositories\CurrencyRepository;
use App\Repositories\CurrencyRepositories\CurrencyRepositoryInterface;
use App\Repositories\LoginRepositories\LoginRepository;
use App\Repositories\LoginRepositories\LoginRepositoryInterface;
use App\Repositories\RegistrationRepositories\RegistrationRepository;
use App\Repositories\RegistrationRepositories\RegistrationRepositoryInterface;
use App\Repositories\TimezoneRepositories\TimezoneRepository;
use App\Repositories\TimezoneRepositories\TimezoneRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $repositories = [
            RegistrationRepositoryInterface::class => RegistrationRepository::class,
            TimezoneRepositoryInterface::class => TimezoneRepository::class,
            LoginRepositoryInterface::class => LoginRepository::class,
            CurrencyRepositoryInterface::class => CurrencyRepository::class,
        ];
        foreach ($repositories as $interface => $model) {
            $this->app->bind($interface, $model);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
