<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;

    public function user() {

        return $this->belongsTo('App\Models\User');
    }

    public function dietaries() {
        
        return $this->hasMany('App\Models\Dietary');
    }
}
