<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    protected $fillable = [
        'product_id',
        'category_id',
    ];

    public function product(): BelongsTo {
        return $this->belongsTo('App\Models\Product');
    }

    public function categories(): BelongsTo {
        return $this->belongsTo('App\Models\Category');
    }
}
