<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    /** @use HasFactory<\Database\Factories\ListingFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        "type",
        "brand",
        "model",
        "version",
        "year_model",
        "year_build",
        "optionals",
        "doors",
        "board",
        "chassi",
        "transmission",
        "km",
        "description",
        "created",
        "updated",
        "sold",
        "category",
        "url_car",
        "price",
        "old_price",
        "color",
        "fuel",
    ];

    protected $casts = [
        'created' => 'datetime',
        'updated' => 'datetime',
        'sold' => 'boolean',
        'optionals' => 'array',
    ];

    public $timestamps = false;

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
