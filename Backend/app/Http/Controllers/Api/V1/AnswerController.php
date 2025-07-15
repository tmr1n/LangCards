<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserTestAnswerResources\UserTestAnswerResource;
use App\Http\Resources\v1\UserTestResultResources\UserTestResultResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\QuestionAnswerRepository\QuestionAnswerRepositoryInterface;
use App\Repositories\UserTestAnswerRepositories\UserTestAnswerRepositoryInterface;
use App\Repositories\UserTestResultRepositories\UserTestResultRepositoryInterface;

class AnswerController extends Controller
{
    protected UserTestResultRepositoryInterface $userTestResultRepository;

    protected UserTestAnswerRepositoryInterface $userTestAnswerRepository;

    public function __construct(UserTestResultRepositoryInterface $userTestResultRepository, UserTestAnswerRepositoryInterface $userTestAnswerRepository)
    {
        $this->userTestResultRepository = $userTestResultRepository;
        $this->userTestAnswerRepository = $userTestAnswerRepository;
    }

    public function getAnswersInAttempt($attemptId)
    {
        $attemptInfo = $this->userTestResultRepository->getUserTestResultById($attemptId);
        if($attemptInfo === null)
        {
            return ApiResponse::error("Попытка c id = $attemptId не существует", null, 404);
        }
        if(auth()->id() !== $attemptInfo->user_id)
        {
            return ApiResponse::error("Попытка c id = $attemptId не принадлежит текущему авторизованному пользователю", null, 403);
        }
        if($attemptInfo->finish_time === null)
        {
            return ApiResponse::error("Попытка c id = $attemptId не является завершенной", null, 422);
        }
        $maxAttempts = $attemptInfo->test->count_attempts;
        $canAddCorrectAnswers = $maxAttempts !== null && $maxAttempts === $this->userTestResultRepository->getCountAttemptsOfTestByUserId($attemptInfo->test_id, auth()->id());
        $answers = $this->userTestAnswerRepository->getAnswersForAttemptId($attemptId, $canAddCorrectAnswers);
        return ApiResponse::success("Ответы пользователя на вопросы теста в попытке с id = $attemptId",(object)['attempt'=>new UserTestResultResource($attemptInfo), 'questionsWithAnswers'=>UserTestAnswerResource::collection($answers)]);
    }
}
