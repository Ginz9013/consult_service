<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Dietary;

class Daily extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'weight',
        'body_fat',
        'note',
        'water_morning',
        'water_afternoon',
        'water_evening',
        'water_another',
        'coffee',
        'tea'
    ];

    public function user() {

        return $this->belongsTo(User::class);
    }

    public function dietaries() {
        
        return $this->hasMany(Dietary::class);
    }
}
