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

        $models = [
            RawMaterialLog::class,
            DeliveryTruckLog::class,
            PestControlLog::class,
            OilTemperatureLog::class,
            CleaningLog::class,
            StockManagementLog::class,
        ];

        $totalLogsThisMonth = 0;
        foreach ($models as $model) {
            $totalLogsThisMonth += $model::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        }

        $deliveryTruckPest = DeliveryTruckLog::where('pest_activity', true)->count();
        $pestControlObserved = PestControlLog::where('pest_activity_observed', true)->count();

        $rawMaterialTotal = RawMaterialLog::count();
        $rawMaterialAccepted = RawMaterialLog::where('status', 'ACCEPTED')->count();
        $acceptanceRate = $rawMaterialTotal > 0
            ? round(($rawMaterialAccepted / $rawMaterialTotal) * 100, 1)
            : 0;

        $logsLast7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count =
                RawMaterialLog::whereDate('receiving_date', $date)->count()
                + DeliveryTruckLog::whereDate('inspection_date', $date)->count()
                + PestControlLog::whereDate('inspection_date', $date)->count()
                + OilTemperatureLog::whereDate('production_date', $date)->count()
                + CleaningLog::whereDate('log_date', $date)->count()
                + StockManagementLog::whereDate('log_date', $date)->count();

            $logsLast7Days[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('D'),
                'count' => $count,
            ];
        }

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
}
