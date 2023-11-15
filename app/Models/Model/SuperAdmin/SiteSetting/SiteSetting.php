<?php

namespace App\Models\Model\SuperAdmin\SiteSetting;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable=['title','email','email_2','email_3','tel_no','mobile_no','logo_image',
        'bank_details','seo_title','seo_keywords','seo_description'];
}
