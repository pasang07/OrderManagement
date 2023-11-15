<?php

namespace App\Http\Controllers\FrontEnd\Product;

use Illuminate\Support\Facades\DB;
use App\Models\Model\SuperAdmin\Seo\Seo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data['model'] = Seo::where('slug', 'products')->first();
        if($data['model']) {
            $data['meta_title'] = $data['model']->seo_title ? $data['model']->seo_title : $data['model']->title;
            $data['meta_keywords'] = $data['model']->seo_keywords;
            $data['meta_description'] = $data['model']->seo_description;
        }

        return view('front-end.product.index',$data);
    }

}
