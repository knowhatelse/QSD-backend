<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'availability_state',
        'total_rating',
        'average_rating',
        'is_favorite',
        'gender',
        'brand_id',
        'color_id',
    ];



    public function productSizes(): BelongsToMany {
        return $this->belongsToMany(ProductSize::class, 'product_sizes');
    }

    public function brands(): BelongsTo {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function colors(): BelongsTo {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function rating(): HasMany {
        return $this->hasMany('App\Models\Rating');
    }

    public function favorite(): HasMany {
        return $this->hasMany('App\Models\Favorite');
    }

    public function image(): HasMany {
        return $this->hasMany('App\Models\Image');
    }

    public function productCategories(): BelongsTo {
        return $this->belongsTo('App\Models\ProductCategory');
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function sizes(): BelongsToMany {
        return $this->belongsToMany(Size::class, 'product_sizes');
    }

}
