<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasBinaryUuidColumn
{
    /**
     * Boot the trait: auto-generate a binary UUID on model creation.
     */
    public static function bootHasBinaryUuidColumn(): void
    {
        static::creating(function (self $model): void {
            $column = $model->uuidColumn();

            if (empty($model->getRawOriginal($column))) {
                $model->{$column} = (string) Str::orderedUuid();
            }
        });
    }

    /**
     * The UUID column name. Override by setting $uuidColumnName on the model.
     */
    public function uuidColumn(): string
    {
        return property_exists($this, 'uuidColumnName') ? $this->uuidColumnName : 'uuid';
    }

    /**
     * Resolve route model binding by converting the string UUID to binary.
     */
    public function resolveRouteBinding(mixed $value, ?string $field = null): ?static
    {
        if (! Str::isUuid($value)) {
            return null;
        }

        $column = $field ?? $this->uuidColumn();

        return $this->where($column, hex2bin(str_replace('-', '', $value)))->first();
    }

    /**
     * The route key is always the string UUID representation.
     */
    public function getRouteKey(): string
    {
        return $this->{$this->uuidColumn()};
    }

    /**
     * The route key name is the UUID column.
     */
    public function getRouteKeyName(): string
    {
        return $this->uuidColumn();
    }
}
