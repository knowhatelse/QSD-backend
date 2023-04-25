<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public function brand(): BelongsTo {
        return $this->belongsTo(Brand::class);
    }
    public function color(): BelongsTo {
        return $this->belongsTo(Color::class);
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
