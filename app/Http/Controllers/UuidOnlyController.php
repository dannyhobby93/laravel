<?php

namespace App\Http\Controllers;

use App\Models\UuidOnly;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UuidOnlyController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(UuidOnly::all());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $record = UuidOnly::create($validated);

        return response()->json($record, 201);
    }

    public function show(UuidOnly $uuidOnly): JsonResponse
    {
        return response()->json($uuidOnly);
    }

    public function update(Request $request, UuidOnly $uuidOnly): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $uuidOnly->update($validated);

        return response()->json($uuidOnly);
    }

    public function destroy(UuidOnly $uuidOnly): JsonResponse
    {
        $uuidOnly->delete();

        return response()->json(null, 204);
    }
}
