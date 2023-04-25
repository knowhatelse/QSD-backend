<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductSize extends Model
{
    use HasFactory;

    public function size(): HasMany {
        return $this->hasMany(Size::class);
    }
    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }
    public function OrderProductSize(): BelongsTo {
        return $this->belongsTo(OrderProductSize::class);
    }
}
