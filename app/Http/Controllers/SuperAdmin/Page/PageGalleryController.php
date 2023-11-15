<?php

namespace App\Http\Controllers\SuperAdmin\Page;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Page\PageGalleryRequest;
use App\Models\Service\SuperAdmin\Page\PageGalleryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\DbHelper as DbHelper;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;

class PageGalleryController extends Controller
{
    protected $pageGallery;
    protected $imageController;
    function __construct(PageGalleryService $pageGallery, ImageController $imageController)
    {
        $this->pageGallery=$pageGallery;
        $this->imageController=$imageController;
    }
    public function index($id)
    {
        $galleries=$this->pageGallery->paginate($id);
        $show_search='yes';
        $page_id=$id;
        return view('super-admin.page.gallery.index',compact('galleries','show_search','page_id'));
    }
    public function create($id)
    {
        $page_id=$id;
        return view('super-admin.page.gallery.create',compact('page_id'));
    }
    public function store(Request $request)
    {
        foreach ($request->file('image') as $file) {
            $rules = array(
                'image' => 'required|mimes:jpeg,jpg,png,gif'
            );
            $validator = validator(array('image' => $file), $rules);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }
            $galleryInfo = $request->all();
            $galleryInfo['slug'] = Str::slug($request->get('title'));
            $galleryInfo['order'] = DbHelper::nextSortOrder('page_galleries');
            $galleryInfo['page_id'] = $request->get('page_id');
            $folder_name = 'PageGallery';
            $ImgName = $this->imageController->saveGallery($file, $folder_name,900,600);
            $galleryInfo['title'] = trim(strip_tags(DbHelper::fileName($file->getClientOriginalName())));
            $galleryInfo['image'] = $ImgName;
            $this->pageGallery->create($galleryInfo);
        }
        Toastr::success('Page Gallery created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('page.index');
    }
    public function edit($id,$pageId)
    {
        $gallery=$this->pageGallery->find($id);
        $page_id=$pageId;
        return view('super-admin.page.gallery.edit',compact('gallery','page_id'));
    }
    public function update(PageGalleryRequest $request, $id)
    {
        $galleryInfo=$request->all();
        $galleryInfo['slug'] = Str::slug($request->get('title'));
        $album=$this->pageGallery->find($id);
        $folder_name='PageGallery';
        if($request->file('image')==''){
            $galleryInfo['image']=$album->image;
        }
        else{
            $this->imageController->deleteImg($folder_name,$album->image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',900,600);
            $galleryInfo['image']=$ImgName;
        }
        if($this->pageGallery->update($id, $galleryInfo)){
            Toastr::success('Page Gallery updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('page.index');
        }else{
            Toastr::error('Problem in updating gallery gallery', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('page.index');
        }
    }
    public function destroy($id)
    {
        $gallery=$this->pageGallery->find($id);
        if($this->pageGallery->delete($id)){
            $this->imageController->deleteImg('PageGallery',$gallery->image);
            Toastr::success('Page Gallery deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('page.index');
        }else{
            Toastr::error('Problem in deleting activity gallery', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('page.index');
        }
    }
    public function search()
    {
        $galleries=$this->pageGallery->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.page.gallery.index',compact('galleries','show_search'));
    }
}
