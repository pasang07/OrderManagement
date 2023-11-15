<?php

namespace App\Models\Model\SuperAdmin\Blog;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $fillable=['title','slug'];
    public function blogs()
    {
        return $this->hasMany('App\Models\Model\SuperAdmin\Blog\Blog','category_id');
    }
}


