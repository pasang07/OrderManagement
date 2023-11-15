<?php

namespace App\Http\Controllers\FrontEnd\Albums;

use App\Models\Model\SuperAdmin\Albums\Albums;
use App\Models\Model\SuperAdmin\Gallery\Gallery;
use App\Models\Model\SuperAdmin\Seo\Seo;
use App\Http\Controllers\Controller;

class AlbumsController extends Controller
{
    public function index()
    {
        $data['albums'] =  Albums::with(array('gallery' => function($query)
        {
            $query->where('status','active')->paginate(9);
        }))
            ->where('status', 'active')
            ->orderBy('order', 'asc')
            ->paginate(12);
            
        $data['galleries'] = Gallery::where('status', 'active')
            ->orderBy('order', 'asc')
            ->paginate(24);
        $data['model'] = Seo::where('slug', 'albums')->first();
        if($data['model']) {
            $data['meta_title'] = $data['model']->seo_title ? $data['model']->seo_title : $data['model']->title;
            $data['meta_keywords'] = $data['model']->seo_keywords;
            $data['meta_description'] = $data['model']->seo_description;
        }

        return view('front-end.albums.index',$data);
    }
    public function gallery($slug) {
//        dd($slug);
        $data['images'] = Albums::where('slug', $slug)
            ->with(array('gallery' => function($query) {
                $query->where('status', 'active');
                $query->orderBy('order', 'asc')->get();
            }))
            ->firstOrFail();

        $data['model'] = Seo::where('slug', 'albums')->first();
        if($data['model']) {
            $data['meta_title'] = $data['model']->seo_title ? $data['model']->seo_title : $data['model']->title;
            $data['meta_keywords'] = $data['model']->seo_keywords;
            $data['meta_description'] = $data['model']->seo_description;
        }

        return View('front-end.albums.gallery', $data);
    }
}
