<?php

namespace App\Repositories\StatsRepositories;

use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StatsRepository implements StatsRepositoryInterface
{

    public function getCountUsersByMonth($startDate, $endDate): Collection
    {
        $data = User::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as period"),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get()
            ->pluck('count', 'period');
        // Создаем полный список периодов
        $periods = CarbonPeriod::create(
            $startDate,
            '1 month',
            $endDate
        );
        $result = collect();
        foreach ($periods as $period) {
            $periodKey = $period->format('Y-m');
            $result->put($periodKey, $data->get($periodKey, 0));
        }
        return collect($result)->map(function($count, $date) {
            return [
                'date' => $date,
                'count' => $count
            ];
        })->values();
    }
}
