<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'gender'
    ];

    public function productSize(): BelongsTo {
        return $this->belongsTo('App\Models\ProdutcSize');
    }

    public function brand(): HasOne {
        return $this->hasOne('App\Models\Brand');
    }

    public function color(): HasOne {
        return $this->hasOne('App\Models\Color');
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

    public function productCategory(): BelongsTo {
        return $this->belongsTo('App\Models\ProductCategory');
    }
}
