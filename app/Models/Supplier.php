<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $casts = [
        'nds',
        'rrc',
        'active',
    ];
    
    protected $fillable = [
        'name',
        'nds',
        'rrc',
        'bonus',
        'info',
        'active',
    ];

    public static function isActive() {
        return Supplier::where('active', 1)->get();
    }

    public function scopeSearch($query, $val) {
        return $query
            ->where('name', 'like', '%' . $val . '%')
            ->orWhere('bonus', 'like', '%' . $val . '%')
            ->orWhere('info', 'like', '%' . $val . '%');
    }
}
