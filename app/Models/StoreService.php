<?php

namespace App\Models;

use App\Models\CarService;
use App\Models\CarStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreService extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'store_services';

    protected $fillable = [
      'car_service_id',
      'car_store_id'
    ];

    /**
     * Get the store that owns the StoreService
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(CarStore::class, 'car_store_id', 'other_key');
    }

    /**
     * Get the service that owns the StoreService
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(CarService::class, 'foreign_key', 'other_key');
    }
}
