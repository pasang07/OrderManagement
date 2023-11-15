<?php

namespace App\Models\Model\SuperAdmin\Commission;

use App\Models\Model\SuperAdmin\OrderList\OrderList;
use App\Models\Model\SuperAdmin\Product\Product;
use App\Models\Model\SuperAdmin\AgentCommission\AgentCommission;
use App\Models\Model\SuperAdmin\User\User;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable=['agent_commission_id','order_no','product_id','customer_id','qty','amount','received_date','status','order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function agents()
    {
        return $this->hasMany('App\Models\Model\SuperAdmin\User\User','agent_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }
}
