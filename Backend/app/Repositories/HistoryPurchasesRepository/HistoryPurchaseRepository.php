<?php

namespace App\Repositories\HistoryPurchasesRepository;

use App\Models\HistoryPurchase;

class HistoryPurchaseRepository implements HistoryPurchaseRepositoryInterface
{
    protected HistoryPurchase $model;

    public function __construct(HistoryPurchase $model)
    {
        $this->model = $model;
    }

    public function saveNewHistoryPurchase(string $datePurchase, string $dateEnd, int $userId, int $costId)
    {
        $newHistoryPurchase = new HistoryPurchase();
        $newHistoryPurchase->date_purchase = $datePurchase;
        $newHistoryPurchase->date_end = $dateEnd;
        $newHistoryPurchase->user_id = $userId;
        $newHistoryPurchase->cost_id = $costId;
        $newHistoryPurchase->save();
    }
}
