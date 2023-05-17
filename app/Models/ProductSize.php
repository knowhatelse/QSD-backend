<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductSize extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_sizes';

    protected $fillable = [
        'amount',
        'product_id',
        'size_id'
    ];

    public function product(): HasMany {
        return $this->hasMany('App\Models\Product');
    }

    public function size(): HasMany {
        return $this->hasMany('App\Models\Size');
    }

    public function orderProductSize(): BelongsTo {
        return $this->belongsTo('App\Models\OrderProductSize');
    }
}
