<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\HandlesMonitoringCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\OilTemperatureLogRequest;
use App\Models\OilTemperatureLog;
use Illuminate\Http\JsonResponse;

class OilTemperatureLogController extends Controller
{
    use HandlesMonitoringCrud;

    protected function modelClass(): string
    {
        return OilTemperatureLog::class;
    }

    public function store(OilTemperatureLogRequest $request): JsonResponse
    {
        return $this->storeRecord($request);
    }

    public function update(OilTemperatureLogRequest $request, int $id): JsonResponse
    {
        return $this->updateRecord($request, $id);
    }
}
