<?php

namespace App\Models\Model\SuperAdmin\Albums;

use Illuminate\Database\Eloquent\Model;

class Albums extends Model
{
    protected $fillable=['trip_id','title','slug','content','image','seo_title','seo_keywords','seo_description','status','order'];
    protected function getStatusTextAttribute()
    {
        return  ucwords(str_replace( '_', ' ',$this->status));
    }
    public function trip()
    {
        return $this->belongsTo('App\Models\Model\SuperAdmin\Trip\Trip','trip_id');
    }
    public function gallery()
    {
        return $this->hasMany('App\Models\Model\SuperAdmin\Gallery\Gallery','album_id');
    }
}
