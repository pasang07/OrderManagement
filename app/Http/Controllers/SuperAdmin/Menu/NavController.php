<?php

namespace App\Http\Controllers\SuperAdmin\Menu;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Menu\NavRequest;
use App\Models\Service\SuperAdmin\Menu\NavService;
use App\Models\Service\SuperAdmin\Page\PageService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\DbHelper as DbHelper;

class NavController extends Controller
{
    protected $nav;
    protected $page;
    protected $imageController;
    function __construct(NavService $nav, PageService $page, ImageController $imageController)
    {
        $this->nav=$nav;
        $this->page=$page;
        $this->imageController=$imageController;
    }

    public function index()
    {
        $navs=$this->nav->paginate();
        $parents=$this->nav->all();
        $show_search='no';
        return view('super-admin.menu.index',compact('navs','parents','show_search'));
    }
    public function parent($id)
    {
        $navs=$this->nav->parentPaginate($id);
        $parents=$this->nav->all();
        $show_search='no';
        $parentId=$id;
        return view('super-admin.menu.index',compact('navs','parents','show_search','parentId'));
    }

    public function create($id=NULL)
    {
        $pages=$this->page->all();
        $parentId=$id;
        return view('super-admin.menu.create',compact('pages','parentId'));
    }

    public function store(NavRequest $request)
    {
        $navInfo=$request->all();
        $navInfo['slug'] = Str::slug($request->get('title'));
        if($request->get('type_id')) {
            $navInfo['url'] = $this->createUrl($request->get('type'), $request->get('type_id'));
        }
        else
        {
            $navInfo['url']=$request->get('url');
        }

        $folder_name='Nav';
        if($request->file('image')){
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',50,50);
            $navInfo['image']=$ImgName;

        }
        $navInfo['order']=DbHelper::nextSortOrder('navs');
        if($this->nav->create($navInfo)){
            Toastr::success('Nav created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('nav.index');
        }else{
            Toastr::error('Problem in creating nav', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('nav.index');
        }
    }
    public function createUrl($type,$type_id)
    {
        if (in_array($type, array('pages', 'software', 'amenities'))) {
            $url='';
            $data = DB::table($type)->where('id', $type_id)->take(1)->first(array('slug'));
            switch ($type) {
                case "pages":
                    $url = 'page/' . $data->slug;
                    break;
                case "software":
                    $url = 'software/' . $data->slug;
                    break;
                case "amenities":
                    $url = 'service/' . $data->slug;
                    break;
            }
            return $url;
        }
    }
    public function edit($id)
    {
        $nav=$this->nav->find($id);
        $pages=$this->page->all();
        $parentId=$nav->parent_id;
        return view('super-admin.menu.edit',compact('nav','pages','parentId'));
    }

    public function update(NavRequest $request, $id)
    {
        $navInfo=$request->all();
        $navInfo['slug'] = Str::slug($request->get('title'));
        $nav=$this->nav->find($id);
        if($request->get('type_id')) {
            $navInfo['url'] = $this->createUrl($request->get('type'), $request->get('type_id'));
        }
        else
        {
            $navInfo['url']=$request->get('url');
        }
        $folder_name='Nav';

        if($request->file('image')==''){
            if($request->get('delete_image')){
                $this->imageController->deleteImg($folder_name,$nav->image);
                $navInfo['image'] = NULL;
            }else {
                $navInfo['image'] = $nav->image;
            }
        }
        else{
            $this->imageController->deleteImg($folder_name,$nav->image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',50,50);
            $navInfo['image']=$ImgName;
        }
        if($this->nav->update($id, $navInfo)){
            Toastr::success('Nav updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('nav.index');
        }else{
            Toastr::error('Problem in updating nav', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('nav.index');
        }
    }
    public function destroy($id)
    {
        $nav=$this->nav->find($id);
        if($this->nav->delete($id)){
            $this->imageController->deleteImg('Nav',$nav->image);
            Toastr::success('Nav deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('nav.index');
        }else{
            Toastr::error('Problem in deleting nav', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('member.index');
        }
    }
    public function search()
    {
        $navs=$this->nav->search(str_slug($_GET['key']));
        $parents=$this->nav->all();
        $show_search='no';
        return view('super-admin.menu.index',compact('navs','parents','show_search'));
    }
    public function ChangeTypeCreate(Request $request)
    {
        $type = $request->get('type');
        return view('super-admin.menu.nav-type', compact('type'));
    }
    public function ChangeTypeUpdate(Request $request)
    {
        $type = $request->get('type');
        return view('super-admin.menu.nav-type-edit', compact('type'));
    }


}
