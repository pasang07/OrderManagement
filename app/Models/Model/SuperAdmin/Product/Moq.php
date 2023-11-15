<?php

namespace App\Models\Model\SuperAdmin\Product;

use Illuminate\Database\Eloquent\Model;

class Moq extends Model
{
    protected $fillable=['product_id','batch_no','bottle_case','moq_low','moq_high','rate','amount','status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
