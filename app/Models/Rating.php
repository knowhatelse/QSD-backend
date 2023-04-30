<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ratings';

    protected $fillable = [
        'number'
    ];

    public function product(): BelongsTo {
        return $this->belongsTo('App\Models\Product');
    }

    public function user(): BelongsTo {
        return $this->belongsTo('App\Models\User');
    }
}
