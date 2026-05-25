<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\HandlesMonitoringCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryTruckLogRequest;
use App\Models\DeliveryTruckLog;
use Illuminate\Http\JsonResponse;

class DeliveryTruckLogController extends Controller
{
    use HandlesMonitoringCrud;

    protected function modelClass(): string
    {
        return DeliveryTruckLog::class;
    }

    public function store(DeliveryTruckLogRequest $request): JsonResponse
    {
        return $this->storeRecord($request);
    }

    public function update(DeliveryTruckLogRequest $request, int $id): JsonResponse
    {
        return $this->updateRecord($request, $id);
    }
}
