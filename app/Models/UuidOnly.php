<?php

namespace App\Models;

use App\Casts\BinaryUuidCast;
use App\Traits\HasBinaryUuidColumn;
use Database\Factories\UuidOnlyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UuidOnly extends Model
{
    /** @use HasFactory<UuidOnlyFactory> */
    use HasBinaryUuidColumn, HasFactory;

    protected $table = 'uuid_only';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['name'];

    protected function casts(): array
    {
        return [
            'uuid' => BinaryUuidCast::class,
        ];
    }

    /**
     * Use the raw binary attribute for the primary key WHERE clause,
     * since the cast converts the stored binary to a string UUID.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function setKeysForSaveQuery($query)
    {
        $key = $this->getKey();
        $raw = $this->getRawOriginal($this->getKeyName())
            ?? (Str::isUuid($key) ? hex2bin(str_replace('-', '', $key)) : null);

        if ($raw === null) {
            throw new \RuntimeException("Cannot build save query: primary key [{$key}] is not a valid UUID.");
        }

        return $query->where($this->getKeyName(), $raw);
    }

    /**
     * Override newEloquentBuilder to return a builder that converts string
     * UUIDs to binary when querying by the primary key.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return UuidOnlyBuilder<static>
     */
    public function newEloquentBuilder($query)
    {
        return new UuidOnlyBuilder($query);
    }
}
