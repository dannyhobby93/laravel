<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreUuidItemRequest;
use App\Http\Requests\Api\V1\UpdateUuidItemRequest;
use App\Http\Resources\Api\V1\UuidItemResource;
use App\Models\UuidItem;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UuidItemController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return UuidItemResource::collection(UuidItem::query()->latest()->paginate());
    }

    public function store(StoreUuidItemRequest $request): UuidItemResource
    {
        $uuidItem = UuidItem::query()->create($request->validated());

        return new UuidItemResource($uuidItem);
    }

    public function show(UuidItem $uuidItem): UuidItemResource
    {
        return new UuidItemResource($uuidItem);
    }

    public function update(UpdateUuidItemRequest $request, UuidItem $uuidItem): UuidItemResource
    {
        $uuidItem->update($request->validated());

        return new UuidItemResource($uuidItem);
    }

    public function destroy(UuidItem $uuidItem): Response
    {
        $uuidItem->delete();

        return response()->noContent();
    }
}
