<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComboTableRequest;
use App\Http\Requests\UpdateComboTableRequest;
use App\Models\ComboTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ComboTableController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ComboTable::all());
    }

    public function store(StoreComboTableRequest $request): JsonResponse
    {
        $record = ComboTable::create($request->validated());

        return response()->json($record, 201);
    }

    public function show(ComboTable $comboTable): JsonResponse
    {
        return response()->json($comboTable);
    }

    public function update(UpdateComboTableRequest $request, ComboTable $comboTable): JsonResponse
    {
        $comboTable->update($request->validated());

        return response()->json($comboTable);
    }

    public function destroy(ComboTable $comboTable): Response
    {
        $comboTable->delete();

        return response()->noContent();
    }
}
