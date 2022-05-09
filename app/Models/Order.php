<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function getTotalMoneyFormatAttribute() {
        return number_format($this->attributes['total_money'], 0 , ',', '.');
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }
}
