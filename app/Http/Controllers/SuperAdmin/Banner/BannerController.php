<?php

namespace App\Http\Controllers\SuperAdmin\Banner;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Banner\ReferCustomerRequest;
use App\Models\Service\SuperAdmin\Banner\ReferCustomerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;
use App\Helpers\DbHelper as DbHelper;
class BannerController extends Controller
{
   protected $banner;
    protected $imageController;
    function __construct(ReferCustomerService $banner, ImageController $imageController)
    {
        $this->banner=$banner;
        $this->imageController=$imageController;
    }

    public function index()
    {
        $banners=$this->banner->paginate();
        $show_search='yes';
        return view('super-admin.banner.index',compact('banners','show_search'));
    }

    public function create()
    {
        return view('super-admin.banner.create');
    }

    public function store(ReferCustomerRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'image'=>'required|mimes:jpeg,jpg,png,gif',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        $bannerInfo=$request->all();
        $bannerInfo['slug'] = Str::slug($request->get('title'));
        $bannerInfo['order']=DbHelper::nextSortOrder('banners');
        $extension = $request->file('image')->extension();
        $folder_name='Banner';
        if($extension == 'gif'){
            $ImgName=$this->imageController->saveAnyFile($request,$folder_name,'image');
            $bannerInfo['image']=$ImgName;
        }else{
            $ImgName=$this->imageController->saveBannerImg($request,$folder_name,'image',1920,881);
            $bannerInfo['image']=$ImgName;
        }
        if($this->banner->create($bannerInfo)){
            Toastr::success('Banner created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('banner.index');
        }else{
            Toastr::error('Problem in creating banner', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('banner.index');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $banner=$this->banner->find($id);
        return view('super-admin.banner.edit',compact('banner'));
    }
    public function update(ReferCustomerRequest $request, $id)
    {
        $bannerInfo=$request->all();
        $bannerInfo['slug'] = Str::slug($request->get('title'));
        $banner=$this->banner->find($id);
        $folder_name='Banner';
        if($request->file('image')==''){

            $bannerInfo['image']=$banner->image;
        }
        else{
            $this->imageController->deleteImg($folder_name,$banner->image);
            $extension = $request->file('image')->extension();
            if($extension == 'gif'){
                $ImgName=$this->imageController->saveAnyFile($request,$folder_name,'image');
                $bannerInfo['image']=$ImgName;
            }else{
                $ImgName=$this->imageController->saveBannerImg($request,$folder_name,'image',1920,881);
                $bannerInfo['image']=$ImgName;
            }
        }
        if($this->banner->update($id, $bannerInfo)){
            Toastr::success('Banner updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('banner.index');
        }else{
            Toastr::error('Problem in updating Banner', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('banner.index');
        }
    }
    public function destroy($id)
    {
        $banner=$this->banner->find($id);
        if($this->banner->delete($id)){
            $this->imageController->deleteImg('Banner',$banner->image);
            Toastr::success('Banner deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('banner.index');
        }else{
            Toastr::error('Problem in deleting banner', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('banner.index');
        }
    }
    public function search()
    {
        $banners=$this->banner->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.banner.index',compact('banners','show_search'));
    }
    
    public function bannerOption()
    {
        return view('super-admin.banner.option');
    }
}
