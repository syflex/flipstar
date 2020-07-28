<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'user_id','name','amount','is_completed'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
