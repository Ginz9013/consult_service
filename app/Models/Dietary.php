<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dietary extends Model
{
    use HasFactory;

    public function daily() {
        
        return $this->belongsTo('App\Models\Dietary');
    }
}
