<?php

namespace App\Models;

use App\Models\City;
use App\Models\StorePhoto;
use App\Models\StoreService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CarStore extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = [
        'name',
        'slug',
        'thumbnail',
        'is_open',
        'is_full',
        'city_id',
        'address',
        'phone_number',
        'cs_name'
    ];

    /**
     * Get all of the storeServices for the CarStore
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storeServices(): HasMany
    {
        return $this->hasMany(StoreService::class, 'car_store_id', 'id');
    }

    /**
     * Get all of the photos for the CarStore
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(StorePhoto::class, 'car_store_id', 'id');
    }

    /**
     * Get the city that owns the CarStore
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

      // penting
    // auto slug
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

}
