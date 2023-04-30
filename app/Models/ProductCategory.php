<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function product(): HasMany {
        return $this->hasMany('App\Models\Product');
    }

    public function category(): HasMany {
        return $this->hasMany('App\Models\Category');
    }
}
