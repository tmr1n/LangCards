<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserTestResultResources\UserTestResultResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\UserTestResultRepositories\UserTestResultRepositoryInterface;
use App\Services\PaginatorService;
use Illuminate\Http\Request;

class HistoryAttemptsTestController extends Controller
{
    protected UserTestResultRepositoryInterface $userTestResultRepository;
    public function __construct(UserTestResultRepositoryInterface $userTestResultRepository)
    {
        $this->userTestResultRepository = $userTestResultRepository;
    }

    public function getAttemptsTests(PaginatorService $paginator, Request $request)
    {
        $countOnPage = (int)$request->input('countOnPage', config('app.default_count_on_page'));
        $numberCurrentPage = (int)$request->input('page', config('app.default_page'));
        $data = $this->userTestResultRepository->getResultAttemptsOfCurrentUserWithPagination($paginator, auth()->id(), $numberCurrentPage, $countOnPage);
        return ApiResponse::success(__('api.attempts_data_on_page', ['numberCurrentPage'=>$numberCurrentPage]), (object)['items'=>UserTestResultResource::collection($data['items']),
            'pagination' => $data['pagination']]);
    }
}
