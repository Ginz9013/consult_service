<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Diet;

class Daily extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'weight',
        'body_fat',
        'awake',
        'sleep',
        'water_morning',
        'water_afternoon',
        'water_evening',
        'water_another',
        'coffee',
        'tea',
        'sport',
        'defecation',
        'note'
    ];

    public function user() {

        return $this->belongsTo(User::class);
    }

    public function diets() {
        
        return $this->hasMany(Diet::class);
    }
}
