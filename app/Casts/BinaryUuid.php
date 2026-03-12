<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BinaryUuid implements CastsAttributes
{
    /**
     * Cast the given binary(16) value to a UUID string.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        $hex = bin2hex($value);

        return Str::of($hex)->replaceMatches(
            '/^(.{8})(.{4})(.{4})(.{4})(.{12})$/',
            '$1-$2-$3-$4-$5'
        )->toString();
    }

    /**
     * Prepare the given UUID string for storage as binary(16).
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        $hex = str_replace('-', '', $value);

        return hex2bin($hex);
    }
}
