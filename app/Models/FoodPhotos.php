<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodPhotos extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'photo',
        'food_id',
    ];

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
    
}
