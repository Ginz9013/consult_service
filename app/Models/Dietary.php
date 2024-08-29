<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Daily;

class Dietary extends Model
{
    use HasFactory;

    protected $fillable = [
        'time',
        'staple',
        'meat',
        'fruit',
        'vegetable',
        'fat',
        'description'
    ];

    public function daily() {
        
        return $this->belongsTo(Daily::class);
    }
}
