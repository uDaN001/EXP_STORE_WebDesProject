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
        'is_on_sale',
        'sale_percentage',
        'stock',
        'description',
        'image_url',
        'rating',
    ];

    protected $casts = [
        'is_on_sale' => 'boolean',
        'sale_percentage' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    /**
     * Get the sale price if on sale
     */
    public function getSalePriceAttribute()
    {
        if ($this->is_on_sale && $this->sale_percentage) {
            return $this->price * (1 - ($this->sale_percentage / 100));
        }
        return $this->price;
    }

    /**
     * Relationships
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
