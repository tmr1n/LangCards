<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TariffRequests\AddingNewTariffRequest;
use App\Http\Resources\v1\TariffResources\TariffResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\TariffRepositories\TariffRepositoryInterface;
use App\Repositories\UserRepositories\UserRepositoryInterface;

class TariffController extends Controller
{
    protected TariffRepositoryInterface $tariffRepository;
    protected UserRepositoryInterface $userRepository;

    public function __construct(TariffRepositoryInterface $tariffRepository, UserRepositoryInterface $userRepository)
    {
        $this->tariffRepository = $tariffRepository;
        $this->userRepository = $userRepository;
    }

    public function getTariffs()
    {
        $authUserInfo = $this->userRepository->getInfoUserById(auth()->id());
        if($authUserInfo->currency_id === null)
        {
            $data = $this->tariffRepository->getAllActiveTariffs();
            return ApiResponse::success('Все данные о тарифах', (object)['items'=> $data]);
        }
        $data = $this->tariffRepository->getActiveTariffsForUserCurrency($authUserInfo->currency_id);
        return ApiResponse::success('Все данные о тарифах', (object)['items'=> TariffResource::collection($data)]);
    }
    public function addTariff(AddingNewTariffRequest $request)
    {
        $newTariff = $this->tariffRepository->saveNewTariff($request->name, $request->days);
        if($newTariff === null)
        {
            return ApiResponse::error('Не удалось создать тариф', null, 500);
        }
        return ApiResponse::success('Новый тариф успешно создан');
    }
}
