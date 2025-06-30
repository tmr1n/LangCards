<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Tables;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\FilterParametersResources\ApiLimitFilterParametersResource;
use App\Http\Responses\ApiResponse;
use App\Models\ApiLimit;
use App\Models\Card;
use App\Models\Cost;
use App\Models\Currency;
use App\Models\Deck;
use App\Models\DeckTopic;
use App\Models\Example;
use App\Models\HistoryPurchase;
use App\Models\Language;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\Tariff;
use App\Models\Test;
use App\Models\Timezone;
use App\Models\Topic;
use App\Models\User;
use App\Models\UserTestAnswer;
use App\Models\UserTestResult;
use App\Models\VisitedDeck;
use App\Repositories\ApiLimitRepositories\ApiLimitRepositoryInterface;

class FilterDataController extends Controller
{
    protected ApiLimitRepositoryInterface $apiLimitRepository;
    public function __construct(ApiLimitRepositoryInterface $apiLimitRepository)
    {
        $this->apiLimitRepository = $apiLimitRepository;
    }

    public function getFilterData(string $nameTable)
    {
        switch ($nameTable) {
            case Tables::ApiLimit->value:
                $data = [
                    'minDay' => $this->apiLimitRepository->getMinDay(),
                    'maxDay' => $this->apiLimitRepository->getMaxDay(),
                    'minRequestCount' => $this->apiLimitRepository->getMinRequestCount(),
                    'maxRequestCount' => $this->apiLimitRepository->getMaxRequestCount(),
                ];
                return ApiResponse::success("Данные для фильтрации модели $nameTable",
                    (object)['filterParameters' =>new ApiLimitFilterParametersResource((object)$data)]);
            case Tables::Card->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::Cost->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::Currency->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::Deck->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::DeckTopic->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::Example->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::HistoryPurchase->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::Language->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::Question->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::QuestionAnswer->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::Tariff->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::Test->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::Timezone->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::Topic->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::User->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::UserTestAnswer->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::UserTestResult->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            case Tables::VisitedDeck->value:
                return ApiResponse::success("Данные для фильтрации модели $nameTable");
            default:
                return ApiResponse::error("Таблицы с наименованием $nameTable не существует");
        }
    }
}
