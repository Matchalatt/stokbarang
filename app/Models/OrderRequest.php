<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_name',
        'current_stock',
        'required_stock',
        'order_quantity',
        'status',
        'price_per_item', // <-- Tambahkan ini
        'confirmed_order_quantity', // <-- Tambahkan ini
    ];

    /**
     * Mendapatkan user (sales) yang membuat request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}