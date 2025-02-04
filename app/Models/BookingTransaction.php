<?php

namespace App\Models;

use App\Models\CarService;
use App\Models\CarStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'trx_id',
        'proof',
        'phone_number',
        'is_paid',
        'total_amount',
        'car_store_id',
        'car_service_id',
        'started_at',
        'time_at',
    ];

    /**
     * Get the service_details that owns the BookingTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service_details(): BelongsTo
    {
        return $this->belongsTo(CarService::class, 'car_service_id', 'id');
    }

    /**
     * Get the store_details that owns the BookingTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store_details(): BelongsTo
    {
        return $this->belongsTo(CarStore::class, 'car_store_id', 'id');
    }
}
