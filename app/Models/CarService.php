<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\StoreService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarService extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'price',
        'about',
        'icon',
        'photo',
        'duration_in_hour',
    ];

    /**
     * Get all of the storeServices for the CarService
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storeServices(): HasMany
    {
        return $this->hasMany(StoreService::class, 'car_service_id', 'id');
    }

      // penting
    // auto slug
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

}
