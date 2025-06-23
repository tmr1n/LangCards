<?php

namespace App\Http\Controllers\Api\V1\AuthControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AuthRequests\RegistrationRequest;
use App\Http\Responses\ApiResponse;
use App\Repositories\RegistrationRepositories\RegistrationRepositoryInterface;
use App\Repositories\TimezoneRepositories\TimezoneRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class RegistrationController extends Controller
{
    protected RegistrationRepositoryInterface $registrationRepository;

    protected TimezoneRepositoryInterface $timezoneRepository;

    public function __construct(RegistrationRepositoryInterface $registrationRepository,
                                TimezoneRepositoryInterface     $timezoneRepository)
    {
        $this->registrationRepository = $registrationRepository;
        $this->timezoneRepository = $timezoneRepository;
    }

    public function registration(RegistrationRequest $request): JsonResponse
    {
        //$ip = '151.0.18.5'; // или $request->ip() для IP клиента
        $ip = $request->ip();
        $apiKey = config('services.ipgeolocation.key');
        $response = Http::get("https://api.ipgeolocation.io/v2/timezone", [
            'apiKey' => $apiKey,
            'ip' => $ip,
        ]);
        $data = $response->json();
        logger($data);
        $timezoneId = null;
        $nameRegion = data_get($data, 'time_zone.name');
        if (isset($nameRegion)) {
            logger($nameRegion);
            if ($this->timezoneRepository->isExistRepositoryByNameRegion($nameRegion)) {
                $timezoneDB = $this->timezoneRepository->getRepositoryByNameRegion($nameRegion);
                $timezoneId = $timezoneDB->id;
            }
        }
        $this->registrationRepository->registerUser($request->name, $request->email, $request->password, $timezoneId);
        return ApiResponse::success('Новый пользователь успешно зарегистрирован', null, 201);
    }
}
