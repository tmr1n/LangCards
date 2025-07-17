<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\PromocodeRequests\ActivatePromocodeRequest;
use App\Http\Requests\Api\V1\PromocodeRequests\CreatePromocodeRequest;
use App\Http\Responses\ApiResponse;
use App\Repositories\PromocodeRepositories\PromocodeRepositoryInterface;
use App\Repositories\TariffRepositories\TariffRepositoryInterface;
use App\Repositories\UserRepositories\UserRepositoryInterface;
use App\Services\PromocodeGeneratorService;
use Carbon\Carbon;
use Exception;

class PromocodeController extends Controller
{
    protected UserRepositoryInterface $userRepository;
    protected TariffRepositoryInterface $tariffRepository;
    protected PromocodeRepositoryInterface $promocodeRepository;
    protected PromocodeGeneratorService $promocodeGeneratorService;
    public function __construct(PromocodeGeneratorService $promocodeGeneratorService,
                                PromocodeRepositoryInterface $promocodeRepository,
                                TariffRepositoryInterface $tariffRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->promocodeGeneratorService = $promocodeGeneratorService;
        $this->promocodeRepository = $promocodeRepository;
        $this->tariffRepository = $tariffRepository;
        $this->userRepository = $userRepository;
    }

    public function createPromocodes(CreatePromocodeRequest $request)
    {
        try {
            $allIdActiveTariffs = $this->tariffRepository->getAllIdActiveTariffs();
            if(count($allIdActiveTariffs) === 0){
                return ApiResponse::success('Нет существующих тарифов', null, 204);
            }
            $codes = $this->promocodeGeneratorService->generateCertainCountCode($request->count);
            foreach ($codes as $code) {
                $this->promocodeRepository->saveNewPromocode($code, $allIdActiveTariffs[array_rand($allIdActiveTariffs)]);
            }
            return ApiResponse::success("Промокоды были успешно созданы в количестве $request->count штук");
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), null, 500);
        }
    }
    public function activatePromocode(ActivatePromocodeRequest $request)
    {
        $promocode = $this->promocodeRepository->getPromocodeByCode($request->code);
        if($promocode === null){
            return ApiResponse::error('Промокод не найден', null, 404);
        }
        if($promocode->active === false){
            return ApiResponse::error('Предоставленный промокод уже был активирован ранее', null, 409);
        }
        $user = auth()->user();
        if($user->vip_status_time_end === null){
            $dateEndOfVipStatus = Carbon::now()->addDays($promocode->tariff->days);
        }
        else{
            $currentDateEndOfVipStatus = Carbon::parse($user->vip_status_time_end);
            if($currentDateEndOfVipStatus->isPast())
            {
                $dateEndOfVipStatus = Carbon::now()->addDays($promocode->tariff->days);
            }
            else
            {
                $dateEndOfVipStatus = $currentDateEndOfVipStatus->addDays($promocode->tariff->days);
            }
        }
        $this->userRepository->updateEndDateOfVipStatusByIdUser($user->id, $dateEndOfVipStatus);
        $this->promocodeRepository->deactivatePromocodeByPromocode($promocode);
        $userInfo = $this->userRepository->getInfoUserById($user->id);
        return ApiResponse::success("Обновлена дата окончания VIP - статуса. Дата окончания VIP - статуса: $userInfo->vip_status_time_end");
    }
}
