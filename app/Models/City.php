<?php

namespace App\Models;

use App\Models\CarStore;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug'
    ];


    /**
     * Get all of the comments for the City
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stores(): HasMany
    {
        return $this->hasMany(CarStore::class);
    }

    // penting
    // auto slug
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }


}
