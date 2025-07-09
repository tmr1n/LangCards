<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\HistoryPurchaseResources\HistoryPurchaseResource;
use App\Http\Resources\v1\UserTestResultResources\UserTestResultResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\HistoryPurchasesRepository\HistoryPurchaseRepositoryInterface;
use App\Services\PaginatorService;
use Illuminate\Http\Request;

class HistoryPurchaseController extends Controller
{
    protected HistoryPurchaseRepositoryInterface $historyPurchaseRepository;

    public function __construct(HistoryPurchaseRepositoryInterface $historyPurchaseRepository)
    {
        $this->historyPurchaseRepository = $historyPurchaseRepository;
    }

    public function getHistoryPurchasesOfAuthUser(PaginatorService $paginator, Request $request)
    {
        $authUserId = auth()->id();
        $countOnPage = (int)$request->input('countOnPage', config('app.default_count_on_page'));
        $numberCurrentPage = (int)$request->input('page', config('app.default_page'));
        $data = $this->historyPurchaseRepository->getHistoryPurchasesOfAuthUser($paginator, $authUserId, $countOnPage, $numberCurrentPage);
        return ApiResponse::success("Получена история покупок в приложении для авторизованного пользователя с id = $authUserId", (object)['items'=>HistoryPurchaseResource::collection($data['items']),
            'pagination' => $data['pagination']]);
    }
}
