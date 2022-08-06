<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'active',
    ];
    
    protected $fillable = [
        'sku',
        'name',
        'brand',
        'img',
        'kaspi_price',
        'supplier_id',
        'active',
    ];

    public function scopeSearch($query, $val) {
        return $query
            ->where('sku', 'like', '%' . $val . '%')
            ->orWhere('name', 'like', '%' . $val . '%')
            ->orWhere('brand', 'like', '%' . $val . '%')
            ->orWhere('kaspi_price', 'like', '%' . $val . '%');
    }

    public function scopeSearchName($query, $val) {
        return $query
            ->Where('name', 'like', '%' . $val . '%')
            ->orWhere('sku', 'like', '%' . $val . '%');
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouses() {
        return $this->belongsToMany(Warehouse::class)->withPivot('quantity', 'price')->withTimestamps();
    }

    public function getQuantityAttribute() {
        $quantity = 0;
        if ($this->warehouses()->exists()) {
            foreach ($this->warehouses as $warehouse) {
                $quantity += $warehouse->pivot->quantity;
            }
        }
        return $quantity;
    }
}
