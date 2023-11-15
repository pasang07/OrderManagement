<?php

namespace App\Models\Model\SuperAdmin\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=['parent_id','title','slug','image','content','batch_no','bottle_case','status','order'];

    public function moq()
    {
        return $this->hasMany('App\Models\Model\SuperAdmin\Product\Moq','product_id');
    }
    public function orders()
    {
        return $this->hasMany('App\Models\Model\SuperAdmin\OrderList\OrderList','product_id');
    }
}
