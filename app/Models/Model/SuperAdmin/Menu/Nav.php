<?php

namespace App\Models\Model\SuperAdmin\Menu;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    protected $fillable=['title','nav_icon','parent_id','slug','url','image','type','type_id','target','order','show_image','status'];
    protected function getStatusTextAttribute()
    {
        return  ucwords(str_replace( '_', ' ',$this->status));
    }
    public function childs()
    {
        return $this->hasMany('App\Models\Model\SuperAdmin\Menu\Nav','parent_id');
    }
}
