<?php

namespace App\Models\Model\SuperAdmin\Seo;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable=['title','slug','image','seo_title','seo_keywords','seo_description'];
}
