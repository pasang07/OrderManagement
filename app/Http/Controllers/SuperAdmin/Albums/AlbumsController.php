<?php

namespace App\Http\Controllers\SuperAdmin\Albums;

use App\Helpers\DbHelper;
use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Albums\AlbumsRequest;
use App\Models\Service\SuperAdmin\Albums\AlbumsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;

class AlbumsController extends Controller
{
    protected $albums;
    protected $imageController;
    function __construct(AlbumsService $albums, ImageController $imageController)
    {
        $this->albums=$albums;
        $this->imageController=$imageController;
    }

    public function index()
    {
        $albums=$this->albums->paginate();
        $show_search='yes';
        return view('super-admin.albums.index',compact('albums','show_search'));
    }
    public function create()
    {
        return view('super-admin.albums.create');
    }
    public function store(AlbumsRequest $request)
    {
        $albumsInfo=$request->all();
        $albumsInfo['slug'] = Str::slug($request->get('title'));
        $albumsInfo['order']=DbHelper::nextSortOrder('albums');

        if($request->file('image')){
            $ImgName=$this->imageController->saveAnyImg($request,"Albums",'image',900,600);
            $albumsInfo['image']=$ImgName;
        }
        if($this->albums->create($albumsInfo)){
            Toastr::success('Albums created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('albums.index');
        }else{
            Toastr::error('Problem in creating albums', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('albums.index');
        }
    }
    public function edit($id)
    {
        $album=$this->albums->find($id);
        return view('super-admin.albums.edit',compact('album'));
    }
    public function update(AlbumsRequest $request, $id)
    {
        $albumsInfo=$request->all();
        $albumsInfo['slug'] = Str::slug($request->get('title'));
        $albums=$this->albums->find($id);
        if($request->file('image')==''){
            if($request->get('delete_image')){
                $this->imageController->deleteImg("Albums",$albums->image);
                $albumsInfo['image'] = NULL;
            }else {
                $albumsInfo['image'] = $albums->image;
            }
        }
        else{
            $this->imageController->deleteImg("Albums",$albums->image);
            $ImgName=$this->imageController->saveAnyImg($request,"Albums",'image',900,600);
            $albumsInfo['image']=$ImgName;
        }
        if($this->albums->update($id, $albumsInfo)){
            Toastr::success('Albums updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('albums.index');
        }else{
            Toastr::error('Problem in updating albums', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('albums.index');
        }
    }
    public function destroy($id)
    {
        if($this->albums->delete($id)){
            Toastr::success('Albums deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('albums.index');
        }else{
            Toastr::error('Problem in deleting albums', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('albums.index');
        }
    }
    public function search()
    {
        $albums=$this->albums->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.albums.index',compact('albums','show_search'));
    }
}
