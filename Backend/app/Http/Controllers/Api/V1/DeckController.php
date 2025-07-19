<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TypeInfoAboutDeck;
use App\Http\Controllers\Controller;
use App\Http\Filters\FiltersForModels\DeckFilter;
use App\Http\Requests\Api\V1\DeckRequests\DeckFilterRequest;
use App\Http\Resources\v1\DeckResources\DeckResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\DeckRepositories\DeckRepositoryInterface;
use App\Repositories\UserRepositories\UserRepositoryInterface;
use App\Repositories\UserTestResultRepositories\UserTestResultRepositoryInterface;
use App\Services\PaginatorService;
use Dedoc\Scramble\Attributes\QueryParameter;

class DeckController extends Controller
{
    protected UserRepositoryInterface $userRepository;
    protected DeckRepositoryInterface $deckRepository;

    protected UserTestResultRepositoryInterface $userTestResultRepository;

    public function __construct(DeckRepositoryInterface $deckRepository, UserTestResultRepositoryInterface $userTestResultRepository, UserRepositoryInterface $userRepository)
    {
        $this->deckRepository = $deckRepository;
        $this->userTestResultRepository = $userTestResultRepository;
        $this->userRepository = $userRepository;
    }

    #[QueryParameter('page', 'Номер страницы', type: 'int',default:10, example: 1)]
    #[QueryParameter('countOnPage', 'Количество элементов на странице', type: 'int',default:10, example: 10)]
    #[QueryParameter('originalLanguages', description: 'Оригинальные языки (через запятую)', type: 'string', infer: true, example: 'en_US,ru_RU,de_DE')]
    #[QueryParameter('targetLanguages', description: 'Целевые языки (через запятую)', type: 'string', infer: true, example: 'en_US,ru_RU,de_DE')]
    #[QueryParameter('showPremium', description: 'Тип показа премиум контента', type: 'string', infer: true, example: 'onlyPremium')]
    public function getDecks(DeckFilterRequest $request, PaginatorService $paginator, DeckFilter $deckFilter)
    {
        $countOnPage = (int)$request->input('countOnPage', config('app.default_count_on_page'));
        $numberCurrentPage = (int)$request->input('page', config('app.default_page'));
        $data = $this->deckRepository->getDecksWithPaginationAndFilters($paginator,$deckFilter, $countOnPage, $numberCurrentPage);
        return ApiResponse::success(__('api.deck_data_on_page',['numberCurrentPage'=>$numberCurrentPage]), (object)['items'=>DeckResource::collection($data['items']),
            'pagination' => $data['pagination']]);
    }
    public function deleteDeck(int $id)
    {
        $userId = auth()->id();
        $currentDeck = $this->deckRepository->getDeckById($id, TypeInfoAboutDeck::minimum);
        if($currentDeck === null)
        {
            return ApiResponse::error(__('api.deck_not_found', ['id'=>$id]), null, 404);
        }
        if($currentDeck->user_id !== $userId)
        {
            return ApiResponse::error(__('api.user_not_deck_owner'), null, 403);
        }
        $hasAnyStartedTests =$this->userTestResultRepository->existStartedTestForDeck($id);
        if($hasAnyStartedTests === false)
        {
            $this->deckRepository->deleteDeckById($id);
            return ApiResponse::success(__('api.deck_deleted_permanently', ['id'=>$id]));
        }
        $this->deckRepository->softDeleteDeckById($id);
        return ApiResponse::success(__('api.deck_soft_deleted', ['id'=>$id]));
    }
    public function getDeck(int $id)
    {
        $deck = $this->deckRepository->getDeckById($id,TypeInfoAboutDeck::maximum);
        if($deck === null)
        {
            return ApiResponse::error(__('api.deck_not_found', ['id'=>$id]), null, 404);
        }
        if($deck->is_premium && !$this->userRepository->hasUserActivePremiumStatusByIdUser(auth()->id()))
        {
            return ApiResponse::error(__('api.deck_is_premium_access_denied',['id'=>$id]), null, 403);
        }
        return ApiResponse::success(__('api.deck_found', ['id'=>$id]), (object)['item'=>new DeckResource($deck)]);
    }
}
