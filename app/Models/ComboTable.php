<?php

namespace App\Models;

use App\Casts\BinaryUuidCast;
use App\Traits\HasBinaryUuidColumn;
use Database\Factories\ComboTableFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboTable extends Model
{
    /** @use HasFactory<ComboTableFactory> */
    use HasBinaryUuidColumn, HasFactory;

    protected $table = 'combo_table';

    public $incrementing = true;

    protected $fillable = ['name'];

    protected function casts(): array
    {
        return [
            'uuid' => BinaryUuidCast::class,
        ];
    }
}
