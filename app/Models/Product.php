<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['name', 'product_code', 'price', 'safety_stock', 'lead_time_days'];

    public function transactions(): HasMany
    {
        return $this->hasMany(StockTransaction::class, 'product_id');
    }
}
