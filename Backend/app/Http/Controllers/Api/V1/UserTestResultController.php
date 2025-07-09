<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TestRequests\EndTestRequest;
use App\Http\Requests\Api\V1\TestRequests\StartTestRequest;
use App\Http\Resources\v1\QuestionResources\QuestionResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\QuestionAnswerRepository\QuestionAnswerRepositoryInterface;
use App\Repositories\QuestionRepositories\QuestionRepositoryInterface;
use App\Repositories\TestRepositories\TestRepositoryInterface;
use App\Repositories\UserRepositories\UserRepositoryInterface;
use App\Repositories\UserTestAnswerRepositories\UserTestAnswerRepositoryInterface;
use App\Repositories\UserTestResultRepositories\UserTestResultRepositoryInterface;
use Carbon\Carbon;

class UserTestResultController extends Controller
{
    protected QuestionRepositoryInterface $questionRepository;
    protected UserRepositoryInterface $userRepository;

    protected UserTestResultRepositoryInterface $userTestResultRepository;

    protected TestRepositoryInterface $testRepository;

    protected QuestionAnswerRepositoryInterface $questionAnswerRepository;

    protected UserTestAnswerRepositoryInterface $userTestAnswerRepository;

    public function __construct(UserTestResultRepositoryInterface $userTestResultRepository,
                                TestRepositoryInterface $testRepository,
                                UserRepositoryInterface $userRepository,
                                QuestionRepositoryInterface $questionRepository,
                                UserTestAnswerRepositoryInterface $userTestAnswerRepository,
                                QuestionAnswerRepositoryInterface $questionAnswerRepository)
    {
        $this->userTestResultRepository = $userTestResultRepository;
        $this->testRepository = $testRepository;
        $this->userRepository = $userRepository;
        $this->questionRepository = $questionRepository;
        $this->userTestAnswerRepository = $userTestAnswerRepository;
        $this->questionAnswerRepository = $questionAnswerRepository;
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
        $newUserTestResultId =$this->userTestResultRepository->saveNewUserTestResult($currentTime, $userId, $request->testId);
        $questionsForTest = $this->questionRepository->getQuestionsForTest($request->testId);
        return ApiResponse::success("Тест с id = $request->testId был начат пользователем с id = $userId",
            (object)['attemptId'=>$newUserTestResultId,'items'=>QuestionResource::collection($questionsForTest)]);
    }
    public function end(EndTestRequest $request)
    {
        $infoAttempt = $this->userTestResultRepository->getUserTestResultById($request->attemptId);
        if($infoAttempt === null) //проверка наличия попытки
        {
            return ApiResponse::error("Попытка с id = $request->attemptId не найдена", null, 404);
        }
        if($infoAttempt->user_id !== auth()->id()) // проверка, что попытка принадлежит текущему пользователю
        {
            return ApiResponse::error("Попытка с id = $request->attemptId не принадлежит текущему пользователю", null, 403);
        }
        if($infoAttempt->finish_time !== null) // проверка, что попытка не была окончена
        {
            return ApiResponse::error("Попытка с id = $request->attemptId уже была завершена ранее", null, 403);
        }
        if($request->automatic === false) //запрос был инициализирован пользователем
        {
            $countSeconds = $infoAttempt->test->time_seconds;
            if (!is_null($countSeconds)) {
                if (Carbon::parse($infoAttempt->start_time)->addSeconds($countSeconds)->isPast()) {
                    return ApiResponse::error("Время на прохождение теста id = {$infoAttempt->test->id} завершено", null, 403);
                }
            }
        }
        $countCorrectAnswers = 0;
        foreach ($request->answers as $answer)
        {
            // проверка, что вопрос, на который предоставляется ответ, существует в рамках теста
            if(!$this->questionRepository->isExistQuestionByIdInTest($answer['question_id'], $infoAttempt->test->id))
            {
                continue;
            }
            $answerFromDB = $this->questionAnswerRepository->getAnswerById($answer['answer_id']);
            // проверка, что предоставленный ответ является возможным ответом на вопрос
            if($answerFromDB->question_id !== $answer['question_id'])
            {
                continue;
            }
            $this->userTestAnswerRepository->saveNewUserTestAnswer($request->attemptId, $answer['question_id'], $answer['answer_id'], $answerFromDB->is_correct);
            if($answerFromDB->is_correct)
            {
                $countCorrectAnswers++;
            }
        }
        $countAllQuestions = $this->testRepository->getCountQuestionInTest($infoAttempt->test->id);
        $percent = $countAllQuestions > 0 ? round(($countCorrectAnswers / $countAllQuestions) * 100) : 0;
        $this->userTestResultRepository->updateUserTestResultAfterEnding(Carbon::now(), $percent,$request->attemptId);
        $questionsForTest = $this->questionRepository->getQuestionsForTest($infoAttempt->test->id);
        foreach ($questionsForTest as $question)
        {
            if(!$this->userTestAnswerRepository->isExistAnswerForQuestionInAttemptOfTest($question->id, $request->attemptId))
            {
                $this->userTestAnswerRepository->saveNewUserTestAnswer($request->attemptId, $question->id, null, false);
            }
        }
        $shortResults = (object)['percent'=>$percent, 'total_count_questions'=>$countAllQuestions, 'correct_count_answers'=>$countCorrectAnswers];
        return ApiResponse::success("Результаты прохождения теста с id = {$infoAttempt->test->id} для попытки с id = $infoAttempt->id", (object)['results'=>$shortResults]);
    }
}
