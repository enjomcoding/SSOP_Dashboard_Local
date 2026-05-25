<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\HandlesMonitoringCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\CleaningLogRequest;
use App\Models\CleaningLog;
use Illuminate\Http\JsonResponse;

class CleaningLogController extends Controller
{
    use HandlesMonitoringCrud;

    protected function modelClass(): string
    {
        return CleaningLog::class;
    }

    public function store(CleaningLogRequest $request): JsonResponse
    {
        return $this->storeRecord($request);
    }

    public function update(CleaningLogRequest $request, int $id): JsonResponse
    {
        return $this->updateRecord($request, $id);
    }
}
