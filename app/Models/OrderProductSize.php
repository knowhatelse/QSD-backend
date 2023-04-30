<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderProductSize extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_product_sizes';

    protected $fillable = [
        'quantity'
    ];

    public function order(): HasMany {
        return $this->hasMany('App\Models\Order');
    }

    public function productSize(): HasMany {
        return $this->hasMany('App\Models\ProductSize');
    }
}
