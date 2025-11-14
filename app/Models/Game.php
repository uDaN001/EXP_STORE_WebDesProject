<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'genre',
        'platform',
        'developer',
        'publisher',
        'release_date',
        'price',
        'stock',
        'description',
        'image_url',
        'rating',
    ];

    /**
     * Relationships
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
