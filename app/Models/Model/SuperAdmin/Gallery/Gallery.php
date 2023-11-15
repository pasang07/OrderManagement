<?php

namespace App\Models\Model\SuperAdmin\Gallery;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable=['album_id','title','slug','image','status','order'];
    protected function getStatusTextAttribute()
    {
        return  ucwords(str_replace( '_', ' ',$this->status));
    }
    public function album()
    {
        return $this->belongsTo('App\Models\Model\SuperAdmin\Gallery\Gallery','album_id');
    }
}
