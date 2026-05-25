<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\HandlesMonitoringCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\PestControlLogRequest;
use App\Models\PestControlLog;
use Illuminate\Http\JsonResponse;

class PestControlLogController extends Controller
{
    use HandlesMonitoringCrud;

    protected function modelClass(): string
    {
        return PestControlLog::class;
    }

    public function store(PestControlLogRequest $request): JsonResponse
    {
        return $this->storeRecord($request);
    }

    public function update(PestControlLogRequest $request, int $id): JsonResponse
    {
        return $this->updateRecord($request, $id);
    }
}
