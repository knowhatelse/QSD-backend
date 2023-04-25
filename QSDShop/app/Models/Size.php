<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Size extends Model
{
    use HasFactory;

    public function ProductSize(): HasOne {
        return $this->hasOne(ProductSize::class);
    }
}
