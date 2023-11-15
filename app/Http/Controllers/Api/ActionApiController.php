<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ImageController;
use App\Models\Service\SuperAdmin\Banner\ReferCustomerService;
use App\Models\Service\SuperAdmin\Product\ProductService;
use App\Models\Service\SuperAdmin\Menu\NavService;
use App\Models\Service\SuperAdmin\Page\PageService;
use App\Models\Service\SuperAdmin\Seo\SeoService;
use App\Models\Service\SuperAdmin\User\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActionApiController extends Controller
{
    protected $imageController;
    protected $user;
    protected $banner;
    protected $amenity;
    protected $amenityFaq;
    protected $page;
    protected $nav;
    protected $seo;
    protected $reservation;
    protected $product;

    function __construct(ImageController $imageController, UserService $user,
                         ReferCustomerService $banner, NavService $nav, PageService $page, SeoService $seo, ProductService $product)
    {
        $this->banner=$banner;
        $this->user=$user;
        $this->imageController=$imageController;
        $this->nav=$nav;
        $this->page=$page;
        $this->seo=$seo;
        $this->product=$product;
    }
    public function updateStatus(Request $request)
    {
        $name=$request->get('name');
        if($request->get('status')=='1'){
            return $this->$name->updateStatus($request->get('id'),$request->get('status'));
        }
        if($request->get('status')=='0'){
            return $this->$name->updateStatus($request->get('id'),$request->get('status'));
        }
    }
    public function deletePost(Request $request)
    {
        $name=$request->get('name');
        foreach ($request->get('id') as $id){
            $info=$this->$name->find($id);
            $this->imageController->deleteImg(ucfirst($request->get('name')),$info->image);
        }
        return $this->$name->deletePost($request->get('id'));
    }
}
