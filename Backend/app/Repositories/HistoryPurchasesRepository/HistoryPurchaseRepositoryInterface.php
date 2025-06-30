<?php

namespace App\Repositories\HistoryPurchasesRepository;

interface HistoryPurchaseRepositoryInterface
{
    public function saveNewHistoryPurchase(string $datePurchase,string $dateEnd, int $userId, int $costId);
}
