<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Color extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'colors';

    protected $fillable = [
        'name',
        'hex_code'
    ];

    public function product(): BelongsTo {
        return $this->belongsTo('App\Models\Product');
    }
}
