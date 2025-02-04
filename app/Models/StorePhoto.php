<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StorePhoto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'photo',
        'car_store_id'
    ];

}
