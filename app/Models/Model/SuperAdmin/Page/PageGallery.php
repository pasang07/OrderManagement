<?php

namespace App\Models\Model\SuperAdmin\Page;

use Illuminate\Database\Eloquent\Model;

class PageGallery extends Model
{
    protected $fillable=['title','page_id','slug','image','trip','status','order'];
    protected function getStatusTextAttribute()
    {
        return  ucwords(str_replace( '_', ' ',$this->status));
    }
}
