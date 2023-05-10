<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidationKey extends Model
{
    use HasFactory;

    protected $fillable=['user_id','validationKey'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
