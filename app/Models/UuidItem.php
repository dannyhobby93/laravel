<?php

namespace App\Models;

use App\Models\Concerns\HasBinaryUuid;
use Database\Factories\UuidItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UuidItem extends Model
{
    /** @use HasFactory<UuidItemFactory> */
    use HasBinaryUuid, HasFactory;

    protected $table = 'uuid_only';

    // override from uuid
    protected $primaryKey = 'id';

    // this can be removed if the column is called uuid
    public function binaryUuidColumn(): string
    {
        return 'id';
    }

    public $incrementing = false;

    protected $fillable = [
        'name',
    ];
}
