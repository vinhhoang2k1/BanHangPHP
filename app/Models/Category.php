<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getThumbnailPathAttribute() {
        if (empty($this->attributes['thumbnail'])) {
            return 'assets/img/thumbnail.png';
        }

        return 'storage/' . $this->attributes['thumbnail'];
    }

    public function getCreatedAtFormatAttribute() {
        return Carbon::parse($this->attributes['created_at'])->format('d-m-Y');
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
