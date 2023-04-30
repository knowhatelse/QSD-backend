<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Size extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sizes';

    protected $fillable = [
        'size'
    ];

    public function productSize(): BelongsTo {
        return $this->belongsTo('App\Models\ProductSize');
    }
}
