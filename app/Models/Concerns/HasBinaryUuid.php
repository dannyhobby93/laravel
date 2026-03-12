<?php

namespace App\Models\Concerns;

use App\Casts\BinaryUuid;
use Illuminate\Support\Str;

trait HasBinaryUuid
{
    public function initializeHasBinaryUuid(): void
    {
        $this->mergeCasts([
            $this->binaryUuidColumn() => BinaryUuid::class,
        ]);
    }

    public static function bootHasBinaryUuid(): void
    {
        static::creating(function ($model) {
            $column = $model->binaryUuidColumn();

            if (! array_key_exists($column, $model->getAttributes())) {
                $model->{$column} = Str::uuid()->toString();
            }
        });
    }

    /**
     * The column name used for the binary UUID.
     */
    public function binaryUuidColumn(): string
    {
        return 'uuid';
    }

    /**
     * Use the UUID column for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return $this->binaryUuidColumn();
    }

    /**
     * Resolve the model for route model binding by converting the
     * incoming UUID string to binary before querying.
     */
    public function resolveRouteBinding($value, $field = null): ?self
    {
        $field ??= $this->getRouteKeyName();

        if ($field === $this->binaryUuidColumn()) {
            $value = hex2bin(str_replace('-', '', $value));
        }

        return $this->where($field, $value)->first();
    }

    /**
     * Resolve the model for scoped route model binding.
     */
    public function resolveChildRouteBinding($childType, $value, $field): ?self
    {
        $relationship = $this->{Str::camel($childType)}();

        $field ??= $relationship->getRelated()->getRouteKeyName();

        if ($field === $this->binaryUuidColumn()) {
            $value = hex2bin(str_replace('-', '', $value));
        }

        return $relationship->where($field, $value)->first();
    }
}
