<?php

namespace App\Models\Model\SuperAdmin\AgentCommission;

use App\Models\Model\SuperAdmin\Product\Product;
use App\Models\Model\SuperAdmin\User\User;
use Illuminate\Database\Eloquent\Model;

class AgentCommission extends Model
{
    protected $fillable=['agent_id','product_id','price_per_bottle','overall_commission','status','order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function agent()
    {
        return $this->belongsTo(User::class);
    }
}
