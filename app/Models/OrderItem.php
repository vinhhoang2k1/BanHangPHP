<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getPriceFormatAttribute() {
        return number_format($this->attributes['price'], 0 , ',', '.');
    }

    public function getTotalMoneyFormatAttribute() {
        return number_format($this->attributes['total_money'], 0 , ',', '.');
    }
}
