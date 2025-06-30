<?php

namespace App\Providers;

use App\Repositories\ApiLimitRepositories\ApiLimitRepository;
use App\Repositories\ApiLimitRepositories\ApiLimitRepositoryInterface;
use App\Repositories\CurrencyRepositories\CurrencyRepository;
use App\Repositories\CurrencyRepositories\CurrencyRepositoryInterface;
use App\Repositories\DeckRepositories\DeckRepository;
use App\Repositories\DeckRepositories\DeckRepositoryInterface;
use App\Repositories\LanguageRepositories\LanguageRepository;
use App\Repositories\LanguageRepositories\LanguageRepositoryInterface;
use App\Repositories\LoginRepositories\LoginRepository;
use App\Repositories\LoginRepositories\LoginRepositoryInterface;
use App\Repositories\ForgotPasswordRepositories\ForgotForgotPasswordRepository;
use App\Repositories\ForgotPasswordRepositories\ForgotPasswordRepositoryInterface;
use App\Repositories\RegistrationRepositories\RegistrationRepository;
use App\Repositories\RegistrationRepositories\RegistrationRepositoryInterface;
use App\Repositories\TariffRepositories\TariffRepository;
use App\Repositories\TariffRepositories\TariffRepositoryInterface;
use App\Repositories\TimezoneRepositories\TimezoneRepository;
use App\Repositories\TimezoneRepositories\TimezoneRepositoryInterface;
use App\Repositories\UserRepositories\UserRepository;
use App\Repositories\UserRepositories\UserRepositoryInterface;
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
            ApiLimitRepositoryInterface::class => ApiLimitRepository::class,
            UserRepositoryInterface::class => UserRepository::class,
            ForgotPasswordRepositoryInterface::class => ForgotForgotPasswordRepository::class,
            LanguageRepositoryInterface::class => LanguageRepository::class,
            DeckRepositoryInterface::class => DeckRepository::class,
            TariffRepositoryInterface::class => TariffRepository::class,
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
