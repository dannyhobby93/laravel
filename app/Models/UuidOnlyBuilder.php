<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Custom Eloquent builder for UuidOnly that converts string UUIDs to binary
 * before querying by the primary key column.
 *
 * @extends Builder<UuidOnly>
 */
class UuidOnlyBuilder extends Builder
{
    /**
     * Find a model by its primary key, converting string UUIDs to binary first.
     *
     * @param  mixed  $id
     * @param  array<int, string>  $columns
     * @return UuidOnly|null
     */
    public function find($id, $columns = ['*'])
    {
        if (is_array($id)) {
            $id = array_map(
                fn ($v) => is_string($v) && Str::isUuid($v) ? hex2bin(str_replace('-', '', $v)) : $v,
                $id,
            );

            return parent::find($id, $columns);
        }

        if (is_string($id) && Str::isUuid($id)) {
            $id = hex2bin(str_replace('-', '', $id));
        }

        return parent::find($id, $columns);
    }
}
