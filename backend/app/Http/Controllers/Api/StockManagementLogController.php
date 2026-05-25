<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\HandlesMonitoringCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockManagementLogRequest;
use App\Models\StockManagementLog;
use Illuminate\Http\JsonResponse;

class StockManagementLogController extends Controller
{
    use HandlesMonitoringCrud;

    protected function modelClass(): string
    {
        return StockManagementLog::class;
    }

    public function store(StockManagementLogRequest $request): JsonResponse
    {
        return $this->storeRecord($request);
    }

    public function update(StockManagementLogRequest $request, int $id): JsonResponse
    {
        return $this->updateRecord($request, $id);
    }
}
