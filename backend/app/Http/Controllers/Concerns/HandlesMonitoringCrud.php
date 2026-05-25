<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

trait HandlesMonitoringCrud
{
    abstract protected function modelClass(): string;

    public function index(): JsonResponse
    {
        $records = $this->modelClass()::query()
            ->orderByDesc('created_at')
            ->paginate(15);

        return response()->json($records);
    }

    protected function storeRecord(FormRequest $request): JsonResponse
    {
        $record = $this->modelClass()::create($request->validated());

        return response()->json($record, 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->findRecord($id));
    }

    protected function updateRecord(FormRequest $request, int $id): JsonResponse
    {
        $record = $this->findRecord($id);
        $record->update($request->validated());

        return response()->json($record->fresh());
    }

    public function destroy(int $id): JsonResponse
    {
        $this->findRecord($id)->delete();

        return response()->json(['message' => 'Record deleted successfully.']);
    }

    protected function findRecord(int $id): Model
    {
        return $this->modelClass()::query()->findOrFail($id);
    }
}
