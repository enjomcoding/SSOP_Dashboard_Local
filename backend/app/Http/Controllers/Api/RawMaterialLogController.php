<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\HandlesMonitoringCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\RawMaterialLogRequest;
use App\Models\RawMaterialLog;
use Illuminate\Http\JsonResponse;

class RawMaterialLogController extends Controller
{
    use HandlesMonitoringCrud;

    protected function modelClass(): string
    {
        return RawMaterialLog::class;
    }

    public function store(RawMaterialLogRequest $request): JsonResponse
    {
        return $this->storeRecord($request);
    }

    public function update(RawMaterialLogRequest $request, int $id): JsonResponse
    {
        return $this->updateRecord($request, $id);
    }
}
