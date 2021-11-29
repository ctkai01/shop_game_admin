<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduct extends Model
{
    use HasFactory;

    protected $table = 'detail_products';
    protected $guarded = [];
    
    const SOLD = 1;
    const NOT_SOLD = 0;

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
