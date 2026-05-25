<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CleaningLog;
use App\Models\DeliveryTruckLog;
use App\Models\OilTemperatureLog;
use App\Models\PestControlLog;
use App\Models\RawMaterialLog;
use App\Models\StockManagementLog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(): JsonResponse
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyCounts = [
            RawMaterialLog::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            DeliveryTruckLog::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            PestControlLog::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            OilTemperatureLog::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            CleaningLog::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            StockManagementLog::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
        ];
        $totalLogsThisMonth = array_sum($monthlyCounts);

        $deliveryTruckPest = DeliveryTruckLog::where('pest_activity', true)->count();
        $pestControlObserved = PestControlLog::where('pest_activity_observed', true)->count();

        $rawMaterialStats = RawMaterialLog::query()
            ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'ACCEPTED' THEN 1 ELSE 0 END) as accepted")
            ->first();

        $rawMaterialTotal = (int) $rawMaterialStats->total;
        $rawMaterialAccepted = (int) $rawMaterialStats->accepted;
        $acceptanceRate = $rawMaterialTotal > 0
            ? round(($rawMaterialAccepted / $rawMaterialTotal) * 100, 1)
            : 0;

        $logsLast7Days = $this->buildLastSevenDaysCounts();

        $packagingCondition = RawMaterialLog::query()
            ->select('packaging_condition', DB::raw('COUNT(*) as count'))
            ->groupBy('packaging_condition')
            ->get()
            ->map(fn ($row) => [
                'name' => $row->packaging_condition,
                'value' => (int) $row->count,
            ]);

        return response()->json([
            'total_logs_this_month' => $totalLogsThisMonth,
            'pest_activity_counts' => [
                'delivery_truck' => $deliveryTruckPest,
                'pest_control' => $pestControlObserved,
                'total' => $deliveryTruckPest + $pestControlObserved,
            ],
            'raw_material_acceptance_rate' => $acceptanceRate,
            'raw_material_totals' => [
                'total' => $rawMaterialTotal,
                'accepted' => $rawMaterialAccepted,
                'rejected' => $rawMaterialTotal - $rawMaterialAccepted,
            ],
            'inspections_last_7_days' => $logsLast7Days,
            'material_condition_chart' => $packagingCondition,
        ]);
    }

    /**
     * @return array<int, array{date: string, label: string, count: int}>
     */
    private function buildLastSevenDaysCounts(): array
    {
        $start = Carbon::today()->subDays(6)->format('Y-m-d');
        $end = Carbon::today()->format('Y-m-d');

        $dateColumns = [
            RawMaterialLog::class => 'receiving_date',
            DeliveryTruckLog::class => 'inspection_date',
            PestControlLog::class => 'inspection_date',
            OilTemperatureLog::class => 'production_date',
            CleaningLog::class => 'log_date',
            StockManagementLog::class => 'log_date',
        ];

        $totalsByDate = [];

        foreach ($dateColumns as $model => $column) {
            $rows = $model::query()
                ->selectRaw("DATE({$column}) as day, COUNT(*) as count")
                ->whereBetween($column, [$start, $end])
                ->groupBy('day')
                ->pluck('count', 'day');

            foreach ($rows as $day => $count) {
                $totalsByDate[$day] = ($totalsByDate[$day] ?? 0) + (int) $count;
            }
        }

        $result = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $key = $date->format('Y-m-d');
            $result[] = [
                'date' => $key,
                'label' => $date->format('D'),
                'count' => $totalsByDate[$key] ?? 0,
            ];
        }

        return $result;
    }
}
