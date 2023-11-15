<?php

namespace App\Models\Model\SuperAdmin\OrderList;

use App\Models\Model\SuperAdmin\Product\Product;
use App\Models\Model\SuperAdmin\User\User;
use Illuminate\Database\Eloquent\Model;

class OrderListCancelbycustomer extends Model
{
    protected $fillable=['order_no','customer_id','product_id','qty','rate','amount','remarks','shipping_cost',
        'discount_percent', 'discount_cost', 'vat_percent', 'vat_cost', 'net_amount','estimate_delivery_date',
        'is_confirm','reject_notification','is_reviewed','order_status','status','order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function customer()
    {
        return $this->belongsTo(User::class);
    }

}
