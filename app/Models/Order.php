<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'total_price',
        'payment_mode',
        'planned_delivery_date',
        'creation_date',
        'delivery_mode',
        'state',
        'status',
        'delivery_cost',
    ];

    public function products() {
        return $this->belongsToMany(Product::class);
    }

    public function getStatusTitleAttribute() {
        $status = $this->warehouse_status;
        switch ($status) {
            case 0:
                return 'Новый заказ';
                break;
            
            case 1:
                return 'Нет в наличии';
                break;
            
            default:
                return null;
                break;
        }
    }

    public function getInStockAttribute() {
        if ($this->products()->exists()) {
            foreach ($this->products as $product) {
                if ($product->quantity == 0)
                    return false;
            }
            return true;
        }
        return false;
    }
}
