<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StartTestRequest;
use App\Http\Resources\v1\QuestionResources\QuestionResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\QuestionRepositories\QuestionRepositoryInterface;
use App\Repositories\TestRepositories\TestRepositoryInterface;
use App\Repositories\TimezoneRepositories\TimezoneRepositoryInterface;
use App\Repositories\UserRepositories\UserRepositoryInterface;
use App\Repositories\UserTestResultRepositories\UserTestResultRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserTestResultController extends Controller
{
    protected QuestionRepositoryInterface $questionRepository;
    protected UserRepositoryInterface $userRepository;

    protected UserTestResultRepositoryInterface $userTestResultRepository;

    protected TestRepositoryInterface $testRepository;

    public function __construct(UserTestResultRepositoryInterface $userTestResultRepository,
                                TestRepositoryInterface $testRepository,
                                UserRepositoryInterface $userRepository,
                                QuestionRepositoryInterface $questionRepository)
    {
        $this->userTestResultRepository = $userTestResultRepository;
        $this->testRepository = $testRepository;
        $this->userRepository = $userRepository;
        $this->questionRepository = $questionRepository;
    }

    public function start(StartTestRequest $request)
    {
        if(!$this->testRepository->isExistTestById($request->testId))
        {
            return ApiResponse::error("Тест с id = $request->testId не существует", null, 404);
        }
        $isPremiumTest = $this->testRepository->isTestForPremiumDeck($request->testId);
        $userId = auth()->id();
        if($isPremiumTest && !$this->userRepository->hasUserActivePremiumStatusByIdUser($userId))
        {
            return ApiResponse::error("Тест с id = $request->testId относится к премиальной колоде, то есть является премиальным, а текущий пользователь с id = $userId не имеет активного премиального статуса", null, 403);
        }
        //проверка на количество попыток
        $testInfo = $this->testRepository->getTestById($request->testId);
        $countOfAttemptsTestByUser = $this->userTestResultRepository->getCountAttemptsOfTestByUserId($request->testId, $userId);
        if ($testInfo->count_attempts !== null && $countOfAttemptsTestByUser >= $testInfo->count_attempts) {
            return ApiResponse::error("Исчерпано количество попыток для прохождения теста с id = $request->testId пользователем с id = $userId", null, 403);
        }
        //
        $currentTime = Carbon::now();
        $this->userTestResultRepository->saveNewUserTestResult($currentTime, $userId, $request->testId);
        $questionsForTest = $this->questionRepository->getQuestionsForTest($request->testId);
        return ApiResponse::success("Тест с id = $request->testId был начат пользователем с id = $userId", (object)['items'=>QuestionResource::collection($questionsForTest)]);
    }
}
