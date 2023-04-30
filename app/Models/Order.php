<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    protected $fillable = [
        'total',
        'address',
        'city',
        'zip_code',
        'phone'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo('App\Models\User');
    }

    public function orderProductSize(): BelongsTo {
        return $this->belongsTo('App\Models\OrderProductSize');
    }
}
