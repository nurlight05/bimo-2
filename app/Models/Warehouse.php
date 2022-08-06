<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    public function getTotalAttribute() {
        $total = 0;
        
        if ($this->products()->exists()) {
            $products = $this->products;
            foreach ($products as $item) {
                $quantity = $item->pivot->quantity;
                $price = $item->pivot->price;
                $total += $quantity * $price;
            }
        }
    
        return $total;
    }

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price')->withTimestamps();
    }
}
