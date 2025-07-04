<?php

namespace Database\Seeders;

use App\Repositories\QuestionAnswerRepository\QuestionAnswerRepositoryInterface;
use App\Repositories\QuestionRepositories\QuestionRepositoryInterface;
use App\Repositories\TestRepositories\TestRepositoryInterface;
use App\Repositories\UserTestAnswerRepositories\UserTestAnswerRepositoryInterface;
use App\Repositories\UserTestResultRepositories\UserTestResultRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTestAnswerSeeder extends Seeder
{
    protected UserTestResultRepositoryInterface $userTestResultRepository;

    protected UserTestAnswerRepositoryInterface $userTestAnswerRepository;

    protected QuestionRepositoryInterface $questionRepository;

    protected QuestionAnswerRepositoryInterface $questionAnswerRepository;

    protected TestRepositoryInterface $testRepository;

    public function __construct(UserTestResultRepositoryInterface $userTestResultRepository,
                                UserTestAnswerRepositoryInterface $userTestAnswerRepository,
                                QuestionRepositoryInterface $questionRepository,
                                QuestionAnswerRepositoryInterface $questionAnswerRepository,
                                TestRepositoryInterface $testRepository)
    {
        $this->userTestResultRepository = $userTestResultRepository;
        $this->userTestAnswerRepository = $userTestAnswerRepository;
        $this->questionRepository = $questionRepository;
        $this->questionAnswerRepository = $questionAnswerRepository;
        $this->testRepository = $testRepository;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countCorrectAnswers = 0;
        $currentUserId = 1;
        $data =
            (object)[
                'user_test_result_id' =>1,
                'answers_for_question' => [
                    ['question_id'=>1,'answer_id'=>1],
                    ['question_id'=>2,'answer_id'=>7],
                    ['question_id'=>3,'answer_id'=>9],
                    ['question_id'=>4,'answer_id'=>13],
                ]
            ];
        $infoAttempt = $this->userTestResultRepository->getUserTestResultById($data->user_test_result_id);
        if($infoAttempt === null) // проверка, что попытка с id существует
        {
            return;
        }
        if($infoAttempt->user_id !== $currentUserId) // проверка, что попытка принадлежит пользователю, совершившему запрос
        {
            return;
        }
        if($this->userTestAnswerRepository->isExistAnswerForAttempt($data->user_test_result_id)) // проверка, что ответы не сохранялись ранее для этой попытки
        {
            return;
        }
        // проверка, что ответ на вопрос существует в единичном варианте
        $question_ids = array_column($data->answers_for_question, 'question_id');
        $unique_question_ids = array_unique($question_ids);
        if (count($question_ids) !== count($unique_question_ids))
        {
            return;
        }
        // проверка, что время на выполнение теста не иссякло
        $infoTest = $this->testRepository->getTestById($infoAttempt->test_id);
        $countSeconds = $infoTest->time_seconds;
        if(is_int($countSeconds))
        {
            if(Carbon::parse($infoAttempt->start_time)->addSeconds($countSeconds)->isPast())
            {
                return;
            }
        }

        // проверить, что вопрос находится в тесте, для которого совершается занесение ответа
        foreach ($data->answers_for_question as $answer)
        {
            if(!$this->questionRepository->isExistQuestionByIdInTest($answer['question_id'], $infoAttempt->test_id))
            {
                continue;
            }
            $answerFromDB = $this->questionAnswerRepository->getAnswerById($answer['answer_id']);
            if($answerFromDB->question_id !== $answer['question_id']) // проверка, что предоставленный ответ является возможным ответом на вопрос
            {
                continue;
            }
            $this->userTestAnswerRepository->saveNewUserTestAnswer($data->user_test_result_id, $answer['question_id'], $answer['answer_id'], $answerFromDB->is_correct);
            if($answerFromDB->is_correct)
            {
                $countCorrectAnswers++;
            }
        }
        $countAllQuestions = $this->testRepository->getCountQuestionInTest($infoAttempt->test_id);
        $percent = $countAllQuestions > 0 ? round(($countCorrectAnswers / $countAllQuestions) * 100) : 0;
        $this->userTestResultRepository->updateUserTestResultAfterEnding(Carbon::now(), $percent,$data->user_test_result_id );
    }
}
