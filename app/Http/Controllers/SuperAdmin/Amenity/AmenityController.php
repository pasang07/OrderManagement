<?php

namespace App\Http\Controllers\SuperAdmin\Amenity;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Amenity\AmenityRequest;
use App\Models\Service\SuperAdmin\Amenity\AmenityService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;
use App\Helpers\DbHelper as DbHelper;
class AmenityController extends Controller
{
   protected $amenity;
    protected $imageController;
    function __construct(AmenityService $amenity, ImageController $imageController)
    {
        $this->amenity=$amenity;
        $this->imageController=$imageController;
    }

    public function index()
    {
        $amenities=$this->amenity->paginate();
        $show_search='yes';
        return view('super-admin.amenity.index',compact('amenities','show_search'));
    }

    public function create()
    {
        return view('super-admin.amenity.create');
    }

    public function store(AmenityRequest $request)
    {
        $amenityInfo=$request->all();
        $amenityInfo['slug'] = Str::slug($request->get('title'));
        $amenityInfo['order']=DbHelper::nextSortOrder('amenities');
        if($request->file('image')){
            $folder_name='Amenity';
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',769,385);
            $amenityInfo['image']=$ImgName;
        }
        if($request->file('home_image')){
        $folder_name1='Amenity/SmallImage';
        $smallImgName=$this->imageController->saveAnyImg($request,$folder_name1,'home_image',65,65);
        $amenityInfo['home_image']=$smallImgName;
    }
        if($this->amenity->create($amenityInfo)){
            Toastr::success('Service created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }else{
            Toastr::error('Problem in creating service', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $amenity=$this->amenity->find($id);
        return view('super-admin.amenity.edit',compact('amenity'));
    }
    public function update(AmenityRequest $request, $id)
    {
        $amenityInfo=$request->all();
//        $amenityInfo['slug'] = Str::slug($request->get('title'));
        $amenity=$this->amenity->find($id);

        $folder_name='Amenity';
        if($request->file('image')==''){
            if($request->get('delete_image')){
                $this->imageController->deleteImg($folder_name,$amenity->image);
                $amenityInfo['image'] = NULL;
            }else {
                $amenityInfo['image']=$amenity->image;
            }
        }
        else{
            $this->imageController->deleteImg($folder_name,$amenity->image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',769,385);
            $amenityInfo['image']=$ImgName;
        }

        $folder_name1='Amenity/SmallImage';
        if($request->file('home_image')==''){
            if($request->get('delete_home_image')){
                $this->imageController->deleteImg($folder_name1,$amenity->home_image);
                $amenityInfo['home_image'] = NULL;
            }else {
                $amenityInfo['home_image'] = $amenity->home_image;
            }
        }
        else{
            $this->imageController->deleteImg($folder_name1,$amenity->home_image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name1,'home_image',65,65);
            $amenityInfo['home_image']=$ImgName;
        }

        if($this->amenity->update($id, $amenityInfo)){
            Toastr::success('Service updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }else{
            Toastr::error('Problem in updating service', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }
    }
    public function destroy($id)
    {
        $amenity=$this->amenity->find($id);
        if($this->amenity->delete($id)){
            $this->imageController->deleteImg('Amenity',$amenity->image);
            $this->imageController->deleteImg('Amenity/SmallImage',$amenity->home_image);
            Toastr::success('Service deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }else{
            Toastr::error('Problem in deleting service', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }
    }
    public function search()
    {
        $amenities=$this->amenity->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.amenity.index',compact('amenities','show_search'));
    }
}
