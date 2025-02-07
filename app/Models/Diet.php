<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Daily;

class Diet extends Model
{
    use HasFactory;

    protected $fillable = [
        'time',
        'staple',
        'meat',
        'fruit',
        'vegetable',
        'fat',
        'description',
        'img_url_1',
        'img_url_2',
        'img_url_3'
    ];

    public function daily() {
        
        return $this->belongsTo(Daily::class);
    }
}
