<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreComboItemRequest;
use App\Http\Requests\Api\V1\UpdateComboItemRequest;
use App\Http\Resources\Api\V1\ComboItemResource;
use App\Models\ComboItem;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ComboItemController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ComboItemResource::collection(ComboItem::query()->latest()->paginate());
    }

    public function store(StoreComboItemRequest $request): ComboItemResource
    {
        $comboItem = ComboItem::query()->create($request->validated());

        return new ComboItemResource($comboItem);
    }

    public function show(ComboItem $comboItem): ComboItemResource
    {
        return new ComboItemResource($comboItem);
    }

    public function update(UpdateComboItemRequest $request, ComboItem $comboItem): ComboItemResource
    {
        $comboItem->update($request->validated());

        return new ComboItemResource($comboItem);
    }

    public function destroy(ComboItem $comboItem): Response
    {
        $comboItem->delete();

        return response()->noContent();
    }
}
