<?php

namespace App\Http\Controllers\Api\V1\AuthControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AuthRequests\RegistrationRequest;
use App\Http\Responses\ApiResponse;
use App\Repositories\CurrencyRepositories\CurrencyRepositoryInterface;
use App\Repositories\RegistrationRepositories\RegistrationRepositoryInterface;
use App\Repositories\TimezoneRepositories\TimezoneRepositoryInterface;
use App\Services\CurrencyService;
use App\Services\TimezoneService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class RegistrationController extends Controller
{
    protected RegistrationRepositoryInterface $registrationRepository;

    protected TimezoneRepositoryInterface $timezoneRepository;

    protected CurrencyRepositoryInterface $currencyRepository;
    public function __construct(RegistrationRepositoryInterface $registrationRepository,
                                TimezoneRepositoryInterface     $timezoneRepository,
                                CurrencyRepositoryInterface $currencyRepository)
    {
        $this->registrationRepository = $registrationRepository;
        $this->timezoneRepository = $timezoneRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function registration(RegistrationRequest $request): JsonResponse
    {
        //$ip = '151.0.18.5'; // или $request->ip() для IP клиента
        $timezoneService = new TimezoneService($this->timezoneRepository);
        $timezoneId = $timezoneService->getTimezoneByIpUser($request->ip());
        $currencyService = new CurrencyService($this->currencyRepository);
        $currencyIdFromDatabase = $currencyService->getCurrencyByIp($request->ip());
        $this->registrationRepository->registerUser($request->name, $request->email, $request->password, $timezoneId, $currencyIdFromDatabase);
        return ApiResponse::success('Новый пользователь успешно зарегистрирован', null, 201);
    }
}
