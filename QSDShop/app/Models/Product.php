<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $all)
 * @method static find($id)
 */

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
       'name',
       'price',
       'category_id',
       'brand_id',
       'color_id',
       'product_rating_id',
       'image_id',
       'availability_state',
       'gender'];

    public function brand(): BelongsTo {
        return $this->belongsTo(Brand::class);
    }
    public function color(): HasOne {
        return $this->hasOne(Color::class);
    }
    public function ProductRating(): HasMany {
        return $this->hasMany(ProductRating::class);
    }
    public function images(): HasMany {
        return $this->hasMany(Images::class);
    }
    public function CategoryProduct(): BelongsTo {
        return $this->belongsTo(CategoryProduct::class);
    }
    public function favorites(): HasMany {
        return $this->hasMany(Favorite::class);
    }
}
