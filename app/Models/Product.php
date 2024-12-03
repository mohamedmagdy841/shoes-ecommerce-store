<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory, HasSlug;
    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'price',
        'status',
        'qty',
        'slug',
        'description',
        'color',
        'width',
        'height',
        'depth',
        'weight',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'product_id');
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlist')
            ->withTimestamps();
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getFullNameAttribute()
    {
        return $this->brand . " " . $this->name;
    }

//    public function scopeActive($query)
//    {
//        $query->where('status', 1);
//    }
}
