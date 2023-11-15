<?php

namespace App\Http\Controllers\SuperAdmin\Page;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Page\PageRequest;
use App\Models\Service\SuperAdmin\Menu\NavService;
use App\Models\Service\SuperAdmin\Page\PageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;
use App\Helpers\DbHelper as DbHelper;

class PageController extends Controller
{
    protected $page;
    protected $imageController;
    function __construct(PageService $page, ImageController $imageController)
    {
        $this->page=$page;
        $this->imageController=$imageController;
    }

    public function index()
    {
        $pages=$this->page->paginate();
        $parents=$this->page->all();
        $show_search='yes';
        return view('super-admin.page.index',compact('pages','parents','show_search'));
    }
    public function parent($id)
    {
        $pages=$this->page->parentPaginate($id);
        $parents=$this->page->all();
        $show_search='yes';
        $parentId=$id;
        return view('super-admin.page.index',compact('pages','parents','show_search','parentId'));
    }
    public function create($id=NULL)
    {
        $parentId=$id;
        return view('super-admin.page.create',compact('parentId'));
    }

    public function store(PageRequest $request)
    {
        $pageInfo=$request->all();
        $pageInfo['slug'] = Str::slug($request->get('title'));
        $pageInfo['order']=DbHelper::nextSortOrder('pages');
        $folder_name='Page';
        if($request->file('image')){
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',368,425);
            $pageInfo['image']=$ImgName;
        }
        if($this->page->create($pageInfo)){
            Toastr::success('page created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('page.index');
        }else{
            Toastr::error('Problem in creating page', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('page.index');
        }
    }
    public function edit($id)
    {
        $page=$this->page->find($id);
        $parentId=$page->parent_id;
        return view('super-admin.page.edit',compact('page','parentId'));
    }
    public function update(PageRequest $request, $id)
    {
        $pageInfo=$request->all();
//        $pageInfo['slug'] = Str::slug($request->get('title'));
        $folder_name='Page';
        $page=$this->page->find($id);
        if($request->file('image')==''){
            if($request->get('delete_image')){
                $this->imageController->deleteImg($folder_name,$page->image);
                $pageInfo['image'] = NULL;
            }else {
                $pageInfo['image'] = $page->image;
            }
        }
        else{
            $this->imageController->deleteImg($folder_name,$page->image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',368,425);
            $pageInfo['image']=$ImgName;
        }
        if($this->page->update($id, $pageInfo)){
            Toastr::success('page updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('page.index');
        }else{
            Toastr::error('Problem in updating page', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('page.index');
        }
    }

    public function destroy($id)
    {
        $page=$this->page->find($id);
        if($this->page->delete($id)){
            $this->imageController->deleteImg('PageChild',$page->image);
            $this->imageController->deleteImg('Nav',$page->banner_image);
            Toastr::success('page deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('page.index');
        }else{
            Toastr::error('Problem in deleting page', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('page.index');
        }
    }
    public function search()
    {
        $pages=$this->page->search(str_slug($_GET['key']));
        $parents=$this->page->all();
        $show_search='yes';
        return view('super-admin.page.index',compact('pages','parents','show_search'));
    }
}
