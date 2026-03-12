<?php

namespace App\Models;

use App\Casts\BinaryUuidCast;
use App\Traits\HasBinaryUuidColumn;
use Database\Factories\UuidOnlyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UuidOnly extends Model
{
    /** @use HasFactory<UuidOnlyFactory> */
    use HasBinaryUuidColumn, HasFactory;

    protected $table = 'uuid_only';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['name', 'uuid'];

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
        $raw = $this->getRawOriginal($this->getKeyName())
            ?? hex2bin(str_replace('-', '', $this->getKey()));

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
