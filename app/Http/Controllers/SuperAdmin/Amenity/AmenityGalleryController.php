<?php

namespace App\Http\Controllers\SuperAdmin\Amenity;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Amenity\AmenityGalleryRequest;
use App\Models\Service\SuperAdmin\Amenity\AmenityGalleryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\DbHelper as DbHelper;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;

class AmenityGalleryController extends Controller
{
    protected $amenityGallery;
    protected $imageController;
    function __construct(AmenityGalleryService $amenityGallery, ImageController $imageController)
    {
        $this->amenityGallery=$amenityGallery;
        $this->imageController=$imageController;
    }
    public function index($id)
    {
        $amenityGalleries=$this->amenityGallery->paginate($id);
        $show_search='yes';
        $amenity_id =$id;
        return view('super-admin.amenity.gallery.index',compact('amenityGalleries','show_search','amenity_id'));
    }
    public function create($id)
    {
        $amenity_id=$id;
        return view('super-admin.amenity.gallery.create',compact('amenity_id'));
    }
    public function store(Request $request)
    {
        foreach ($request->file('image') as $file) {
            $rules = array(
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:500000'
            );
            $validator = validator(array('image' => $file), $rules);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }
            $amenityGalleryInfo = $request->all();
            $amenityGalleryInfo['amenity_id'] = $request->get('amenity_id');
            $amenityGalleryInfo['order'] = DbHelper::nextSortOrder('amenity_galleries');
            $folder_name = 'AmenityGallery';
            $ImgName = $this->imageController->saveGallery($file, $folder_name,900,600);
            $amenityGalleryInfo['title'] = $ImgName;
            $amenityGalleryInfo['slug'] = Str::slug($ImgName);
            $amenityGalleryInfo['image'] = $ImgName;
            $this->amenityGallery->create($amenityGalleryInfo);
        }
        Toastr::success('Image created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('service.index');
    }
    public function edit($id,$amenityId)
    {
        $amenityGallery=$this->amenityGallery->find($id);
        $amenity_id=$amenityId;
        return view('super-admin.amenity.gallery.edit',compact('amenityGallery','amenity_id'));
    }
    public function update(AmenityGalleryRequest $request, $id)
    {
        $amenityGalleryInfo=$request->all();
        $amenityGalleryInfo['slug'] = Str::slug($request->get('title'));
        $amenityImage=$this->amenityGallery->find($id);
        $folder_name='AmenityGallery';
        if($request->file('image')==''){
            $amenityGalleryInfo['image']=$amenityImage->image;
        }
        else{
            $this->imageController->deleteImg($folder_name,$amenityImage->image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',900,600);
            $amenityGalleryInfo['image']=$ImgName;
        }

        if($this->amenityGallery->update($id, $amenityGalleryInfo)){
            Toastr::success('Service Gallery updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }else{
            Toastr::error('Problem in updating service gallery.', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }
    }
    public function destroy($id)
    {
        $amenityGallery=$this->amenityGallery->find($id);
        if($this->amenityGallery->delete($id)){
            Toastr::success('Service Gallery deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }else{
            Toastr::error('Problem in deleting gallery.', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }
    }
    public function search()
    {
        $amenityGalleries=$this->amenityGallery->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.amenity.gallery.index',compact('amenityGalleries','show_search'));
    }
}
