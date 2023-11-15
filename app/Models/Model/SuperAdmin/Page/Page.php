<?php

namespace App\Models\Model\SuperAdmin\Page;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Page extends Model implements Searchable
{
    protected $fillable=['parent_id','title','slug','url','image','content','seo_title','seo_keywords','seo_description','status','order'];
    protected function getStatusTextAttribute()
    {
        return  ucwords(str_replace( '_', ' ',$this->status));
    }
    public function childs()
    {
        return $this->hasMany('App\Models\Model\SuperAdmin\Page\Page','parent_id');
    }

    public function gallery()
    {
        return $this->hasMany('App\Models\Model\SuperAdmin\Page\PageGallery','page_id');
    }
    public function getSearchResult(): SearchResult
    {
        $url = route('page', $this->slug);
        if($this->image){
            $image='Page/thumbnail/'.$this->image;
        }else{
            $image=NULL;
        }
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url,
            $this->content,
            $image
        );
    }
}
