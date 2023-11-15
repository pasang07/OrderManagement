<?php

namespace App\Http\Controllers\FrontEnd\Page;

use App\Models\Model\SuperAdmin\Amenity\Amenity;
use App\Models\Model\SuperAdmin\Page\Page;
use App\Http\Controllers\Controller;
use App\Models\Model\SuperAdmin\Seo\Seo;
use App\Models\Model\SuperAdmin\Service\Service;
use TreeHelper;

class PageController extends Controller
{
    public function index($slug)
    {
//        $data['model'] = Page::where('slug', $slug)->firstOrFail();
        $data['model'] = Page::where('slug', $slug)
            ->with(array('gallery' => function($query) {
                $query->orderBy('order', 'asc')->get();
            }))
            ->firstOrFail();
        $data['meta_title'] = $data['model']->seo_title ? $data['model']->seo_title : $data['model']->title;
        $data['meta_keywords'] = $data['model']->seo_keywords;
        $data['meta_description'] = $data['model']->seo_description;

        if($slug=='about-us'){
            $data['image'] = Seo::where('slug', 'about-us')->first()->image;
            return view('front-end.page.about',$data);
        }else{
            return view('front-end.page.page',$data);
        }
    }
}
