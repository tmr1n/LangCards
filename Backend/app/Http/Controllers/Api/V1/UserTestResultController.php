<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Repositories\TestRepositories\TestRepositoryInterface;
use App\Repositories\TimezoneRepositories\TimezoneRepositoryInterface;
use App\Repositories\UserRepositories\UserRepositoryInterface;
use App\Repositories\UserTestResultRepositories\UserTestResultRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserTestResultController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    protected UserTestResultRepositoryInterface $userTestResultRepository;

    protected TestRepositoryInterface $testRepository;

    public function __construct(UserTestResultRepositoryInterface $userTestResultRepository, TestRepositoryInterface $testRepository, UserRepositoryInterface $userRepository)
    {
        $this->userTestResultRepository = $userTestResultRepository;
        $this->testRepository = $testRepository;
        $this->userRepository = $userRepository;
    }

    public function start($id)
    {
        if(!$this->testRepository->isExistTestById($id))
        {
            return ApiResponse::error("Тест с id = $id не существует", null, 404);
        }
        $isPremiumTest = $this->testRepository->isTestForPremiumDeck($id);
        $userId = auth()->id();
        if($isPremiumTest && !$this->userRepository->hasUserActivePremiumStatusByIdUser($userId))
        {
            return ApiResponse::error("Тест с id = $id относится к премиальной колоде, то есть является премиальным, а текущий пользователь с id = $userId не имеет активного премиального статуса", null, 403);
        }
        //проверка на количество попыток
        $testInfo = $this->testRepository->getTestById($id);
        $countOfAttemptsTestByUser = $this->userTestResultRepository->getCountAttemptsOfTestByUserId($id, $userId);
        if ($testInfo->count_attempts !== null && $countOfAttemptsTestByUser >= $testInfo->count_attempts) {
            return ApiResponse::error("Исчерпано количество попыток для прохождения теста с id = $id пользователем с id = $userId", null, 403);
        }
        //
        $currentTime = Carbon::now();
        $this->userTestResultRepository->saveNewUserTestResult($currentTime, $userId, $id);
        return ApiResponse::success("Тест с id = $id был начат пользователем с id = $userId");
    }
}
