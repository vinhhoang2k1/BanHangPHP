<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getThumbnailPathAttribute() {
        if (empty($this->attributes['thumbnail'])) {
            return 'assets/img/thumbnail.png';
        }

        return 'storage/' . $this->attributes['thumbnail'];
    }

    public function getPriceFormatAttribute() {
        return number_format($this->attributes['price'], 0, ',', '.');
    }
}

