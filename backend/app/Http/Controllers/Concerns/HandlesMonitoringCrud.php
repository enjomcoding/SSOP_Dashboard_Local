<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

trait HandlesMonitoringCrud
{
    abstract protected function modelClass(): string;

    protected function relationsToLoad(): array
    {
        $class = $this->modelClass();

        return defined("{$class}::RELATIONS") ? $class::RELATIONS : [];
    }

    public function index(): JsonResponse
    {
        $records = $this->modelClass()::query()
            ->with($this->relationsToLoad())
            ->latest('created_at')
            ->paginate(15);

        return response()->json($records);
    }

    protected function storeRecord(FormRequest $request): JsonResponse
    {
        $record = $this->modelClass()::create($request->validated());
        $record->load($this->relationsToLoad());

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
        $record->load($this->relationsToLoad());

        return response()->json($record);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->findRecord($id)->delete();

        return response()->json(['message' => 'Record deleted successfully.']);
    }

    protected function findRecord(int $id): Model
    {
        return $this->modelClass()::query()
            ->with($this->relationsToLoad())
            ->findOrFail($id);
    }
}
