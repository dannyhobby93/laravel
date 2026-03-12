<?php

namespace App\Models;

use App\Models\Concerns\HasBinaryUuid;
use Database\Factories\ComboItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboItem extends Model
{
    /** @use HasFactory<ComboItemFactory> */
    use HasBinaryUuid, HasFactory;

    protected $table = 'combo_table';

    protected $fillable = [
        'uuid',
        'name',
    ];
}
