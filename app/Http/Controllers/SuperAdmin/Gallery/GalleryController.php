<?php

namespace App\Http\Controllers\SuperAdmin\Gallery;

use App\Helpers\DbHelper;
use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Gallery\GalleryRequest;
use App\Models\Service\SuperAdmin\Gallery\GalleryService;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;

class GalleryController extends Controller
{
    protected $gallery;
    protected $imageController;
    function __construct(GalleryService $gallery, ImageController $imageController)
    {
        $this->gallery=$gallery;
        $this->imageController=$imageController;
    }

    public function index($id)
    {
        $galleries=$this->gallery->paginate($id);
        $show_search='yes';
        $album_id=$id;
        return view('super-admin.gallery.index',compact('galleries','show_search','album_id'));
    }
    public function create($id)
    {
        $album_id=$id;
        return view('super-admin.gallery.create',compact('album_id'));
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
            $albumsInfo = $request->all();
            $albumsInfo['album_id'] = $request->get('album_id');
            $albumsInfo['order'] = DbHelper::nextSortOrder('galleries');
            $folder_name = 'Gallery';
            $ImgName = $this->imageController->saveOrgGallery($file, $folder_name);
            $albumsInfo['title'] = $ImgName;
            $albumsInfo['slug'] = Str::slug($ImgName);
            $albumsInfo['image'] = $ImgName;
            $this->gallery->create($albumsInfo);
        }
        Toastr::success('Gallery created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('albums.index');
    }

    public function edit($id,$albumId)
    {
        $gallery=$this->gallery->find($id);
        $album_id=$albumId;
        return view('super-admin.gallery.edit',compact('gallery','album_id'));
    }
    public function update(GalleryRequest $request, $id)
    {
        $galleryInfo=$request->all();
        $galleryInfo['slug'] = Str::slug($request->get('title'));
        $album=$this->gallery->find($id);
        $folder_name='Gallery';
        if($request->file('image')==''){
            $galleryInfo['image']=$album->image;
        }
        else{
            $this->imageController->deleteImg($folder_name,$album->image);
            $ImgName=$this->imageController->saveOrgImg($request,$folder_name,'image');
            $galleryInfo['image']=$ImgName;
        }
        if($this->gallery->update($id, $galleryInfo)){
            Toastr::success('Gallery updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('albums.index');
        }else{
            Toastr::error('Problem in updating gallery', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('albums.index');
        }
    }
    public function destroy($id)
    {
        $gallery=$this->gallery->find($id);
        if($this->gallery->delete($id)){
            $this->imageController->deleteImg('Gallery',$gallery->image);
            Toastr::success('Gallery deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('albums.index');
        }else{
            Toastr::error('Problem in deleting gallery', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('albums.index');
        }
    }
    public function search()
    {
        $galleries=$this->gallery->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.gallery.index',compact('galleries','show_search'));
    }

    function upload(Request $request)
    {
        foreach ($request->file('file') as $file) {
            $rules = array(

                'file' => 'required|mimes:jpeg,jpg,png,gif'

            );
            $validator = validator(array('file' => $file), $rules);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }
            $albumsInfo = $request->all();
            $albumsInfo['album_id'] = $request->get('album_id');
            $albumsInfo['slug'] = Str::slug($request->get('title'));
            $albumsInfo['order'] = DbHelper::nextSortOrder('galleries');
            $folder_name = 'Gallery';
            $ImgName = $this->imageController->saveGallery($file, $folder_name,900,600);
            $albumsInfo['title'] = trim(strip_tags(DbHelper::fileName($file->getClientOriginalName())));
            $albumsInfo['image'] = $ImgName;
            $this->gallery->create($albumsInfo);
        }
        Toastr::success('Gallery created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('albums.index');

        $image = $request->file('file');

        $imageName = time() . '.' . $image->extension();

        $image->move(public_path('images'), $imageName);

        return response()->json(['success' => $imageName]);
    }

    function fetch()
    {
        $images = \File::allFiles(public_path('images'));
        $output = '<div class="row">';
        foreach($images as $image)
        {
            $output .= '
      <div class="col-md-2" style="margin-bottom:16px;" align="center">
                <img src="'.asset('images/' . $image->getFilename()).'" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                <button type="button" class="btn btn-link remove_image" id="'.$image->getFilename().'">Remove</button>
            </div>
      ';
        }
        $output .= '</div>';
        echo $output;
    }

    function delete(Request $request)
    {
        if($request->get('name'))
        {
            File::delete(public_path('images/' . $request->get('name')));
        }
    }
}
