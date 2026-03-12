<?php

namespace App\Http\Controllers;

use App\Models\ComboTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComboTableController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ComboTable::all());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $record = ComboTable::create($validated);

        return response()->json($record, 201);
    }

    public function show(ComboTable $comboTable): JsonResponse
    {
        return response()->json($comboTable);
    }

    public function update(Request $request, ComboTable $comboTable): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $comboTable->update($validated);

        return response()->json($comboTable);
    }

    public function destroy(ComboTable $comboTable): JsonResponse
    {
        $comboTable->delete();

        return response()->json(null, 204);
    }
}
