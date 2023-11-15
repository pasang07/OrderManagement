<?php

namespace App\Models\Model\SuperAdmin\Blog;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Blog extends Model implements Searchable, HasMedia
{
    use HasMediaTrait;
    protected $fillable=['title','category_id','slug','author','tags','image','inner_image','content','views','seo_title','seo_keywords','seo_description','status','order'];
    protected function getStatusTextAttribute()
    {
    return  ucwords(str_replace( '_', ' ',$this->status));
    }
    public function blog_category()
    {
        return $this->belongsTo('App\Models\Model\SuperAdmin\Blog\BlogCategory','category_id');
    }
    public function getSearchResult(): SearchResult
    {
        $url = route('blog-single', $this->slug);
        $image='Blog/thumbnail/'.$this->image;
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url,
            $this->content,
            $image
        );
    }
}
