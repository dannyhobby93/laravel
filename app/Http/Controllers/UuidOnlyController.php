<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUuidOnlyRequest;
use App\Http\Requests\UpdateUuidOnlyRequest;
use App\Models\UuidOnly;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UuidOnlyController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(UuidOnly::all());
    }

    public function store(StoreUuidOnlyRequest $request): JsonResponse
    {
        $record = UuidOnly::create($request->validated());

        return response()->json($record, 201);
    }

    public function show(UuidOnly $uuidOnly): JsonResponse
    {
        return response()->json($uuidOnly);
    }

    public function update(UpdateUuidOnlyRequest $request, UuidOnly $uuidOnly): JsonResponse
    {
        $uuidOnly->update($request->validated());

        return response()->json($uuidOnly);
    }

    public function destroy(UuidOnly $uuidOnly): Response
    {
        $uuidOnly->delete();

        return response()->noContent();
    }
}
